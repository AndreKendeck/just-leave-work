<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \App\Leave::observe(\App\Observers\LeaveObserver::class); 
        \App\Comment::observe(\App\Observers\CommentObserver::class); 
        \App\User::observe(\App\Observers\UserObserver::class); 
    }
}
