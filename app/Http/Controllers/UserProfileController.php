<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required' , 'string' , 'min:3' ],
        ]);
        
        auth()->user()->update([
            'name' => $request->name
        ]);
        return redirect()->back()->with('message', 'Profile updated');
    }

    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['nullable' , 'file' , 'image' , 'max:1000' ]
        ]);

        if ($request->hasFile('avatar')) {
            $request->avatar->store(User::STORAGE_PATH);
            auth()->user()->update([
                'avatar' => $request->avatar->hashName()
            ]);
        }
        return response()->json([
            'message' => 'Profile updated',
            'image' => auth()->user()->avatar_url,
        ]);
    }
}
