<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposit_requests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('deposit_id');
            $table->bigInteger('user_id');
            $table->bigInteger('gateway_id');
            $table->string('r_img')->nullable();
            $table->string('payment_des')->nullable();
            $table->integer('status')->default(0)->comment('0 = pending, 1 = accepted, 2 = reject');
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
        Schema::dropIfExists('deposit_requests');
    }
}
