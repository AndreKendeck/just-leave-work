<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LeaveResource;
use App\Leave;

class LeaveStatusController extends Controller
{

    public function approve($id)
    {
        $leave = Leave::findOrFail($id);

        if (!auth()->user()->hasRole('team-admin', auth()->user()->team)) {
            return response()
                ->json([
                    'message' => "You are not allowed to approve leave",
                ], 403);
        }

        if ($leave->team_id !== auth()->user()->team_id) {
            return response()
                ->json([
                    'message' => "You are not allowed to approve this leave",
                ], 403);
        }

        if ($leave->denied) {
            return response()
                ->json([
                    'message' => "Leave has been denied already & cannot be approved",
                ], 403);
        }

        if ($leave->approved) {
            return response()
                ->json([
                    'message' => "Leave has been already approved",
                ], 403);
        }

        $leave->approve();

        $leave->user->decrement('leave_balance', $leave->number_of_days_off);

        return response()
            ->json([
                'leave' => new LeaveResource($leave),
                'message' => "Leave has been approved",
            ]);
    }

    public function deny($id)
    {
        $leave = Leave::findOrFail($id);

        if (!auth()->user()->hasRole('team-admin', auth()->user()->team)) {
            return response()
                ->json([
                    'message' => "You are not allowed to approve leave",
                ], 403);
        }

        if ($leave->team_id !== auth()->user()->team_id) {
            return response()
                ->json([
                    'message' => "You are not allowed to approve this leave",
                ], 403);
        }

        if ($leave->approved) {
            return response()
                ->json([
                    'message' => "Leave has been approved already & cannot be denied",
                ], 403);
        }

        $leave->deny();

        return response()
            ->json([
                'leave' => new LeaveResource($leave),
                'message' => 'Leave has beeen denied',
            ]);
    }

}
