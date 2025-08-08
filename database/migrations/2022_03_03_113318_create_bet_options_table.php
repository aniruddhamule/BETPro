<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBetOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bet_options', function (Blueprint $table) {
            $table->id();
            $table->integer('question_id');
            $table->integer('match_id');
            $table->text('option_name')->nullable();
            $table->string('invest_amount')->default(0.001)->nullable();
            $table->string('return_amount')->default(0.001)->nullable();
            $table->string('min_amo')->default(0.001)->nullable();
            $table->text('ratio1')->nullable();
            $table->text('ratio2')->nullable();
            $table->decimal('bet_limit', 8,2)->default(2000.00)->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('bet_options');
    }
}
