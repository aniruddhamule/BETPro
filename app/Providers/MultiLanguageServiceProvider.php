<?php

namespace App\Providers;

use App\Http\Middleware\ChangeLanguage;
use Illuminate\Support\ServiceProvider;

class MultiLanguageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('web', ChangeLanguage::class);
    }
}
