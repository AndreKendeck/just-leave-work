<?php

namespace App\Providers;

use App\Leave;
use App\Team;
use App\User;
use Carbon\Carbon;
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
        User::observe(\App\Observers\UserObserver::class);
        Team::observe(\App\Observers\TeamObserver::class);
        Leave::observe(\App\Observers\LeaveObserver::class);
    }
}
