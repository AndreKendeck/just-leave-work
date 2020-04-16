<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('optimizeImages')->only('uploadAvatar');
    }

    public function index()
    {
        return view('profile.index');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:3'],
        ]);

        auth()->user()->update([
            'name' => $request->name,
        ]);
        return redirect()->back()->with('message', 'Profile updated');
    }

    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'file', 'image', 'max:1000', 'mimes:png,jpg,jpeg,gif'],
        ]);

        if ($request->hasFile('avatar')) {
            $request->avatar->store(User::STORAGE_PATH);
            if (auth()->user()->has_avatar) {
                Storage::delete(User::STORAGE_PATH . auth()->user()->avatar);
            }
            auth()->user()->update([
                'avatar' => $request->avatar->hashName(),
            ]);
        }
        return response()->json([
            'avatar' => auth()->user()->avatar_url,
        ]);
    }

    public function removeAvatar(Request $request)
    {
        if (auth()->user()->has_avatar) {
            Storage::delete(User::STORAGE_PATH . auth()->user()->avatar);
        }
        auth()->user()->update([
            'avatar' => null,
        ]);
        return response()->json([
            'avatar' => auth()->user()->avatar_url,
        ]);
    }
}
