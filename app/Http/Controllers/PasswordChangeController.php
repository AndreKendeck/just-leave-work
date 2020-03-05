<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordChangeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'password' => ['required'],
            'new_password' => ['required' , 'min:8' , 'string' , 'confirmed' ],
        ]);
        if (!Hash::check($request->password, auth()->user()->getAuthPassword())) {
            return redirect()->back()->withErrors('password', 'Your current password is invalid');
        }
        auth()->user()->update([
            'password' => bcrypt($request->new_password)
        ]);
        return redirect()->route('profile')->with('message', 'Your new password was successfully set');
    }
}
