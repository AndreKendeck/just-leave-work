<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\UpdateRequest;
use App\Http\Resources\SettingResource;

class SettingController extends Controller
{
    public function index()
    {
        return response()
            ->json(
                new SettingResource(auth()->user()->team->settings)
            );
    }

    public function update(UpdateRequest $request)
    {
        auth()->user()->team->settings->update([
            'automatic_leave_approval' => $request->automatic_leave_approval,
            'leave_added_per_cycle' => $request->leave_added_per_cycle,
            'maximum_leave_days' => $request->maximum_leave_days,
            'maximum_leave_balance' => $request->maximum_leave_balance,
            'days_until_balance_added' => $request->days_until_balance_added,
            'can_approve_own_leave' => $request->can_approve_own_leave
        ]);

        return response()
            ->json([
                'message' => "Settings updated successfully",
                'settings' => new SettingResource(auth()->user()->team->settings)
            ]);
    }
}
