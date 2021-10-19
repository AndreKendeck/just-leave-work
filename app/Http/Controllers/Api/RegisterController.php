<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\GoogleCaptchaController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\TeamResource;
use App\Http\Resources\UserResource;
use App\Team;
use App\User;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {

        if (env('APP_ENV') == 'production' || env('APP_ENV') == 'local') {
            $googleCaptchaController = new GoogleCaptchaController();
            $reCaptchaResponse = $googleCaptchaController($request);
            if (!$reCaptchaResponse) {
                return response()
                    ->json([
                        'errors' => ['recaptcha' => ['Google Captcha Failed']],
                    ], 422);
            }
        }

        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return response()
                ->json([
                    'errors' => ['email' => ['Please enter a valid email address']],
                ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'email' => $request->email,
        ]);

        $team = Team::create([
            'name' => Str::kebab($request->team_name . uniqid()),
            'display_name' => $request->team_name,
            'description' => $request->team_name,
        ]);

        if ($request->filled('country')) {
            $team->settings->update([
                'country_id' => $request->country,
            ]);
        }

        $user->update([
            'team_id' => $team->id,
        ]);

        $user->attachRole('team-admin', $team);

        $user->update([
            'last_logged_in_at' => now(),
        ]);

        $token = $user->createToken(Str::random())->plainTextToken;

        return response()
            ->json([
                'message' => "You successfully registered",
                'user' => new UserResource($user),
                'token' => $token,
                'team' => new TeamResource($team),
            ], 201);
    }
}
