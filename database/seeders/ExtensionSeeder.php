<?php

namespace Database\Seeders;

use App\Models\Extension;
use Illuminate\Database\Seeder;

class ExtensionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $extensions = [
            'tawkto-chat',
            'fb-comment',
            'google-recaptcha',
            'custom-captcha ',
        ];

        // $script = [
        //     '---',
        //     '---',
        //     '6LfFZHYeAAAAAL-8sbCqzigl9xWqMkXGPDG84Znc',
        // ];

        foreach ($extensions as $extension) {
            Extension::create([
                'act' => $extension,
                'name' => 'extension-name',
                'script' => '---', 
                'shortcode' => '{"app_key":{"title":"App Key","value":"----"}}', 
                'status' => 0,
            ]);
        }
    }
}
