<?php

namespace App\Providers;

use Illuminate\Contracts\Routing\UrlGenerator as RoutingUrlGenerator;

use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if(env('REDIRECT_HTTPS')){
           $this->app['request']->serve->set('HTTPS', true);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(RoutingUrlGenerator $url)
    {
        if(env('REDIRECT_HTTPS')){
            $url -> formatScheme('https://');
        }
    }
}
