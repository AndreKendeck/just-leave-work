<?php

use Illuminate\Support\Facades\Route;

Route::view('/{any}', 'index');
Route::view('/', 'index');
