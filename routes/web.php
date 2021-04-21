<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'index')
    ->name('index');
Route::get('/{any}', function () {
    return redirect()->route('index');
});
