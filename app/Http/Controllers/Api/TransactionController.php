<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;

class TransactionController extends Controller
{
    public function index(int $userId)
    {
        // check if the user is in your team
        $user = \App\User::findOrFail($userId);

        if ($user->team_id != auth()->user()->team_id) {
            return response()->json([
                'message' => 'You are not allowed to view this users transactions ',
            ], 403);
        }

        if (!auth()->user()->hasRole('team-admin', $user->team)) {
            return response()
                ->json([
                    'message' => 'You are not allowed to view transactions',
                ], 403);
        }

        $transactions = $user->transactions()->paginate(10);

        return response()
            ->json([
                'data' => TransactionResource::collection($transactions),
                'from' => $transactions->firstItem(),
                'perPage' => $transactions->perPage(),
                'to' => $transactions->lastPage(),
                'total' => $transactions->total(),
                'currentPage' => $transactions->currentPage(),
            ]);
    }
}
