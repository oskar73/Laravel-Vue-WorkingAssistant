<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
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
        Blade::if('publishedModule', function ($expression) {
            $modules = is_array($expression)
                ? $expression
                : explode('|', $expression);

            return tenant()->hasAnyPublishModule($modules);
        });
        Blade::if('activeModule', function ($expression) {
            $modules = is_array($expression)
                ? $expression
                : explode('|', $expression);

            return tenant()->hasAnyActiveModule($modules);
        });
    }
}
