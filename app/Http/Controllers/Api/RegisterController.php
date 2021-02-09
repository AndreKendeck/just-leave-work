<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Permission;
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
            'name' => Str::kebab($request->name),
            'display_name' => $request->name,
            'description' => $request->name
        ]);

        $user->update([
            'team_id' => $team->id
        ]);

        $user->attachRole('team-admin',  $team);

        $permissions = Permission::all();

        $permissions->each(fn (\App\Permission $permission)  => $user->attachPermission($permission, $team));

        $user->update([
            'last_logged_in_at' => now()
        ]);

        $user->sendEmailVerificationNotification(); 

        $token = $user->createToken(Str::random())->plainTextToken;

        return response()
            ->json([
                'message' => "You successfully registered",
                'user' => $user,
                'token' => $token
            ]);
    }
}
