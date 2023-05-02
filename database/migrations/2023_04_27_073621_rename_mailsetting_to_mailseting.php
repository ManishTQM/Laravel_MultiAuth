<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameMailsettingToMailseting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mailseting', function (Blueprint $table) {
            //
        });
        Schema::rename('mailsetting', 'mailseting');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mailseting', function (Blueprint $table) {
            //
        });
    }
}
