<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::namespace('Api')->group(function () {

    Route::post('/login', 'LoginController@login')->name('login')
        ->middleware(['throttle:10,60', 'guest']);
    Route::post('/register', 'RegisterController@register')->name('register')
        ->middleware(['guest']);

    Route::post('/verify-email', 'VerifyEmailController@verify')
        ->name('verify.email')->middleware(['auth:sanctum']);
    Route::get('/resend-code', 'VerifyEmailController@resend')->name('verify.resend')
        ->middleware(['throttle:4,60', 'auth:sanctum']);

    Route::get('/profile', 'ProfileController@index')
        ->name('profile.index')->middleware('auth:sanctum');
        
    Route::middleware(['auth:sanctum', 'logs-out-banned-user', 'verified'])->group(function () {

        Route::get('/reasons', 'ReasonController')->name('reasons.index');
        Route::apiResource('leaves', 'LeaveController')->parameters([
            'leaves' => 'id',
        ]);
        Route::apiResource('comments', 'CommentController')
            ->parameters([
                'comments' => 'id',
            ])
            ->except('index');

        Route::apiResource('users', 'UserController')->parameters([
            'users' => 'id',
        ]);

        Route::post('/users/import', 'ImportUserController@import')
            ->name('users.import');

        Route::post('/leaves/add/', 'LeaveBalanceController@add')
            ->name('leaves.add');

        Route::post('/leaves/deduct', 'LeaveBalanceController@remove')
            ->name('leaves.deduct');

        Route::post('/leaves/approve/{id}', 'LeaveStatusController@approve')
            ->name('leaves.approve');
        Route::post('/leaves/deny/{id}', 'LeaveStatusController@deny')
            ->name('leaves.deny');

        Route::get('/settings', 'SettingController@index')->name('settings');
        Route::post('/settings', 'SettingController@update')
            ->name('settings.update');

        Route::get('/team', 'TeamController@index')->name('team');
        Route::post('/team/update', 'TeamController@update')->name('team.update');
    });
});
