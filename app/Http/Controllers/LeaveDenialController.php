<?php

namespace App\Http\Controllers;

use App\Http\Requests\Denial\StoreRequest;
use Illuminate\Http\Request;
use App\Leave; 

class LeaveDenialController extends Controller
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

        $leave->deny();

        return redirect()->route('leaves.index')->with('message', "You have denied leave #{$leave->number}");
    }
}
