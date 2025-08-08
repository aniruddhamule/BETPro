<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trxes', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->default(0);
            $table->integer('refer_id')->default(0);
            $table->decimal('amount', 11,2)->default(0.00)->nullable();
            $table->decimal('main_amo', 11,2)->default(0.00)->nullable();
            $table->decimal('charge', 11,2)->default(0.00)->nullable();
            $table->string('type')->default('+');
            $table->string('title')->nullable();
            $table->string('trx')->nullable();
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
        Schema::dropIfExists('trxes');
    }
}
