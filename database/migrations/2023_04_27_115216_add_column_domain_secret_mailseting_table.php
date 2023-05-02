<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDomainSecretMailsetingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mailseting', function($table) {
            $table->string('domain',250);
            $table->string('secret',250);
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mailseting', function($table) {
            $table->dropColumn('domain');
            $table->dropColumn('secret');
        });
    }
}
