<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBetQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bet_questions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('match_id')->nullable();
            $table->string('question')->nullable();
            $table->boolean('result')->default(0);
            $table->bigInteger('limit')->default(5);
            $table->dateTime('end_time')->nullable();
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
        Schema::dropIfExists('bet_questions');
    }
}
