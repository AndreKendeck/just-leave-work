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
            $day = Carbon::create($request->day);
            $excludedDay = ExcludedDay::create([
                'setting_id' => $settings->id,
                'day' => $day->toDateTimeString(),
            ]);
            return response()
                ->json([
                    'message' => "{$day->toDateTimeString()} has been excluded",
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
        
    }
}
