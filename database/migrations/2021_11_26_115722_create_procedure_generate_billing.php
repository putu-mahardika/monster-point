<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProcedureGenerateBilling extends Migration
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
                @prev_month_hit INT
            BEGIN
                SET	@guid = NEWID();	 -- generate GUID
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
                    CreateDate
                        BETWEEN
                            CAST(CAST(DATEADD(day,-30,GETDATE()) AS DATE) AS DATETIME)					-- get data dari h-30 00:00:00
                        AND
                            CAST(CAST(GETDATE() AS DATE) AS DATETIME);									-- get data sampai h 00:00:00

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
                                0,                          -- TotalBiaya
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
