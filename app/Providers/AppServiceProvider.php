<?php

namespace App\Providers;

use App\Models\PersonalAccessToken;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }

        Paginator::useBootstrap();

        view()->composer('layouts.authApp',
            function ($view) {
                $basic = optional(option('basic', null));

                $view->with(['basic' => $basic]);
            });
        view()->composer('layouts.app',
            function ($view) {
                $basic = optional(option('basic', null));

                $seo['meta_title'] = $basic['seo_title'];
                $seo['meta_description'] = $basic['seo_description'];
                $seo['meta_keywords'] = $basic['seo_keywords'];
                $seo['meta_image'] = $basic['seo_image'];
                $seo['meta_type'] = 'website';

                $view->with(['basic' => $basic, 'seo' => $seo]);
            });
        view()->composer('layouts.master',
            function ($view) {
                $basic = optional(option('basic', null));
                $view->with(['basic' => $basic]);
            });

        view()->composer('*', function ($view) {
            $view_name = $view->getName();
            $tooltip = optional(option($view_name));

            $view->with(['tooltip' => $tooltip, 'view_name' => $view_name]);
        });
    }
}
