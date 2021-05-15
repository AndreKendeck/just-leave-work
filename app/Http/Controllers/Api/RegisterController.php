<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\TeamResource;
use App\Http\Resources\UserResource;
use App\Permission;
use App\Team;
use App\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'email' => $request->email,
        ]);

        $team = Team::create([
            'name' => Str::kebab($request->team_name),
            'display_name' => $request->team_name,
            'description' => $request->team_name,
        ]);

        $user->update([
            'team_id' => $team->id,
        ]);

        $user->attachRole('team-admin', $team);

        $permissions = Permission::all();

        $permissions->each(function (\App\Permission $permission) use ($user, $team) {
            $user->attachPermission($permission, $team);
        });

        $user->update([
            'last_logged_in_at' => now(),
        ]);

        try {
            $user->sendEmailVerificationNotification();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        $token = $user->createToken(Str::random())->plainTextToken;

        return response()
            ->json([
                'message' => "You successfully registered",
                'user' => new UserResource($user),
                'token' => $token,
                'team' => new TeamResource($team)
            ], 201);
    }
}
