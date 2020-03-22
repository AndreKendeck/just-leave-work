<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Leave;
use Illuminate\Http\Request;

class UserLeaveController extends Controller
{
    public function show($userId)
    {
        $leaves = Leave::where([
            'user_id' => $userId, 
        ]); 
    }
}
