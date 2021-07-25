<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $team = auth()->user()->team;

        $admins = $team->users->filter(function (\App\User $user) use ($team) {
            return $user->hasRole('team-admin', $team) && ($user->id != auth()->user()->id);
        });

        return response()
            ->json(UserResource::collection($admins));
    }
}
