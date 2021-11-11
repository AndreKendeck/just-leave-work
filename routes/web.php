<?php

use Illuminate\Support\Facades\Route;

// Route::get('/password-reset/{token}', 'Api\PasswordResetController@show')->name('password.reset');
// Route::view('/{any}', 'index');
// Route::view('/{any}/{path}', 'index');
// Route::view('/{any}/{path}/{id}', 'index');
// Route::view('/', 'index');

// admin routes
Route::domain("admin." . env('APP_DOMAIN'))->group(function () {
    Route::namespace ('Admin')->group(function () {
        Route::view('/login', 'admin.auth.login')->name('admin.login');
        Route::post('/login', 'Auth\LoginController@login')->name('admin.post.login');
        Route::get('/', 'DashboardController')->name('admin.index');
    });
});
