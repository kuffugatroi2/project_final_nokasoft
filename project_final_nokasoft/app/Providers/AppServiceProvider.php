<?php

namespace App\Providers;

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
        $this->app->bind(
            'App\Repositories\Admin\AdminRepositoryInterface',
            'App\Repositories\Admin\AdminRepository'
        );
        $this->app->bind(
            'App\Repositories\Brand\BrandRepositoryInterface',
            'App\Repositories\Brand\BrandRepository'
        );
        $this->app->bind(
            'App\Repositories\Category\CategoryRepositoryInterface',
            'App\Repositories\Category\CategoryRepository'
        );
    }
}
