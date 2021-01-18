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
    Route::post('/login', 'LoginController@login')->name('login');
    Route::post('/register', 'RegisterController@register')->name('register');
    Route::get('/verify-email/{email}', 'VerifyEmailAddressController@verify')
        ->middleware('signed')
        ->name('verify');

    Route::middleware(['auth:sanctum', 'logs-out-banned-user'])->group(function () {
        Route::apiResource('leaves', 'LeaveController')->parameters([
            'leaves' => 'id'
        ]);
        Route::apiResource('comments', 'CommentController')
            ->parameters([
                'comments' => 'id'
            ])
            ->except('index');
        Route::post('/leaves/approve/{id}', 'LeaveStatusController@approve')
            ->name('leaves.approve')->middleware(['permission:can-approve-leave']);
        Route::post('/leave/deny/{id}', 'LeaveStatusController@deny')
            ->name('leaves.deny')->middleware(['permission:can-deny-leave']);
    });
});
