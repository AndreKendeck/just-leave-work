<?php

namespace App\Http\Controllers;

use App\Http\Requests\Password\PasswordChangeRequest;
use Illuminate\Support\Facades\Hash;

class PasswordChangeController extends Controller
{
    public function update(PasswordChangeRequest $request)
    {
        if (Hash::check( $request->current_password , auth()->user()->password )) {
            auth()->user()->update([
                'password' => bcrypt($request->new_password),
            ]);
            return redirect()->back()->with('message', 'You updated your password successfully');
        }
        return redirect()->back()->withErrors(['current_password' => "You have entered the wrong password"]);
    }
}
