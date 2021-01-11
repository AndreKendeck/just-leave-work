<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class VerifyEmailAddressController extends Controller
{
    public function verify(Request $request, string $email)
    {
        if (!$request->hasValidSignature()) {

            return response()
                ->json([
                    'error' => "Invalid signature"
                ], 422);
        }

        $user = User::where('email', $email)->get()->first();

        if (!$user) {
            return response()
                ->json([
                    'error' => "User not found"
                ], 422);
        }
    }
}
