<?php

namespace App\Http\Controllers;

use App\Http\Requests\Leave\StoreRequest;
use App\Http\Requests\Leave\UpdateRequest;
use App\Leave;
use App\Reason;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LeaveController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $leaves = Leave::where(function ($query) {
            $query->where('team_id', auth()->user()->team_id);
            if (!auth()->user()->hasRole('reporter')) {
                $query->where('user_id', auth()->user()->id);
            }
        })->with(['user' => function ($query) use ($request) {
            if ($request->has('search')) {
                $query->where('name', 'like', "%$request->search%");
            }
        }])->latest()->paginate(8);
        return view('leaves.index', [
            'leaves' => $leaves,
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
            'reasons' => Reason::all(),
            'reporters' => User::role('reporter')->where([
                'team_id' => auth()->user()->team_id,
                ['id', '<>', auth()->user()->id],
            ])->get(),
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

        $fromDate = Carbon::create($request->from);
        $untilDate = Carbon::create($request->until);
        if ($untilDate->isBefore($fromDate)) {
            return redirect()->back()->withErrors(['until' => 'This date is invalid its before the from date']);
        }

        $leave = Leave::create([
            'team_id' => auth()->user()->team_id,
            'reason_id' => $request->reason_id,
            'reporter_id' => $request->reporter_id,
            'user_id' => auth()->user()->id,
            'description' => $request->description,
            'from' => Carbon::create($request->from),
            'until' => Carbon::create($request->until),
        ]);
        return redirect()->route('leaves.show', $leave->id)
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
            'leave' => $leave,
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
            'leave' => $leave,
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
        $leave->update(['description' => $request->description]);
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
        if ($leave->approved || $leave->denied) {
            return redirect()->back()->with('message', 'You cannot delete this leave as it already has approved or denied');
        }
        $leave->delete();
        return redirect()->back()->with('message', "You have successfully deleted leave #{$leave->number}");
    }
}
