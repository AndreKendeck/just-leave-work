<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaveStoreRequest;
use App\Http\Requests\LeaveUpdateRequest;
use App\Leave;
use App\Reason;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('leaves.index', [
            'leaves' => auth()->user()->leaves()->paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('leaves.create', [
            'reasons' => Reason::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeaveStoreRequest $request)
    {
        $from = Carbon::create($request->from);
        $until = Carbon::create($request->until);
        if ($from > $until) {
            return redirect()->back()->withErrors('from', 'The date you taking leave from is invalid');
        }
        $leave = Leave::create([
            'organization_id' => $request->organization_id,
            'user_id' => auth()->user()->id,
            'reason_id' => $request->reason_id,
            'description' => $request->description,
            'from' => $request->from,
            'until' => $request->until
        ]);
        return redirect()->route('leaves.index')->with('message', "Leave request #{$leave->number} has been created successfuly");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $leave = Leave::findOrFail($id);

        // check
        if ( $leave->can_edit || (auth()->user()->hasPermission('approve-and-deny-leave', $leave->organization)) ) {
            return view('leaves.show', [
                'leave' => $leave
            ]);
        }
        abort(403, "You are not allowed to view this page");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $leave = Leave::findOrFail($id);

        // check
        if ($leave->can_edit) {
            return view('leaves.edit', [
                'reasons' => Reason::all(),  
                'leave' => $leave
            ]);
        }
        abort(403, "You are not allowed to view this page");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LeaveUpdateRequest $request, $id)
    {
        $leave = Leave::findOrFail($id);

        // prevent updates to the model when approved or denied
        if ($leave->approved || $leave->denied) {
            return redirect()->back()->with('message', 'Approved or Denied leave cannot be edited');
        }
        // check
        if ($leave->can_edit) {
            $leave->update([
                'reason_id' => $request->reason_id,
                'description' => $request->description
            ]);
            return redirect()->back()->with('message', 'Successfully updated');
        }
        abort(403, "You are not allowed perform this action");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $leave = Leave::findOrFail($id);

        if ($leave->approved || $leave->denied) {
            return redirect()->back()->with('message', 'Approved or Denied leave cannot be deleted');
        }
        if ($leave->can_edit) {
            $leave->delete();
            return redirect()->route('leaves.index')->with('message', "Leave #{$leave->number} has been deleted");
        }
    }
}
