<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKodeToMerchants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('Merchant', 'Kode')) {
            Schema::table('Merchant', function (Blueprint $table) {
                $table->string('Kode')->nullable();
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
        if (Schema::hasColumn('Merchant', 'Kode')) {
            Schema::table('Merchant', function (Blueprint $table) {
                $table->dropColumn('Kode');
            });
        }
    }
}
