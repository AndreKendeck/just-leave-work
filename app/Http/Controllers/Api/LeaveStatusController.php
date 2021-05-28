<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Leave;

class LeaveStatusController extends Controller
{

    public function approve($id)
    {
        $leave = Leave::findOrFail($id);

        if (!auth()->user()->hasPermission('can-approve-leave', auth()->user()->team)) {
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

        // if users can approve their own leave
        if ($leave->user->id === auth()->id()) {
            if (!$leave->team->settings->can_approve_own_leave) {
                return response()
                    ->json([
                        'message' => "You cannot approve your own leave",
                    ], 403);
            }
        }

        $leave->approve();

        return response()
            ->json([
                'leave' => $leave, 
                'message' => "Leave has been approved",
            ]);
    }

    public function deny($id)
    {
        $leave = Leave::findOrFail($id);

        if (!auth()->user()->hasPermission('can-deny-leave', auth()->user()->team)) {
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
                'message' => 'Leave has beeen denied',
            ]);
    }

}
