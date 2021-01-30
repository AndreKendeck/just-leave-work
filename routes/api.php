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
    ->middleware(['throttle:10,60']);
    Route::post('/register', 'RegisterController@register')->name('register');

    Route::post('/verify-email', 'VerifyEmailController@verify')->name('verify.email');
    Route::get('/resend-code', 'VerifyEmailController@resend')->name('verify.resend')
        ->middleware(['throttle:4,60']);

    Route::middleware(['auth:sanctum', 'logs-out-banned-user', 'verified'])->group(function () {
        Route::apiResource('leaves', 'LeaveController')->parameters([
            'leaves' => 'id'
        ]);
        Route::apiResource('comments', 'CommentController')
            ->parameters([
                'comments' => 'id'
            ])
            ->except('index');

        Route::apiResource('users', 'UserController')->parameters([
            'users' => 'id'
        ]);

        Route::post('/leaves/approve/{id}', 'LeaveStatusController@approve')
            ->name('leaves.approve')->middleware(['permission:can-approve-leave']);
        Route::post('/leave/deny/{id}', 'LeaveStatusController@deny')
            ->name('leaves.deny')->middleware(['permission:can-deny-leave']);
        Route::get('/settings', 'SettingController@index')->name('settings');
        Route::post('/settings/update', 'SettingController@update')
            ->name('settings.update');
        Route::get('/team', 'TeamController@index')->name('team');
        Route::post('/team/update', 'TeamController@update')->name('team.update')
            ->middleware(['role:team-admin']);
    });
});
