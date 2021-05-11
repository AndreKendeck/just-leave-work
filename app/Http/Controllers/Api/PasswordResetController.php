<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{

    /**
     * @param Request $request
     * @param string $token
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function show(Request $request, string $token)
    {
        return view('index');
    }

    /**
     * @param ResetPasswordRequest $request
     * @return void
     */
    public function store(ResetPasswordRequest $request)
    {
        $token = $request->token;
        $resetEntry = DB::table('password_resets')->where('email', $request->email)->first();
        $validToken = Hash::check($token, $resetEntry->token);

        if (!$validToken) {
            return response()
                ->json([
                    'errors' => [
                        'password' => ['Invalid/Expired Token']
                    ]
                ], 422);
        }

        $user = User::where('email', $request->email)->first();

        $user->update([
            'password' => bcrypt($request->password)
        ]);

        $resetEntry->delete();

        return response()
            ->json([
                'message' => 'Password changed successfully'
            ]);
    }
}
