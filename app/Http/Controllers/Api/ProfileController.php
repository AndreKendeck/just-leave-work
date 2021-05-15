<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Http\Resources\TeamResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Cache;

class ProfileController extends Controller
{
    public function index()
    {
        if (Cache::has('user')) {
            return response()
                ->get(Cache::get('user'));
        }
        $user = \App\User::findOrFail(auth()->id());

        return response()
            ->json([
                'user' => new UserResource($user),
                'team' => new TeamResource($user->team),
                'settings' => new SettingResource($user->team->settings)
            ]);
    }
}
