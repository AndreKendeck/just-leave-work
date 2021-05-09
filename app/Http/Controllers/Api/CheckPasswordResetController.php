<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CheckPasswordResetController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $passwordResetEntry = DB::table('password_resets')->where('email', $request->email)->first();
        if (!$passwordResetEntry) {
            return response()
                ->json([
                    'message' => "Reset Token invalid",
                ], 498);
        }
        $token = $request->token;
        $result = Hash::check($token, $passwordResetEntry->token);
        if (!$result) {
            return response()
                ->json([
                    'message' => "Reset Token invalid",
                ], 498);
        }
        return response()
            ->json([
                'message' => 'Token valid',
            ]);
    }
}
