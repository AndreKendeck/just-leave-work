<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class VerifyEmailController extends Controller
{
    public function verify(Request $request)
    {
        if (auth()->user()->hasVerifiedEmail()) {
            return response()
                ->json([
                    'message' => "You email address has already been verified"
                ], 403);
        }
        $request->validate([
            'code' => ['required', 'min:4', 'max:4', 'string']
        ]);

        $emailCode = auth()->user()->emailCode;

        $isCorrect = Hash::check($request->code, $emailCode->code);

        if (!$isCorrect) {
            return response()
                ->json([
                    'errors' =>  [
                        'code' => ['Code is invalid']
                    ]
                ], 422);
        }

        $hasExpired = $emailCode->hasExpired();

        if ($hasExpired) {
            return response()
                ->json([
                    'errors' => [
                        'code' => ['Code has expired please resend another one']
                    ]
                ], 422);
        }

        auth()->user()->markEmailAsVerified();

        return response()
            ->json([
                'message' => "Your email has been verified"
            ]);
    }

    public function resend()
    {

        if (auth()->user()->hasVerifiedEmail()) {
            return response()
                ->json([
                    'message' => "You email address has already been verified"
                ], 403);
        }

        try {
            auth()->user()->sendEmailVerificationNotification();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return response()
            ->json([
                'message' => "Email code has been resent"
            ]);
    }
}
