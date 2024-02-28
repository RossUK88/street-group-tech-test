<?php

namespace App\Providers;

use App\Helpers\HomeOwner;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind('home-owner', function ($app) {
            return new HomeOwner();
        });
    }
}
