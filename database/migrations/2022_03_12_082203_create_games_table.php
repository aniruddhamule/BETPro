<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->text('rules');
            $table->string('min');
            $table->string('max');
            $table->string('rate1')->nullable();
            $table->string('rate2')->nullable();
            $table->string('rate3')->nullable();
            $table->string('rate4')->nullable();
            $table->string('rate5')->nullable();
            $table->string('rate6')->nullable();
            $table->string('rate7')->nullable();
            $table->string('rate8')->nullable();
            $table->string('rate9')->nullable();
            $table->string('rate10')->nullable();
            $table->integer('auto')->nullable();
            $table->integer('base')->nullable();
            $table->integer('option')->nullable();
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
        Schema::dropIfExists('games');
    }
}
