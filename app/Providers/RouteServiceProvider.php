<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapAdminRoutes();

        $this->mapUserRoutes();

        $this->mapWebRoutes();

        $this->ipnRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware(['web', 'HtmlMinifier'])
            ->group(base_path('routes/web.php'));
    }

    protected function mapAdminRoutes()
    {
        Route::middleware(['web', 'HtmlMinifier'])
            ->group(base_path('routes/admin.php'));
    }

    protected function mapUserRoutes()
    {
        Route::middleware(['web', 'HtmlMinifier'])
            ->group(base_path('routes/user.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->as('api.')
            ->middleware('api')
            ->group(base_path('routes/api.php'));
    }

    protected function ipnRoutes()
    {
    }

    public function configureRateLimiting()
    {
        RateLimiter::for('sitemap', function ($request) {
            return Limit::perMinute(2);
        });
    }
}
