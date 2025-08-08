<?php

namespace Database\Seeders;

use App\Models\General;
use Illuminate\Database\Seeder;

class GeneralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        General::create([
            "web_name" => "Casino",
            "currency" => "USD",
            "sender_email" => "support@mail.com",
            "sender_email_name" => "Casino",
            "email_description" => "Hi {{name}}, {{message}} , Thank you",
            "email_method" => "smtp",
            "smtp_host" => "smtp.mailtrap.io",
            "smtp_port" => "2525",
            "smtp_encryption" => "tls",
            "smtp_username" => "2fc648963bb000",
            "smtp_password" => "a868720db21c21",
            "global_email" => "support@mail.com",
            "global_description" => "Hi {{name}}, {{message}} , Thank you"
        ]);
    }
}
