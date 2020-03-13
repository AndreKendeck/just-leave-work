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

Route::middleware([ 'auth' , 'verified' , 'forbid-banned-user' , 'logs-out-banned-user' , 'role:user' , 'forbid-banned-organization' ])->group(function () {
    Route::post('/comment', 'CommentController@store')->name('comments.store');
    Route::delete('/comment/{id}', 'CommentController@destroy')->name('comments.delete');
    Route::put('/comment/{id}', 'CommentController@update')->name('comments.update');


    Route::get('/profile', 'UserProfileController@index')->name('profile');
    Route::post('/profile/update', 'UserProfileController@update')->name('profile.update');

    Route::get('/settings', 'PagesController@settings')->name('settings');
    Route::post('/password/change', 'PasswordChangeController@store')->name('password.change');
    
    Route::post('/user/ban/{id}', 'BanUserController@store')->name('users.ban');
    Route::post('/user/unban/{id}', 'BanUserController@destroy')->name('users.unban');

    Route::get('/leaves', 'LeaveController@index')->name('leaves.index');
    Route::get('/leave/create', 'LeaveController@create')->name('leaves.create');
    Route::post('/leave/store', 'LeaveController@store')->name('leaves.store');
    Route::get('/leave/view/{id}', 'LeaveController@show')->name('leaves.show');
    Route::get('/leave/edit/{id}', 'LeaveController@edit')->name('leaves.edit');
    Route::put('/leave/update/{id}', 'LeaveController@update')->name('leaves.update');
    Route::delete('/leave/delete/{id}', 'LeaveController@destroy')->name('leaves.delete');

    Route::post('/leave/approve/{id}', 'LeaveApprovalController@store')->name('leaves.approve');
    Route::post('/leave/deny/{id}', 'LeaveDenialController@store')->name('leaves.deny');

    Route::get('/organization/edit/{id}', 'OrganizationController@edit')->name('organizations.edit');
    Route::get('/organization', 'OrganizationController@index')->name('organizations.index');
    Route::put('/oranization/update', 'OrganizationController@update')->name('organizations.update');
    Route::delete('/organization/delete', 'OrganizationController@destroy')->name('organizations.delete');

    Route::get('/notifications', 'NotificationController@index')->name('notifications.index');
    Route::delete('/notification/delete/{id}', 'NotificationController@destroy')->name('notifications.delete');
    Route::get('/notifications/read' , 'NotificationController@read' )->name('notifications.read'); 

    Route::get('/users', 'UserController@index')->name('users.index');
    Route::get('/user/create', 'UserController@create')->name('users.create');
    Route::post('/user', 'UserController@store')->name('users.store');
    Route::get('/user/{id}', 'UserController@show')->name('users.show');
    Route::put('/user/update/{id}', 'UserController@update')->name('users.update');
});
