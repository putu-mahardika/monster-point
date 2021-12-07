<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRemoveInvoiceInProcedureGenerateBilling extends Migration
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
                @dateStart DATETIME,
                @dateEnd DATETIME,
                @countBilling INT,
                @IdBilling BIGINT,
                @KodeMerchant VARCHAR(10),
                @noInvoice VARCHAR(150),
				@countAllBilling INT,
				@str_date_end VARCHAR(150),
                @random_str VARCHAR(4),
				@jatuhTempo DATETIME,
				@expired INT

        BEGIN
			SET @countAllBilling =
			(
				SELECT COUNT(*) FROM Billing where IdMerchant = @idMerchant
			);

			IF @countAllBilling != 0
				BEGIN
					 SET @dateStart =		-- get tgl bulan lalu 00:00:00
					 (
						SELECT CAST(CAST(DATEADD(day, 1, (SELECT TOP 1 date_end FROM Billing WHERE IdMerchant = @idMerchant ORDER BY Id DESC)) AS DATE) AS DATETIME)
					 );
				END
			ELSE
				BEGIN
					SET @dateStart =		-- get date_end bulan +1 lalu 00:00:00
					(
						SELECT CAST(CAST(DATEADD(day,0,DATEADD(month, -1, GETDATE())) AS DATE) AS DATETIME)
					);
				END


            SET @dateEnd =			-- get tgl h-1 23:59:59
            (
                SELECT CAST(CAST(DATEADD(day,-1,GETDATE()) AS DATE) AS DATETIME) + '23:59:59'
            );

			SET @expired =
			(
				CONVERT(INT, (SELECT Value FROM dbo.GlobalSetting WHERE Kode = 'Expired'))
			);

			SET @jatuhTempo =
			(
				SELECT CAST(CAST(DATEADD(day,@expired,GETDATE()) AS DATE) AS DATETIME)
			);

            SET @countBilling =				 -- cek jika invoice periode sekarang sudah dibuat atau belum
            (
                SELECT COUNT(*) FROM Billing WHERE IdMerchant = @idMerchant AND date_start = @dateStart AND date_end = @dateEnd
            );

            IF @countBilling < 1			 -- jika invoice belum dibuat
                BEGIN
                    SET	@guid = NEWID();	 -- generate GUID
                    SET @KodeMerchant =
                    (
                        SELECT Kode FROM Merchant WHERE Id = @idMerchant		-- get Kode Merchant
                    );
					SET @str_date_end =
					(
						SELECT CONVERT(VARCHAR(6),@dateEnd,112)				-- get bulan tahun dari date end
					);
					SET @random_str =
					(
						SELECT LEFT(REPLACE(NEWID(),'-',''),4)					-- generate random str (4)
					);
					SET @noInvoice =
					(
						SELECT CONCAT('MP', '/','INV', '/', @str_date_end, '/', @kodeMerchant, '/', @random_str)	-- create no. invoice
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
                        CreateDate BETWEEN @dateStart AND @dateEnd										-- get data dari h-31 00:00:00 sampai h-1 23:59:59

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
									InvoiceNumber,
                                    IdMerchant,
                                    TotalHit,
                                    TotalSukses,
                                    TotalGagal,
                                    TotalBiaya,
                                    Terbayar,
                                    sisa,
									date_start,
									date_end,
									JatuhTempo
                                )
                                VALUES
                                (
                                    @guid,						-- Guid
                                    GETDATE(),					-- CreateDate
									@noInvoice,
                                    @idMerchant,				-- IdMerchant
                                    @totalHit,					-- TotalHit
                                    @totalSukses,				-- TotalSukses
                                    @totalGagal,				-- TotalGagal
                                    @totalBiaya,				-- TotalBiaya
                                    0,							-- Terbayar
                                    @sisa,						-- sisa
									@dateStart,				-- date_start
									@dateEnd,					-- date_end
									@jatuhTempo					-- JatuhTempo
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
                                    sisa,
									date_start,
									date_end
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
                                    @sisa,						-- sisa
									@dateStart,				-- date_start
									@dateEnd					-- date_end
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
