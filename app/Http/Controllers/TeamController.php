<?php

namespace App\Http\Controllers;

use App\Http\Requests\Team\UploadTeamLogoRequest;

class TeamController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:reporter');
        $this->middleware('optimizeImages')->only('update'); 
    }
    public function index()
    {
        return view('teams.index', [
            'team' => auth()->user()->team,
        ]);
    }

    public function update(UploadTeamLogoRequest $request)
    {
        $request->logo->store('/teams');
        auth()->user()->team->update([
            'logo' => $request->logo->hashName()
        ]);
        return response()
        ->json([
            'logo' => auth()->user()->team->logo_url
        ]);
    }
}
