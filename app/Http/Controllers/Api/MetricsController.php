<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Leave;
use Illuminate\Http\Request;

class MetricsController extends Controller
{
    public function index()
    {
        return response()->json([
            'requested' => Leave::where('team_id', auth()->user()->team_id)->count(),
            'approved' => Leave::where('team_id', auth()->user()->team_id)->
            whereNotNull('approved_at')->count(),
            'denied' => Leave::where('team_id', auth()->user()->team_id)
            ->whereNotNull('denied_at')->count(),
        ], 200);
    }
}
