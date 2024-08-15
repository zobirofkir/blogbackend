<?php

namespace App\Providers;

use App\Services\BlogService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Passport::ignoreRoutes();

        // Bind UserService
        $this->app->bind(UserService::class, function($app) {
            return new UserService();
        });

        // Bind BlogService
        $this->app->bind(BlogService::class, function($app) {
            return new BlogService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
