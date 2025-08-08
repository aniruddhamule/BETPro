<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAboutSwitchToGeneralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('generals', function (Blueprint $table) {
            $table->boolean('service_switch')->default(1)->comment('1 = Active, 0 = Deactive');
            $table->boolean('about_switch')->default(1)->comment('1 = Active, 0 = Deactive');
            $table->boolean('testimonial_switch')->default(1)->comment('1 = Active, 0 = Deactive');
            $table->boolean('news_switch')->default(1)->comment('1 = Active, 0 = Deactive');
            $table->boolean('game_switch')->default(1)->comment('1 = Active, 0 = Deactive');
            $table->longText('game_section_title')->nullable();
            $table->boolean('event_switch')->default(1)->comment('1 = Active, 0 = Deactive');
            $table->longText('event_section_title')->nullable();
            $table->dropColumn('testimonial_subtitle')->nullable();
            $table->dropColumn('news_subtitle')->nullable();
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
