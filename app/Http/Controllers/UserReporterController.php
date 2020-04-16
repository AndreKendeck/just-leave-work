<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserReporterController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:reporter');
    }

    public function store(Request $request)
    {
        $request->validate(['user_id' => [Rule::exists('users', 'id')->where('team_id', auth()->user()->team_id), 'integer', 'required']]);

        $user = User::findOrFail($request->user_id);

        if ($user->hasRole('reporter')) {
            return redirect()->back()->with('message', "{$user->name} is already a reporter");
        }
        $user->assignRole('reporter');

        return redirect()->back()->with('message', "{$user->name} is now a reporter");
    }

    public function destroy(Request $request)
    {
        $request->validate(['user_id' => [Rule::exists('users', 'id')->where('team_id', auth()->user()->team_id), 'integer', 'required']]);

        $user = User::findOrFail($request->user_id);

        if (!$user->is_reporter) {
            return redirect()->back()->with('message', "{$user->name} is not a reporter");
        }

        $user->removeRole('reporter');

        return redirect()->back()->with('message', "{$user->name} is no longer a reporter");
    }
}
