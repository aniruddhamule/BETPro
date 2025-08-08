<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhotoSliderSwitchToSectionBtnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('section_btns', function (Blueprint $table) {
            $table->boolean('photo_slider_switch')->default(1)->comment('1 = Active, 0 = Deactive');
            $table->boolean('leaderboard_switch')->default(1)->comment('1 = Active, 0 = Deactive');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('section_btns', function (Blueprint $table) {
            //
        });
    }
}
