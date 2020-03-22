<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserLeaveTimescaleController extends Controller
{
    public function show($id, $from, $to)
    {
        $user = User::findOrFail($id);
        if ($user->team_id != auth()->user()->team_id) {
            abort(403);
        }
        $leaves = $user->leaves
        ->whereNotNull('approved_at')->filter(function ($leave) use ($from , $to) {
            return ($leave->until <= $to)  || ($leave->from >= $from);
        });
        return response()->json(
            $leaves
        );
    }
}
