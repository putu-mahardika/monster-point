<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveDateStartNDateEndInInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumns('invoice', ['date_start', 'date_end'])) {
            Schema::table('invoice', function (Blueprint $table) {
                $table->dropColumn('date_start');
                $table->dropColumn('date_end');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasColumn('invoice', ['date_start', 'date_end'])) {
            Schema::table('invoice', function (Blueprint $table) {
                $table->dateTime('date_start')->nullable();
                $table->dateTime('date_end')->nullable();
            });
        }
    }
}
