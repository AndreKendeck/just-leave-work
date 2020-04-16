<?php

namespace App\Http\Controllers;

use App\Http\Requests\Approval\StoreRequest;
use App\Leave;

class LeaveApprovalController extends Controller
{
    public function store(StoreRequest $request)
    {
        $leave = Leave::findOrFail($request->leave_id);

        if ($leave->approved) {
            return redirect()->back()->with('message', "You have already approved leave #{$leave->number}");
        }

        if ($leave->denied) {
            return redirect()->back()->with('message', "You have already denied leave #{$leave->number}");
        }

        $leave->approve();

        return redirect()->back()->with('message', "You have approved leave #{$leave->number}");
    }
}
