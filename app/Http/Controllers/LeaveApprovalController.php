<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaveApprovalRequest;
use Illuminate\Http\Request;
use App\Leave;
use App\Mail\Leave\Approved;
use App\Notifications\General;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class LeaveApprovalController extends Controller
{
    public function store(LeaveApprovalRequest $request, $id)
    {
        $leave = Leave::findOrFail($id);

        if (auth()->user()->organization_id != $leave->organization_id) {
            abort(403, "You are not allowed to perform this action");
        }
        if (!Hash::check($request->password, auth()->user()->getAuthPassword())) {
            return redirect()->back()->withErrors('password', 'You password is incorrect');
        }
        
        $leave->approve(auth()->user());

        // database notification
        $leave->user->notify(new General(
            auth()->user()->name . " has approved your leave #{$leave->number}",
            route('leaves.show', $leave->id)
        ));

        // send an email
        Mail::to($leave->user->email)
            ->queue(new Approved($leave));

        return redirect()->back()->with('message', "You have approved leave #{$leave->number}");
    }
}
