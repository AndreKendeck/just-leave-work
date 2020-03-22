<?php

namespace App\Http\Controllers;

use App\Http\Requests\Denial\StoreRequest;
use Illuminate\Http\Request;

class LeaveDenialController extends Controller
{
    public function store(StoreRequest $request)
    {
        $leave = Leave::findOrFail($request->leave_id);
        if ($leave->approved || $leave->denied ) {
            return redirect()->back()->with('message', "You have already approved or denied leave #{$leave->number}");
        }
        $leave->deny();
        $leave->update([
            'denied_at' => now()
        ]); 
        return redirect()->back()->with('message', "You have denied leave #{$leave->number}");
    }
}
