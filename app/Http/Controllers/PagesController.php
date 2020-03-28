<?php

namespace App\Http\Controllers;

use App\Leave;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            if (!auth()->user()->hasVerifiedEmail()) {
                return redirect()->route('verification.notice');
            }
            $users = auth()->user()->team->users()->orderBy('name', 'ASC')->paginate(6);
            return view('profile.home', ['users' => $users ]);
        }
        return view('pages.welcome');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function settings()
    {
        return view('pages.settings');
    }
}
