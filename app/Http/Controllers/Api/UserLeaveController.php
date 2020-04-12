<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Leave;
use App\User;

class UserLeaveController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:reporter');
    }

    public function index($id, $flag)
    {
        $user = User::findOrFail($id);

        if ($user->team_id != auth()->user()->team_id) {

            abort(403, "You are not allowed to view this users's leave");

        }

        return response()
            ->json([
                'leaves' => $user->leaves()->skip($flag)->take(5)->get()
            ]);
    }
}
