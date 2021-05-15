<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeamResource;
use App\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $team = Team::findOrFail(auth()->user()->team_id);
        return response()
            ->json(new TeamResource($team));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:2', 'max:255']
        ]);

        if (!auth()->user()->hasRole('team-admin', auth()->user()->team)) {
            return response()
                ->json([
                    'message' => "You are not allowed to make this request"
                ], 403);
        }

        auth()->user()->team->update([
            'name' => $request->name
        ]);

        return response()
            ->json([
                'message' => "Team name updated"
            ]);
    }
}
