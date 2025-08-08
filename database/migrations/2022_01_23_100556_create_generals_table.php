<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generals', function (Blueprint $table) {
            $table->id();
            $table->string('web_name',50)->default('Casino And Game')->nullable();
            $table->string('color_code',50)->default('#fff')->nullable();
            $table->string('contact_address')->default('Berlin,Germany')->nullable();
            $table->string('contact_email')->default('support@example.com')->nullable();
            $table->string('contact_phone')->default('0123654789')->nullable();
            $table->string('currency')->default('USD')->nullable();
            $table->string('about_title')->nullable();
            $table->string('about_section_title')->nullable();
            $table->longText('about_description')->nullable();
            $table->string('news_title')->nullable();
            $table->longText('news_subtitle')->nullable();
            $table->string('testimonial_title')->nullable();
            $table->longText('testimonial_subtitle')->nullable();
            $table->string('contact_title')->nullable();
            $table->longText('contact_subtitle')->nullable();
            $table->string('copyright_text',255)->default('All Rights Reserved')->nullable();
            $table->text('footer_text')->nullable();
            $table->string('sender_email')->nullable();
            $table->string('sender_email_name')->nullable();
            $table->longText('email_description')->nullable();
            $table->string('email_method')->nullable();
            $table->string('smtp_host')->nullable();
            $table->string('smtp_port')->nullable();
            $table->string('smtp_encryption')->nullable();
            $table->string('smtp_username')->nullable();
            $table->string('smtp_password')->nullable();
            $table->string('global_email')->nullable();
            $table->longText('global_description')->nullable();
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
        Schema::dropIfExists('generals');
    }
}
