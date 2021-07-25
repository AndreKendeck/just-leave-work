<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        try {
            auth()->user()->tokens()->delete();
            return response()
                ->json([
                    'message' => 'Logout successfully',
                ]);

        } catch (\Exception $e) {
            Log::error("Could not log out user {$e->getMessage()}");
            return response()
                ->json([
                    'message' => 'Logout failed',
                ], 500);
        }
    }
}
