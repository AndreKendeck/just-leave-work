<?php

use Illuminate\Support\Facades\Route;

Route::get('/password-reset/{token}', 'Api\PasswordResetController@show')->name('password.reset');
Route::view('/{any}', 'index');
Route::view('/{any}/{path}', 'index');
Route::view('/{any}/{path}/{id}', 'index');
Route::view('/', 'index');
