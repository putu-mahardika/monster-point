<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailChangeVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_change_verifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->index();
            $table->string('token')->unique();
            $table->string('old_email')->index();
            $table->string('new_email')->index();
            $table->dateTime('verified_at')->nullable();
            $table->dateTime('expired_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_change_verifications');
    }
}
