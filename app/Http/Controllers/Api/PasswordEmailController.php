<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordEmailController extends Controller
{
    use SendsPasswordResetEmails;
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

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return response()->json([
                'message' => 'Password Reset link sent',
            ]);
        }

        return response()->json([
            'errors' => [
                'email' => [trans($status)]
            ],
        ], 422);

    }
}
