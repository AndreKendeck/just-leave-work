<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        $user = \App\User::findOrFail(auth()->id()); 
        return response()
            ->json($user);
    }
}
