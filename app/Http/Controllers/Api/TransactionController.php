<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    public function index(int $userId)
    {
        // check if the user is in your team
        $user = \App\User::findOrFail($userId);

    }
}
