<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;

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
        \App\Approval::observe(\App\Observers\ApprovalObserver::class);
        \App\Denial::observe(\App\Observers\DenialObserver::class);

        Blade::include('includes.field', 'field');
        Blade::include('includes.checkbox', 'checkbox');
        Blade::include('includes.textarea' , 'textarea' );
        Blade::component('includes.select' , 'select');

        Paginator::defaultView('components.paginate');
        Paginator::defaultSimpleView('components.simple-paginate');
    }
}
