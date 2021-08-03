<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdatePasswordRequest;

class UpdatePasswordController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(UpdatePasswordRequest $request)
    {
        /** @var \App\User $user */
        $user = auth()->user();
        $user->update([
            'password' => bcrypt($request->new_password),
        ]);
        return response()
            ->json([
                'message' => 'Password updated',
            ]);
    }
}
