<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameMailSettingTablesToMailsetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mailsetting', function (Blueprint $table) {
            //
        });
        Schema::rename('mail_setting_tables', 'mailsetting');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mailsetting', function (Blueprint $table) {
            //
        });
    }
}
