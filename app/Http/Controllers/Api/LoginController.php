<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\SettingResource;
use App\Http\Resources\TeamResource;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function login(LoginRequest $loginRequest)
    {
        /** @var \App\User $user  */
        $user = User::where('email', $loginRequest->email)->get()->first();

        if (!$user) {
            return $this->loginFailed();
        }

        $validLogin = Hash::check($loginRequest->password, $user->password);

        if (!$validLogin) {
            return $this->loginFailed();
        }

        $token = $user->createToken(Str::random())->plainTextToken;

        $user->update([
            'last_logged_in_at' => now()
        ]);

        return response()
            ->json([
                'message' => "Login successful.",
                'token' => $token,
                'user' => new UserResource($user),
                'team' => new TeamResource($user->team), 
                'settings' => new SettingResource($user->team->settings)
            ]);
    }

    protected function loginFailed(string $message = "Login failed, invalid credidentials.")
    {
        return response()->json([
            'errors' => [
                'email' => $message
            ]
        ], 422);
    }
}
