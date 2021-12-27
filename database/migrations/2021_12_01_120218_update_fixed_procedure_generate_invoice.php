<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFixedProcedureGenerateInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = "
            CREATE OR ALTER PROCEDURE sp_CreateInvoice
                @IdBilling BIGINT,
                @date_start DATETIME,
                @date_end DATETIME,
                @kodeMerchant VARCHAR(10)
            AS
            DECLARE
                @noInvoice VARCHAR(150),
                @str_date_end VARCHAR(150),
                @random_str VARCHAR(4)

            BEGIN
                SET @str_date_end =
                (
                    SELECT CONVERT(VARCHAR(6),@date_end,112)
                );
                SET @random_str =
                (
                    SELECT LEFT(REPLACE(NEWID(),'-',''),4)
                );

                SET @noInvoice =
                (
                    SELECT CONCAT('MP', '/','INV', '/', @str_date_end, '/', @kodeMerchant, '/', @random_str)
                );

                    INSERT INTO dbo.invoice
                    (
                        no_invoice,
                        billing_id,
                        date_start,
                        date_end,
                        created_at,
                        updated_at
                    )
                    VALUES
                    (
                        @noInvoice,
                        @IdBilling,
                        @date_start,
                        @date_end,
                        GETDATE(),
                        GETDATE()
                    )
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
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_CreateInvoice');
    }
}
