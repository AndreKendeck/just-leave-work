<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserBanRequest;
use App\User;
use Illuminate\Http\Request;

class BanUserController extends Controller
{
    public function store(UserBanRequest $request, $id)
    {
        $user = User::findOrFail($id);
        if (auth()->user()->areTeammates($user) ) {
            if ($user->isBanned()) {
                return redirect()->back()->with('message', "{$user->name} is already banned");
            }
            $user->ban();
            return redirect()->back()->with('message', "{$user->name} has been banned");
        }
        abort(403, "You are not allowed to perform this action");
    }

    public function destroy(UserBanRequest $request, $id)
    {
        $user = User::findOrFail($id);
        if ( auth()->user()->areTeammates($user) ) {
            if (!$user->isBanned()) {
                return redirect()->back()->with('message', "{$user->name} is not banned");
            }
            $user->unban();
            return redirect()->back()->with('message', "{$user->name} has been banned");
        }
        abort(403, "You are not allowed to perform this action");
    }
}
