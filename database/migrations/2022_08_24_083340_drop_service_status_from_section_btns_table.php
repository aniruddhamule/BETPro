<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropServiceStatusFromSectionBtnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('section_btns', function (Blueprint $table) {
            $table->dropColumn('status')->default(1)->comment('1 = Active, 0 = Deactive');
            $table->boolean('service_switch')->default(1)->comment('1 = Active, 0 = Deactive');
            $table->boolean('about_switch')->default(1)->comment('1 = Active, 0 = Deactive');
            $table->boolean('testimonial_switch')->default(1)->comment('1 = Active, 0 = Deactive');
            $table->boolean('news_switch')->default(1)->comment('1 = Active, 0 = Deactive');
            $table->boolean('game_switch')->default(1)->comment('1 = Active, 0 = Deactive');
            $table->boolean('event_switch')->default(1)->comment('1 = Active, 0 = Deactive');
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
