<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBetInvestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bet_invests', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('match_id')->nullable();
            $table->integer('betquestion_id')->nullable();
            $table->integer('betoption_id')->nullable();
            $table->decimal('invest_amount', 11,2)->default(0.00)->nullable();
            $table->decimal('return_amount', 11,2)->default(0.00);
            $table->decimal('charge', 11,2)->default(0.00)->nullable();
            $table->decimal('remaining_balance', 11,2)->default(0.00)->nullable();
            $table->string('ratio')->nullable();
            $table->boolean('status')->default(0)->comment('default 0, win 1, lose -1, refund 2');
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
        Schema::dropIfExists('bet_invests');
    }
}
