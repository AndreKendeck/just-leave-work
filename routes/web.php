<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PagesController@index')->name('index');
Route::get('/about', 'PagesController@about')->name('about');
Route::get('/terms-and-conditions', 'PagesController@terms')->name('terms');
Route::get('/privacy-policy', 'PagesController@privacy')->name('privacy');
Route::get('/contact-us', 'PagesController@contact')->name('contact');





Route::middleware([ 'auth' , 'verified' , 'forbid-banned-user' , 'logs-out-banned-user' , 'role:user' , 'forbid-banned-organization' ])->group(function () {
    Route::post('/comment', 'CommentController@store')->name('comments.store');
    Route::delete('/comment/{id}', 'CommentController@destroy')->name('comments.delete');
    Route::put('/comment/{id}', 'CommentControler@update')->name('comments.update');

    Route::get('/leaves', 'LeaveController@index')->name('leaves.index');
    Route::get('/leave/create', 'LeaveController@create')->name('leaves.create');
    Route::post('/leave/store', 'LeaveController@store')->name('leaves.store');
    Route::get('/leave/view/{id}', 'LeaveController@show')->name('leaves.show');
    Route::get('/leave/edit/{id}', 'LeaveController@edit')->name('leaves.edit');
    Route::put('/leave/update/{id}', 'LeaveController@update')->name('leaves.update');
    Route::delete('/leave/delete/{id}', 'LeaveController@destroy')->name('leaves.delete');


    Route::get('/organization', 'OrganizationController@index')->name('organizations.index');
    Route::put('/oranization/update', 'OrganizationController@update')->name('organizations.update');
    Route::delete('/organization/delete', 'OrganizationController@destroy')->name('organizations.delete');

    Route::get('/users', 'UserController@index')->name('users.index');
    Route::get('/user/create', 'UserController@create')->name('users.create');
    Route::post('/user', 'UserController@store')->name('users.store');
    Route::get('/user/{id}', 'UserController@show')->name('users.show');
    Route::put('/user/update/{id}', 'UserController@update')->name('users.update');
    Route::post('/user/ban/{id}', 'UserController@ban')->name('users.ban');
    Route::post('/account/delete', 'AccountController@destroy')->name('accounts.delete');
});
