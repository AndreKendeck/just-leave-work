<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaveDenialRequest;
use App\Mail\Leave\Denied;
use App\Notifications\General;
use App\Leave; 
use Mail;  

class LeaveDenialController extends Controller
{
    public function store(LeaveDenialRequest $request, $id)
    {
        $leave = Leave::findOrFail($id);

        $leave->deny(auth()->user());

        if (auth()->user()->organization_id != $leave->organization_id) {
            abort(403, "You are not allowed to perform this action");
        }

        // database notification
        $leave->user->notify(new General(
                auth()->user()->name . " has denied your leave #{$leave->number}",
                route('leaves.show', $leave->id)
            ));

        // send an email
        Mail::to($leave->user->email)
            ->queue(new Denied($leave));

        return redirect()->back()->with('message', "You have denied leave #{$leave->number}");
    }
}
