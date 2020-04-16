<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Leave;

class ChartController extends Controller
{
    public function index()
    {
        $result = collect();
        for ($i = 1 ; $i < 13 ; $i++) {
            $result->push(Leave::where('team_id', auth()->user()->team_id )->whereNotNull('approved_at')->whereMonth('from', $i)->count());
        }
        return response()->json(
            $result->toArray()
        );
    }
}
