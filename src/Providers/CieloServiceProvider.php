<?php

namespace ConfrariaWeb\Field\Providers;

use ConfrariaWeb\Field\Services\FieldService;
use Illuminate\Support\ServiceProvider;

class FieldServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/../../config/cw_field.php' => config_path('cw_field.php')], 'config');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('FieldService', function ($app) {
            return new FieldService();
        });
    }

}
