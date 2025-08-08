<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('tfver')->default(0)->nullable();
            $table->boolean('emailv')->default(0)->nullable();
            $table->string('vercode')->default(0)->nullable();
            $table->string('balance')->default(0);
            $table->integer('gender')->nullable()->comment('1 = Male & 0 = Female');
            $table->string('address')->nullable()->nullable();
            $table->string('zip_code')->nullable()->nullable();
            $table->string('city')->nullable()->nullable();
            $table->string('country')->nullable()->nullable();
            $table->string('vsent')->nullable();
            $table->string('secretcode')->default(0);
            $table->boolean('tauth')->default(0);
            $table->boolean('ref_id')->nullable();
            $table->string('referral_token')->nullable();
            $table->boolean('status')->default(1);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
