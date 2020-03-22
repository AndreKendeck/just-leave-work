<?php

namespace App\Http\Controllers;

use App\Http\Requests\Approval\StoreRequest;
use App\Leave;

class LeaveApprovalController extends Controller
{
    public function store(StoreRequest $request)
    {
        $leave = Leave::findOrFail($request->leave_id);
        if ($leave->approved || $leave->denied) {
            return redirect()->back()->with('message', "You have already approved or denied leave #{$leave->number}");
        }
        $leave->approve();
        $leave->update([
            'approved_at' => now()
        ]);
        return redirect()->back()->with('message', "You have approved leave #{$leave->number}");
    }
}
