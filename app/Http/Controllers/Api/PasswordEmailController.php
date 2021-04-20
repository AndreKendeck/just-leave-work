<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PasswordEmailController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => ['required', 'e-mail', 'exists:users,email'],
        ], [
            'email.exists' => 'No account was found with that email address',
        ]);

        $user = User::where('email', $request->email)->first();

        DB::table('password_resets')->insert([
            'email' => $user->email,
            'str_token' => Str::random(60),
            'created_at' => now(),
        ]);

    }
}
