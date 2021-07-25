<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Http\Resources\TeamResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

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


    public function update(Request $request)
    {
        $user = \App\User::findOrFail(auth()->id());
        $request->validate([
            'name' => 'required',
            '' 
        ] , [
            ''
        ]);
    }
}
