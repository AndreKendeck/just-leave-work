<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\BanRequest;
use App\Http\Resources\UserResource;
use App\User;

class BanUserController extends Controller
{
    public function store(BanRequest $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->team_id == auth()->user()->team_id) {
            $user->ban();
            $user->tokens()->delete();
            $user->refresh();
            return response()
                ->json([
                    'user' => new UserResource($user),
                    'message' => "{$user->name} has been blocked successfully",
                ]);
        }
        return response()
            ->json([
                'message' => 'You are not allowed to block this user',
            ], 403);
    }

    public function update(BanRequest $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->team_id == auth()->user()->team_id) {
            $user->unban();
            $user->refresh();
            return response()
                ->json([
                    'user' => new UserResource($user),
                    'message' => "{$user->name}'s block has been removed",
                ]);
        }
        return response()
            ->json([
                'message' => 'You are not allowed to unblock this user',
            ], 403);
    }
}
