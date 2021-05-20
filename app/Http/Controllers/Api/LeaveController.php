<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Leave\StoreRequest;
use App\Http\Requests\Leave\UpdateRequest;
use App\Http\Resources\LeaveResource;
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
        $leaves = Leave::with('user:id,name')->where('team_id', auth()->user()->team_id)
            ->latest()
            ->paginate(10);

        return response()
            ->json(LeaveResource::collection($leaves));
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
                    'from' => ['Your leave dates are incorrect'],
                ],
            ], 422);
        }

        if (auth()->user()->is_on_leave) {
            return response()->json([
                'errors' => [
                    'from' => ['You are already on leave you cannot request leave when on leave'],
                ],
            ], 422);
        }

        $teamSettings = auth()->user()->team->settings;

        if ($teamSettings->maximum_leave_days !== 0) {

            $maximumLeaveDaysReached = ($from->diffInDays($to) > $teamSettings->maximum_leave_days);

            if ($maximumLeaveDaysReached) {
                return response()
                    ->json([
                        'message' => "Your team does not allow leave for more than {$teamSettings->maximum_leave_days} days",
                    ], 403);
            }
        }

        $leave = Leave::create([
            'team_id' => auth()->user()->team_id,
            'user_id' => auth()->id(),
            'reason_id' => $request->reason,
            'description' => $request->description,
            'from' => $from,
            'until' => $to,
        ]);

        /**
         * Automatic leave approval
         */

        $teamAllowsForAutomaticApprovals = $teamSettings->automatic_leave_approval;

        if ($teamAllowsForAutomaticApprovals) {
            // we want to check if the user has a positive balance first
            $willResultInANegativeBalance = $from->diffInDays($to) > auth()->user()->leave_balance;

            if (!$willResultInANegativeBalance) {
                $leave->approve();
                return response()->json([
                    'message' => "You leave request has been created & approved",
                    'leave' => new LeaveResource($leave),
                ], 201);
            }
        }

        return response()
            ->json([
                'message' => "Your leave request has been created successfully",
                'leave' => new LeaveResource($leave),
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
        $leave = Leave::with(['comments'])->findOrFail($id);

        if (auth()->user()->team_id !== $leave->team_id) {

            return response()
                ->json([
                    'message' => "You are not allowed to view this leave request",
                ], 403);
        }

        return response()
            ->json(new LeaveResource($leave));
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
                    'from' => ['Your leave dates is incorrect'],
                ],
            ], 422);
        }

        if (auth()->user()->team_id !== $leave->team_id) {

            return response()
                ->json([
                    'message' => "You are not allowed to update this leave request",
                ], 403);
        }

        if (!auth()->user()->owns($leave)) {
            return response()
                ->json([
                    'message' => 'You are not allowed to update this leave',
                ], 403);
        }

        if ($leave->approved) {
            return response()
                ->json([
                    'message' => "Leave has been approved no changes are allowed",
                ], 403);
        }

        if ($leave->denied) {
            return response()
                ->json([
                    'message' => "Leave has been denied no chanages are allowed",
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
                'leave' => new LeaveResource($leave),
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
                    'message' => "You are not allowed to delete this leave request",
                ], 403);
        }

        if (!auth()->user()->owns($leave)) {
            return response()
                ->json([
                    'message' => 'You are not allowed to delete this leave request',
                ], 403);
        }

        if ($leave->approved) {
            return response()
                ->json([
                    'message' => "Leave has been approved no changes are allowed",
                ], 403);
        }

        if ($leave->denied) {
            return response()
                ->json([
                    'message' => "Leave has been denied no chanages are allowed",
                ], 403);
        }

        $leave->delete();

        return response()
            ->json([
                'message' => 'Leave deleted',
            ]);
    }
}
