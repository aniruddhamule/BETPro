<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropSmtpEncryptionFromGeneralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('generals', function (Blueprint $table) {
            $table->text('email_configuration')->nullable();
            $table->dropColumn('email_method')->nullable();
            $table->dropColumn('smtp_host')->nullable();
            $table->dropColumn('smtp_port')->nullable();
            $table->dropColumn('smtp_encryption')->nullable();
            $table->dropColumn('smtp_username')->nullable();
            $table->dropColumn('smtp_password')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('generals', function (Blueprint $table) {
            //
        });
    }
}
