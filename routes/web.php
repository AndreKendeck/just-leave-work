<?php

Route::get('/', 'PagesController@index')->name('index');
Route::get('/about', 'PagesController@about')->name('about');
Route::get('/terms-and-conditions', 'PagesController@terms')->name('terms');
Route::get('/privacy-policy', 'PagesController@privacy')->name('privacy');
Route::get('/contact-us', 'PagesController@contact')->name('contact');

Auth::routes(['verify' => true]);


Route::domain('admin'.env('APP_DOMAIN'))->group(function () {
    // administration routes
    Route::middleware(['role:admin'])->group(function () {
        Route::namespace('Admin')->group(function () {
            Route::get('/bans', 'BanController@index')->name('admin.bans.index');
            Route::post('/ban', 'BanController@store')->name('admin.bans.store');
            Route::post('/unban', 'BanController@destroy')->name('admin.bans.delete');
            Route::get('/organizations', 'OrganizationController@index')->name('admin.organizations.index');
            Route::get('/oragnizations/{id}', 'OrganizationController@show')->name('admin.organizations.show');
        });
    });
});

Route::middleware([ 'auth' , 'verified' , 'forbid-banned-user' , 'logs-out-banned-user' , 'role:user' ])->group(function () {
    Route::get('/profile', 'UserProfileController@index')->name('profile');
    Route::post('/profile/update', 'UserProfileController@update')->name('profile.update');
    Route::get('/leave/create' , 'LeaveController@create' )->name('leaves.create'); 
    Route::get('/leaves', 'LeaveController@index')->name('leaves.index');
    Route::get('/users', 'UserController@index')->name('users.index');
    Route::post('/leave/store' , 'LeaveController@store' )->name('leaves.store'); 
    Route::post('/leave/update/{id}' , 'LeaveController@update' )->name('leaves.update'); 
    Route::get('/settings', 'SettingController@setting')->name('settings');
    Route::get('/user/{id}' , 'UserController@show' )->name('users.show'); 
    Route::get('/user/create' , 'UserController@create' )->name('users.create'); 
    Route::get('/notifications' , 'NotificationController@index' )->name('notifications.index');
    Route::get('/notifications-read' , 'NotificationController@read' )->name('notifications.read');
    Route::get('/leave/{id}' , 'LeaveController@show' )->name('leaves.show'); 
    Route::get('/leave/edit/{id}' , 'LeaveController@edit' )->name('leaves.edit'); 
    Route::post('/leave/approve' , 'LeaveApprovalController@store' )->name('leaves.approve'); 
    Route::post('/leave/deny' , 'LeaveDenialController@store' )->name('leaves.deny'); 

    // api
    Route::post('/upload-avatar' , 'UserProfileController@uploadAvatar' )->name('profile.upload'); 
    Route::post('/comment', 'Api\CommentController@store')->name('api.comments.store');
    Route::post('/comment/update/{id}' , 'Api\CommentController@update' )->name('api.comments.update'); 
    Route::post('/comment/delete/{id}' , 'Api\CommentController@destroy' )->name('api.comments.delete'); 
    Route::get('/leaves-on-week/{id}/{from}/{to}', 'Api\UserLeaveTimescaleController@show')->name('api.leaves.show');
    Route::get('/leave-metrics', 'Api\MetricsController@index')->name('api.metrics.index');
    Route::get('/chart' , 'Api\ChartController@index' )->name('api.chart.index'); 
    Route::get('/read-unread-notifications' , 'Api\radNotificationController@index' );
});
