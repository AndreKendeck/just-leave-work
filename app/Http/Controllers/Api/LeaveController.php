<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Leave\StoreRequest;
use App\Http\Requests\Leave\UpdateRequest;
use App\Http\Resources\LeaveResource;
use App\Leave;
use App\Mail\LeaveRequestEmail;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $year = $request->year ? $request->year : now()->format('Y');

        $leaves = Leave::with(['user'])->where('team_id', auth()->user()->team_id)
            ->whereYear('from', '=', $year)
            ->latest()
            ->paginate(10);

        return response()
            ->json([
                'leaves' => LeaveResource::collection($leaves),
                'from' => $leaves->firstItem(),
                'perPage' => $leaves->perPage(),
                'to' => $leaves->lastPage(),
                'total' => $leaves->total(),
                'currentPage' => $leaves->currentPage(),
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
        $from = new Carbon($request->from);

        $until = new Carbon($request->from);

        if ($request->filled('until')) {

            $until = new Carbon($request->until);
        }

        // future dates are always bigger
        $invalidDate = ($from > $until);

        if ($invalidDate) {
            return response()->json([
                'errors' => [
                    'from' => ['Your leave dates are incorrect'],
                ],
            ], 422);
        }

        $restrcitedDaysToStartLeave = auth()->user()->team->settings->excludedDays;

        if ($restrcitedDaysToStartLeave->contains('day', $from->format('l'))) {
            $excludedDays = $restrcitedDaysToStartLeave->implode('day', ', ');
            return response()->json([
                'errors' => [
                    'from' => ["You cannot start leave on {$excludedDays}"],
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

        $leave = Leave::create([
            'team_id' => auth()->user()->team_id,
            'user_id' => auth()->id(),
            'reason_id' => $request->reason,
            'description' => $request->description,
            'from' => $from,
            'until' => $until,
        ]);

        /**
         * Send an email notification to the relevant party about ones leave request
         */
        if ($request->filled('notifyUser')) {

            $userToNotify = User::findOrFail($request->notifyUser);

            if ($userToNotify->hasRole('team-admin', $leave->team)) {
                Mail::to($userToNotify->email)
                    ->queue(new LeaveRequestEmail($leave));
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

        if (auth()->user()->owns($leave)) {
            return response()
                ->json(new LeaveResource($leave));
        }

        if (!auth()->user()->hasRole('team-admin', $leave->team)) {
            return response()
                ->json([
                    'message' => 'You cannot view this user',
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
                    'message' => "Leave has been denied no changes are allowed",
                ], 403);
        }

        $leave->update([
            'description' => $request->description,
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
