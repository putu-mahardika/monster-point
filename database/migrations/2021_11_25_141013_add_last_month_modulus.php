<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLastMonthModulus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('billing', 'sisa')) {
            Schema::table('billing', function (Blueprint $table) {
                $table->float('sisa')->nullable();
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
        if (Schema::hasColumn('billing', 'sisa')) {
            Schema::table('billing', function (Blueprint $table) {
                $table->dropColumn('sisa');
            });
        }
    }
}
