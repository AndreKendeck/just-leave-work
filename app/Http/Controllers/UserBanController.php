<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\BanRequest;
use App\Http\Requests\User\UnbanRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserBanController extends Controller
{
    public function store(BanRequest $request)
    {
        $user = User::findOrFail($request->user_id);
        if ($user->id == auth()->user()->id) {
            return redirect()->back()->with('message', "You cannot ban yourself");
        }
        if ($user->isBanned()) {
            return redirect()->back()->with('message', "{$user->name} is already banned");
        }
        $user->ban();
        return redirect()->back()->with('message', "{$user->name} has been banned");
    }

    public function destroy(UnbanRequest $request)
    {
        $user = User::findOrFail($request->user_id);
        if (!$user->isBanned()) {
            return redirect()->back()->with('message', "{$user->name} is not banned");
        }
        $user->unban();
        return redirect()->back()->with('message', "{$user->name}'s ban has been lifted");
    }
}
