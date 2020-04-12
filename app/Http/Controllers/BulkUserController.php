<?php

namespace App\Http\Controllers;

use App\Jobs\CreateBulkUsersJob;
use App\User;
use Illuminate\Http\Request;

class BulkUserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'users' => ['required', 'string'],
        ]);
        $emails = explode(',', $request->users);
        array_filter($emails);
        $emailValidation = collect($emails)->map(function ($email) {
            $email = trim($email);
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        });
        if ($emailValidation->contains(false)) {
            return redirect()->back()->withErrors(['users' => 'Entries contain an invalid e-mail address'])->withInput($request->input());
        }
        $containsExistingUser = collect($emails)->map(function ($email) {
            return User::where('email', $email)->exists();
        });
        
        if ($containsExistingUser->contains(true)) {
            return redirect()->back()->withErrors(['users' => 'Entries contain an existing e-mail address'])->withInput($request->input());
        }
        dispatch(new CreateBulkUsersJob(collect($emails)));
        return redirect()->back()->with('message', "Success your users will be added, this is take a couple of minutes");
    }
}
