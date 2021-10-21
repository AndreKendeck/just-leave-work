<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Leave\StoreRequest;
use App\Http\Resources\LeaveResource;
use App\Jobs\AdjustLeaveForPublicHolidays;
use App\Leave;
use App\Services\PublicHolidayApi\NagerDate;
use App\Services\PublicHolidayApi\Response\Holiday;
use Illuminate\Http\Request;
use \Carbon\Carbon;

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
        $from = Carbon::create($request->from);

        $until = Carbon::create($request->from);

        if ($request->filled('until')) {
            $until = Carbon::create($request->until);
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

        /** @var \App\Setting */
        $settings = auth()->user()->team->settings;

        $restrcitedDays = $settings->excludedDays;

        if ($restrcitedDays->contains('day', $from->toDateString())) {
            return response()->json([
                'errors' => [
                    'from' => [ "You cannot start leave on {$from->toFormattedDateString()}"],
                ],
            ], 422);
        }
        if ($restrcitedDays->contains('day', $from->format('l'))) {
            $excludedDays = $restrcitedDays->implode('day', ', ');
            return response()->json([
                'errors' => [
                    'from' => ["You cannot start leave on {$excludedDays}"],
                ],
            ], 422);
        }

        if ($restrcitedDays->contains('day', $until->format('l'))) {
            $excludedDays = $restrcitedDays->implode('day', ', ');
            return response()->json([
                'errors' => [
                    'from' => ["You cannot end leave on {$excludedDays}"],
                ],
            ], 422);
        }

        if (!is_null($settings->country_id) && ($settings->use_public_holidays)) {
            $countryId = $settings->country_id;

            /** @var array */
            $holidays = NagerDate::getHolidays($from->year, $countryId);

            $leaveEndOrBeginsOnAHoliday = count(array_filter($holidays, function (Holiday $holiday) use ($from, $until) {
                return $from->isSameDay($holiday->getDate()) || $until->isSameDay($holiday->getDate());
            })) > 0;

            if ($leaveEndOrBeginsOnAHoliday) {

                return response()
                    ->json([
                        'errors' => [
                            'from' => ['You cannot take/end leave on a Public Holiday'],
                        ],
                    ], 422);
            }

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
            'from' => $from,
            'until' => $until,
            'half_day' => $request->halfDay,
        ]);
        
        /**
         * If the public holiday api is enabled
         */
        if (!is_null($settings->country_id) && ($settings->use_public_holidays)) {
            dispatch(new AdjustLeaveForPublicHolidays($leave, $holidays));
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
                    'message' => 'You cannot view this Leave Request',
                ], 403);
        }

        return response()
            ->json(new LeaveResource($leave));
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
                'message' => 'Leave deleted successfully',
            ]);
    }
}
