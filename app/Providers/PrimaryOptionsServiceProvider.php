<?php

namespace App\Providers;

use App\Models\PrimaryOption;
use Illuminate\Support\ServiceProvider;

class PrimaryOptionsServiceProvider extends ServiceProvider
{
    protected $options;

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
        $this->app->bind('primary_option', PrimaryOption::class);
    }
}
