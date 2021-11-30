<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixForeignKeyToMember extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE [dbo].[Member] DROP CONSTRAINT [FK_Member_Member]');
        DB::statement('ALTER TABLE [dbo].[Member]  WITH CHECK ADD CONSTRAINT [FK_Member_Member] FOREIGN KEY([IdMerhant]) REFERENCES [dbo].[Merchant] ([Id])');
        DB::statement('ALTER TABLE [dbo].[Member] CHECK CONSTRAINT [FK_Member_Member]');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE [dbo].[Member] DROP CONSTRAINT [FK_Member_Member]');
        DB::statement('ALTER TABLE [dbo].[Member]  WITH CHECK ADD CONSTRAINT [FK_Member_Member] FOREIGN KEY([IdMerhant]) REFERENCES [dbo].[Merchant] ([Id])');
        DB::statement('ALTER TABLE [dbo].[Member] CHECK CONSTRAINT [FK_Member_Member]');
    }
}
