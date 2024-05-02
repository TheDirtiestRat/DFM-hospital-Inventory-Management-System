<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
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
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();

        // Using view composer to set following variables globally
        view()->composer('*',function($view) {
            // $view->with('user', Auth::user());
            // $view->with('social', Social::all());
            // $view->with('categories_list', Category::all()); 
        });
    }
}
