<?php

namespace App\Http\Controllers;

use App\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:reporter');
    }

    public function index()
    {
        return view('teams.index', [
            'team' => auth()->user()->team,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:3'],
        ]);
        auth()->user()->team->update([
            'name' => $request->name,
        ]);
        return redirect()->back()->with('message', "Your team name has been updated");
    }

}
