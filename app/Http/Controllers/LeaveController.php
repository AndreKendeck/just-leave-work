<?php

namespace App\Http\Controllers;

use App\Http\Requests\Leave\StoreRequest;
use App\Http\Requests\Leave\UpdateRequest;
use App\Leave;
use App\Reason;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LeaveController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leaves = Leave::with('user')->where('team_id', auth()->user()->team_id)->latest()->paginate();
        if (!auth()->user()->hasRole('reporter')) {
            $leaves = auth()->user()->leaves()->with('user')->paginate();
        }
        return view('leaves.index', [
            'leaves' =>  $leaves
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
    public function store(StoreRequest $request)
    {
        // check for leaves in between
        auth()->user()->leaves->each(function ($leave) use ($request) {
            $fromDate = Carbon::create($request->from);
            $untilDate = Carbon::create($request->until);
            if ($fromDate->isBetween($leave->from, $leave->until)) {
                return redirect()->back()->withErrors(['from' => "You cannot take leave from this date" ]);
            }
            if ($untilDate->isBetween($leave->from, $leave->until)) {
                return redirect()->back()->withErrors(['until' => "You cannot come back from leave on this date" ]);
            }
        });

        $leave = Leave::create([
            'team_id' => auth()->user()->team_id,
            'reason_id' => $request->reason_id,
            'user_id' => auth()->user()->id,
            'description' => $request->description,
            'from' => Carbon::create($request->from) ,
            'until' => Carbon::create($request->until)
        ]);
        return redirect()->route('leaves.index', $leave->id)
        ->with('message', "Leave #{$leave->number} has been created successfully");
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
        if ($leave->team_id != auth()->user()->team_id) {
            abort(403, "You cannot view this page");
        }
        return view('leaves.show', [
            'leave' => $leave
        ]);
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
        if ($leave->user_id != auth()->user()->id) {
            abort(403, "You cannot view this page");
        }

        return view('leaves.edit', [
            'leave' => $leave
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $leave = Leave::findOrFail($id);
        if ($leave->user_id != auth()->user()->id) {
            abort(403, "You cannot perform this action");
        }
        $leave->update(['description' => $request->description ]);
        return redirect()->back()->with('message', "Leave #{$leave->number} has been updated");
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
        if ($leave->user_id != auth()->user()->id) {
            abort(403, "You cannot perform this action");
        }
        if ($leave->number_of_approvals > 0 || $leave->number_of_denials > 0) {
            return redirect()->back()->with('message', 'You cannot delete this leave as it already has approved or denied');
        }
        $leave->delete();
        return redirect()->back()->with('message', "You have successfully deleted leave #{$leave->number}");
    }
}
