<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\SettingResource;
use App\Http\Resources\TeamResource;
use App\Http\Resources\UserResource;

class ProfileController extends Controller
{
    public function index()
    {

        $user = \App\User::findOrFail(auth()->id());

        $reasons = \App\Reason::all();

        $result = [
            'user' => new UserResource($user),
            'team' => new TeamResource($user->team),
            'settings' => new SettingResource($user->team->settings),
            'reasons' => $reasons,
        ];

        return response()
            ->json($result);
    }
}
