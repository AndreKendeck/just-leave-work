<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\BanRequest;
use App\User;

class BanUserController extends Controller
{
    public function store(BanRequest $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user->team_id == auth()->user()->team_id) {
            $user->ban();
            return response()
                ->json([
                    'message' => "{$user->name} has been blocked successfully"
                ]);
        }
        return response()
            ->json([
                'message' => 'You are not allowed to block this user'
            ], 403);
    }

    public function update(BanRequest $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->team_id == auth()->user()->team_id) {
            $user->unban();
            return response()
                ->json([
                    'message' => "{$user->name}'s block has been removed"
                ]);
        }
        return response()
            ->json([
                'message' => 'You are not allowed to unblock this user'
            ], 403);
    }
}
