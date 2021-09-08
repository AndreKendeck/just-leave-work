<?php

namespace App\Http\Controllers\Api;

use App\ExcludedDay;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\StoreExludedDayRequest;
use App\Http\Resources\ExcludedDayResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DaySettingController extends Controller
{
    const DAYS = [
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
        'Sunday',
    ];

    public function store(StoreExludedDayRequest $request)
    {
        $day = \Illuminate\Support\Str::of($request->day)->ucfirst();
        $settings = auth()->user()->team->settings;
        if (in_array($day, self::DAYS)) {
            $exists = ExcludedDay::where([
                'day' => $day,
                'setting_id' => $settings->id,
            ])->exists();
            if ($exists) {
                return response()
                    ->json([
                        'errors' => ['This day already exists'],
                    ], 422);
            }
            $excludedDay = ExcludedDay::create([
                'setting_id' => $settings->id,
                'day' => $day,
            ]);
            return response()
                ->json([
                    'message' => 'Day Added',
                    'day' => new ExcludedDayResource($excludedDay),
                ], 201);
        }

        try {
            $day = Carbon::parse($request->day);

            $exists = ExcludedDay::where([
                'day' => $day,
                'setting_id' => $settings->id,
            ])->exists();
            if ($exists) {
                return response()
                    ->json([
                        'errors' => ['This day already exists'],
                    ], 422);
            }

            $excludedDay = ExcludedDay::create([
                'setting_id' => $settings->id,
                'day' => $day->toDateString(),
            ]);
            return response()
                ->json([
                    'message' => "{$day->toDateString()} has been excluded",
                    'day' => new ExcludedDayResource($excludedDay),
                ], 201);
        } catch (\Exception $e) {
            Log::error("Could not save day {$e->getMessage()}");
            return response()
                ->json([
                    'message' => 'Could not save day',
                ], 500);
        }
    }

    public function destroy($id)
    {
        $day = ExcludedDay::findOrFail($id);

        $settings = $day->settings;

        if (!auth()->user()->team->id != $settings->team_id) {
            return response()
                ->json([
                    'message' => 'You cannot remove this day',
                ], 403);
        }

        if (!auth()->user()->hasRole('team-admin', auth()->user()->team)) {
            return response()
                ->json([
                    'message' => 'You are not allowed to perform this action',
                ], 403);
        }

        $day->delete();

        return response()
            ->json([
                'message' => "{$day->day} has been removed",
            ]);
    }
}
