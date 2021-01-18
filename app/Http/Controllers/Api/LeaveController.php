<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Leave\StoreRequest;
use App\Http\Requests\Leave\UpdateRequest;
use App\Leave;
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
        $leaves = Leave::where('team_id', auth()->user()->team_id)->latest()->paginate(10);

        return response()
            ->json($leaves);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $from = Carbon::create($request->from);
        $to = Carbon::create($request->until);

        $invalidDate = ($from > $to) || ($from === $to);

        if ($invalidDate) {
            return response()->json([
                'errors' => [
                    'from' => ['Your leave dates is incorrect']
                ]
            ], 422);
        }

        $leave = Leave::create([
            'team_id' => auth()->user()->team_id,
            'user_id' => auth()->id(),
            'reason_id' => $request->reason,
            'description' => $request->description,
            'from' => $from,
            'until' => $to,
        ]);

        return response()
            ->json([
                'message' => "Your leave request has been created successfully",
                'leave' => $leave
            ], 201);
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

        if (auth()->user()->team_id !== $leave->team_id) {

            return response()
                ->json([
                    'message' => "You are not allowed to view this leave request"
                ], 403);
        }

        return response()
            ->json([
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

        $from = Carbon::create($request->from);
        $to = Carbon::create($request->until);

        $invalidDate = ($from > $to) || ($from === $to);

        if ($invalidDate) {
            return response()->json([
                'errors' => [
                    'from' => ['Your leave dates is incorrect']
                ]
            ], 422);
        }


        if (auth()->user()->team_id !== $leave->team_id) {

            return response()
                ->json([
                    'message' => "You are not allowed to update this leave request"
                ], 403);
        }

        if (!auth()->user()->owns($leave)) {
            return response()
                ->json([
                    'message' => 'You are not allowed to update this leave'
                ], 403);
        }

        if ($leave->approved) {
            return response()
                ->json([
                    'message' => "Leave has been approved no changes are allowed"
                ], 403);
        }

        if ($leave->denied) {
            return response()
                ->json([
                    'message' => "Leave has been denied no chanages are allowed"
                ], 403);
        }

        $leave->update([
            'reason_id' => $request->reason,
            'description' => $request->description,
            'from' => $from,
            'until' => $to,
        ]);

        return response()
            ->json([
                'message' => "Leave has been updated",
                'leave' => $leave
            ]);
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


        if (auth()->user()->team_id !== $leave->team_id) {

            return response()
                ->json([
                    'message' => "You are not allowed to delete this leave request"
                ], 403);
        }

        if (!auth()->user()->owns($leave)) {
            return response()
                ->json([
                    'message' => 'You are not allowed to delete this leave request'
                ], 403);
        }

        if ($leave->approved) {
            return response()
                ->json([
                    'message' => "Leave has been approved no changes are allowed"
                ], 403);
        }

        if ($leave->denied) {
            return response()
                ->json([
                    'message' => "Leave has been denied no chanages are allowed"
                ], 403);
        }

        $leave->delete();

        return response()
            ->json([
                'message' => 'Leave deleted'
            ]);
    }
}
