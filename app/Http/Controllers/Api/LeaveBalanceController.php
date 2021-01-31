<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Leave\AdjustmentRequest;
use App\User;

class LeaveBalanceController extends Controller
{

    /**
     * @param AdjustmentRequest $request
     * @return void
     */
    public function add(AdjustmentRequest $request)
    {
        $user = User::findOrFail($request->user);

        $teamSettings = auth()->user()->team->settings;

        if (($teamSettings->maximum_leave_balance != 0)) {

            $totalLeavesAfterIncrement = $request->amount + $user->leave_balance;

            if ($this->isBiggerThanTeamSettings($totalLeavesAfterIncrement, $teamSettings->maximum_leave_balance)) {

                return response()
                    ->json([
                        'message' => "Leave limit reached please adjust team settings",
                    ], 403);

            }

        }

        $user->increment('leave_balance', $request->amount);

        return response()
            ->json([
                'message' => "Leave balance adjusted",
            ]);
    }

    /**
     * @param AdjustmentRequest $request
     * @return void
     */
    public function remove(AdjustmentRequest $request)
    {
        $user = User::findOrFail($request->user);

        $user->decrement('leave_balance', $request->amount);

        return response()
            ->json([
                'message' => "Leave balance adjusted",
            ]);
    }

    /**
     * @param integer $current
     * @param integer $limit
     * @return boolean
     */
    protected function isBiggerThanTeamSettings(int $current, int $limit)
    {
        return $current > $limit;
    }
}
