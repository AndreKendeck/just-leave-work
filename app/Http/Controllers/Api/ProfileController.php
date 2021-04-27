<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ProfileController extends Controller
{
    public function index()
    {
        if (Cache::has('user')) {
            return response()
                ->get(Cache::get('user'));
        }
        $user = \App\User::with('team')->findOrFail(auth()->id());
     
        return response()
            ->json($user);
    }
}
