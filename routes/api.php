<?php

use Illuminate\Support\Facades\Route;

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

Route::namespace ('Api')->group(function () {

    Route::post('/login', 'LoginController@login')->name('login')
        ->middleware(['throttle:10,60', 'guest']);
    Route::get('/countries', 'CountryController')->name('countries');
    Route::post('/register', 'RegisterController@register')->name('register')
        ->middleware(['guest']);

    Route::post('/verify-email', 'VerifyEmailController@verify')
        ->name('verify.email')->middleware(['auth:sanctum']);
    Route::post('/resend-code', 'VerifyEmailController@resend')->name('verify.resend')
        ->middleware(['throttle:4,60', 'auth:sanctum']);

    Route::get('/profile', 'ProfileController@index')
        ->name('profile.index')->middleware('auth:sanctum');

    Route::put('/profile', 'ProfileController@update')
        ->name('profile.update')->middleware('auth:sanctum');

    Route::post('/password-email', 'PasswordEmailController')->name('password.request');
    Route::post('/check-password-reset-token', 'CheckPasswordResetController')->name('password.token.check');
    Route::post('/reset-password', 'PasswordResetController@store')->name('api.password.reset');

    Route::post('/logout', 'LogoutController')
        ->name('logout')
        ->middleware('auth:sanctum');
    Route::post('/update-password', 'UpdatePasswordController')
        ->name('update.password')
        ->middleware('auth:sanctum');

    Route::middleware(['auth:sanctum', 'forbid-banned-user', 'verified'])->group(function () {

        Route::get('/reasons', 'ReasonController')->name('reasons.index');
        Route::apiResource('leaves', 'LeaveController')
            ->except('update')
            ->parameters([
                'leaves' => 'id',
            ]);
        Route::apiResource('comments', 'CommentController')
            ->parameters([
                'comments' => 'id',
            ])
            ->except('index');

        Route::apiResource('users', 'UserController')->parameters([
            'users' => 'id',
        ])->except('destroy');
        Route::post('/user/ban/{id}', 'BanUserController@store')->name('users.ban');
        Route::post('/user/unban/{id}', 'BanUserController@update')->name('users.unban');

        Route::post('/users/import', 'ImportUserController@import')
            ->name('users.import');

        Route::get('/my-leaves', 'MyLeaveController');

        Route::post('/leaves/add/', 'LeaveBalanceController@add')
            ->name('leaves.add');

        Route::post('/leaves/deduct', 'LeaveBalanceController@deduct')
            ->name('leaves.deduct');

        Route::post('/leaves/approve/{id}', 'LeaveStatusController@approve')
            ->name('leaves.approve');
        Route::post('/leaves/deny/{id}', 'LeaveStatusController@deny')
            ->name('leaves.deny');

        Route::get('/settings', 'SettingController@index')->name('settings');
        Route::put('/settings', 'SettingController@update')
            ->name('settings.update');

        Route::get('/team', 'TeamController@index')->name('team');
        Route::post('/team/update', 'TeamController@update')->name('team.update');
        Route::get('/team/admins', 'AdminUserController')->name('admins.index');
        Route::get('/transactions/{userId}', 'TransactionController@index')->name('transactions.index');
        Route::get('/leaves/export/{month?}/{year?}', 'ExportLeaveController')->name('leaves.export');
        Route::get('/transactions/export/{user}/{month?}/{year?}', 'ExportTransactionController')->name('transactions.export');
    });
});
