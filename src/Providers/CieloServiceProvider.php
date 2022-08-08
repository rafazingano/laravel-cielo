<?php

namespace ConfrariaWeb\Cielo\Providers;

use ConfrariaWeb\Cielo\Services\CieloService;
use Illuminate\Support\ServiceProvider;

class CieloServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/../../config/cw_cielo.php' => config_path('cw_cielo.php')], 'config');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('CieloService', function ($app) {
            return new CieloService();
        });
    }

}
