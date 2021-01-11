<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Team;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'email' => $request->email
        ]);

        $team = Team::create([
            'name' => $request->name
        ]);

        $user->update([
            'team_id' => $team->id
        ]);

        $user->assignRole('team-admin');

        $user->update([
            'last_logged_in_at' => now()
        ]);

        $token = $user->createToken(Str::random())->plainTextToken;

        return response()
            ->json([
                'message' => "You successfully registered",
                'user' => $user,
                'token' => $token
            ]);
    }
}
