<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Leave\AdjustmentRequest;
use App\Http\Resources\TransactionResource;
use App\Transaction;
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

        $amount = $request->amount - $user->balance;

        $description = "Increase leave balance by {$amount}";
        $adjustingUser = auth()->user();

        if ($user->id == auth()->user()->id) {
            $description .= " (self-adjusted)";
        } else {
            $description .= " (adjusted by {$adjustingUser->email})";
        }

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'description' => $description,
            'amount' => $amount,
        ]);

        return response()
            ->json([
                'message' => "Leave balance adjusted",
                'balance' => $user->balance,
                'transaction' => new TransactionResource($transaction),
            ]);
    }

    /**
     * @param AdjustmentRequest $request
     * @return void
     */
    public function deduct(AdjustmentRequest $request)
    {
        $user = User::findOrFail($request->user);

        $amount = abs($user->balance - $request->amount);

        $description = "Decrease leave balance by {$amount}";
        $adjustingUser = auth()->user();

        if ($user->id == auth()->user()->id) {
            $description .= " (self-adjusted)";
        } else {
            $description .= " (adjusted by {$adjustingUser->email})";
        }


        $transaction = Transaction::create([
            'user_id' => $user->id,
            'description' => $description,
            'amount' => -$amount,
        ]);

        return response()
            ->json([
                'message' => "Leave balance adjusted",
                'balance' => $user->balance,
                'transaction' => new TransactionResource($transaction),
            ]);
    }
}
