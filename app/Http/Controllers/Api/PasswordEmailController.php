<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

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
    }   
}
