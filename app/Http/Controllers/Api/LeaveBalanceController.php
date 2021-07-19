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

}
