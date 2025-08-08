<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropServiceSwitchFromGeneralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('generals', function (Blueprint $table) {
            $table->dropColumn('service_switch')->default(1)->comment('1 = Active, 0 = Deactive');
            $table->dropColumn('about_switch')->default(1)->comment('1 = Active, 0 = Deactive');
            $table->dropColumn('testimonial_switch')->default(1)->comment('1 = Active, 0 = Deactive');
            $table->dropColumn('news_switch')->default(1)->comment('1 = Active, 0 = Deactive');
            $table->dropColumn('game_switch')->default(1)->comment('1 = Active, 0 = Deactive');
            $table->dropColumn('event_switch')->default(1)->comment('1 = Active, 0 = Deactive');
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
