<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFixedProcedureGenerateBilling extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = "
        CREATE OR ALTER PROCEDURE sp_GenerateBilling
        @idMerchant BIGINT
        AS
        DECLARE
                @guid UNIQUEIDENTIFIER,
                @totalHit INT,
                @totalSukses INT,
                @totalGagal INT,
                @totalBiaya FLOAT,
                @sisa FLOAT,
                @hitung_hit INT,
                @limit_hit INT,
                @price FLOAT,
                @prev_month_hit INT,
                @date_start DATETIME,
                @date_end DATETIME,
                @countInvoice INT,
                @IdBilling BIGINT,
                @KodeMerchant VARCHAR(10),
                @noInvoice VARCHAR(150)

        BEGIN
            SET @date_start =		-- get tgl bulan lalu 00:00:00
            (
                SELECT CAST(CAST(DATEADD(day,0,DATEADD(month, -1, GETDATE())) AS DATE) AS DATETIME)
            );

            SET @date_end =			-- get tgl h-1 23:59:59
            (
                SELECT CAST(CAST(DATEADD(day,-1,GETDATE()) AS DATE) AS DATETIME) + '23:59:59'
            );

            SET @countInvoice =				 -- cek jika invoice periode sekarang sudah dibuat atau belum
            (
                SELECT COUNT(*) FROM invoice WHERE date_start = @date_start AND date_end = @date_end
            );

            IF @countInvoice = 0			 -- jika invoice belum dibuat
                BEGIN
                    SET	@guid = NEWID();	 -- generate GUID
                    SET @KodeMerchant =
                    (
                        SELECT Kode FROM Merchant WHERE Id = @idMerchant
                    );
                    SET @limit_hit =		 -- get limit hit dari Global Settings
                    (
                        CONVERT(INT ,(SELECT Value FROM dbo.GlobalSetting WHERE Kode = 'Total Hit'))
                    );

                    SET @price =	 -- get price dari Global Settings
                    (
                        CONVERT(FLOAT, (SELECT Value FROM dbo.GlobalSetting WHERE Kode = 'Price'))
                    );

                    SELECT
                        @totalHit = COUNT(*),	-- get total hit bulan ini
                        @totalSukses = COUNT(CASE Status WHEN '200' THEN 1 ELSE null END),					-- get total hit sukses bulan ini
                        @totalGagal = COUNT(CASE Status WHEN '400' THEN 1 WHEN '500' THEN 1 ELSE null END)	-- get total hit gagal bulan ini
                    FROM Log
                    WHERE IdMerchant = @idMerchant
                        AND
                        CreateDate BETWEEN @date_start AND @date_end										-- get data dari h-31 00:00:00 sampai h-1 23:59:59

                    SET @prev_month_hit =		-- get sisa hit bulan lalu
                    (
                        SELECT
                            TOP 1
                            LAG(sisa,1) OVER (
                                ORDER BY Id
                            )
                        FROM Billing
                        WHERE IdMerchant = @idMerchant
                        ORDER BY Id DESC
                    );

                    IF @prev_month_hit IS NULL		-- jika bulan lalu tidak ada sisa hit
                        BEGIN
                            SET @hitung_hit = FLOOR(@totalSukses / @limit_hit);		-- hitung total hit sukses bulan ini / limit hit dari Global Settings
                            SET @sisa = @totalSukses % @limit_hit;					-- hitung sisa bagi
                        END
                    ELSE							-- jika bulan lalu ada sisa hit
                        BEGIN
                            SET @hitung_hit = FLOOR((@prev_month_hit+@totalSukses)/@limit_hit);		-- hitung (sisa hit bulan lalu + total hit sukses bulan ini) / limit hit dari Global Settings
                            SET @sisa = (@prev_month_hit + @totalSukses) % @limit_hit;				-- hitung sisa bagi
                        END;

                    IF @hitung_hit > 0		-- jika (total hit sukses bulan ini / limit hit dari Global Settings) > 0
                        BEGIN
                            SET @totalBiaya = @hitung_hit * @price;		-- hitung (total hit sukses bulan ini / limit hit dari Global Settings) * price dari Global Settings

                            INSERT INTO dbo.Billing
                                (
                                    Guid,
                                    CreateDate,
                                    IdMerchant,
                                    TotalHit,
                                    TotalSukses,
                                    TotalGagal,
                                    TotalBiaya,
                                    Terbayar,
                                    sisa
                                )
                                VALUES
                                (
                                    @guid,						-- Guid
                                    GETDATE(),					-- CreateDate
                                    @idMerchant,				-- IdMerchant
                                    @totalHit,					-- TotalHit
                                    @totalSukses,				-- TotalSukses
                                    @totalGagal,				-- TotalGagal
                                    @totalBiaya,				-- TotalBiaya
                                    0,							-- Terbayar
                                    @sisa						-- sisa
                                )

                            SET @IdBilling =
                            (
                                SELECT TOP 1 Id FROM Billing WHERE IdMerchant = @idMerchant ORDER BY Id DESC	-- get id billing untuk dimasukkan ke tabel invoice
                            );

                            EXEC dbo.sp_CreateInvoice @IdBilling = @IdBilling,									-- create invoice
                                                    @KodeMerchant = @KodeMerchant,
                                                    @date_start = @date_start,
                                                    @date_end = @date_end
                            SET @noInvoice =
                            (
                                SELECT TOP 1 no_invoice FROM invoice WHERE billing_id = @IdBilling ORDER BY no_invoice DESC			-- get nomer invoice untuk dimasukkan ke tabel billing
                            );

                            UPDATE Billing SET InvoiceNumber = @noInvoice WHERE InvoiceNumber = @noInvoice

                        END
                    ELSE
                        BEGIN
                            INSERT INTO dbo.Billing
                                (
                                    Guid,
                                    CreateDate,
                                    IdMerchant,
                                    TotalHit,
                                    TotalSukses,
                                    TotalGagal,
                                    TotalBiaya,
                                    Terbayar,
                                    sisa
                                )
                                VALUES
                                (
                                    @guid,						-- Guid
                                    GETDATE(),					-- CreateDate
                                    @idMerchant,				-- IdMerchant
                                    @totalHit,					-- TotalHit
                                    @totalSukses,				-- TotalSukses
                                    @totalGagal,				-- TotalGagal
                                    0,							-- TotalBiaya
                                    0,							-- Terbayar
                                    @sisa						-- sisa
                                )
                        END

                    /* show output prosedur yang sudah diinsert ke tabel billing */
                    SELECT
                        TOP 1 *,
                        LAG(sisa,1) OVER (
                                ORDER BY Id
                            ) AS SisaBulanLalu
                    FROM Billing
                    WHERE
                    IdMerchant = @idMerchant
                    ORDER BY Id DESC

                    SELECT
                        *
                    FROM invoice
                    WHERE
                    billing_id = @IdBilling
                END

        END
        ";
        DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_GenerateBilling');
    }
}
