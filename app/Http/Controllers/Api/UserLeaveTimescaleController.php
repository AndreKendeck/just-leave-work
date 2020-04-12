<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;

class UserLeaveTimescaleController extends Controller
{
    public function show($id, $from, $to)
    {
        $user = User::findOrFail($id);
        if ($user->team_id != auth()->user()->team_id) {
            abort(403);
        }
        $leaves = $user->leaves
            ->whereNotNull('approved_at')->filter(function ($leave) use ($from, $to) {
            return Carbon::create($from)->isBetween($leave->from, $leave->until) ||
                Carbon::create($to)->isBetween($leave->from, $leave->until) || Carbon::create($from)->isSameDay($leave->from) || Carbon::create($to)->isSameDay($leave->until)
            || Carbon::create($to)->isSameDay($leave->from) || Carbon::create($from)->isSameDay($leave->until);
        });
        return response()->json(
            $leaves
        );
    }
}
