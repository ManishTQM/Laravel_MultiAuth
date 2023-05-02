<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailSettingTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_setting_tables', function (Blueprint $table) {
            $table->id();
            $table->string('mail_mailer');
            $table->string('mail_host');
            $table->integer('mail_port');
            $table->string('mail_username');
            $table->string('mail_password');
            $table->string('mail_from');
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
        Schema::dropIfExists('mail_setting_tables');
    }
}
