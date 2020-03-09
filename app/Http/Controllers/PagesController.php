<?php

namespace App\Http\Controllers;

use App\Leave;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $leaves = auth()->user()->leaves()->paginate();
            // check if the user has permission to approve and deny leave 
            if (auth()->user()->hasPermission('approve-and-deny-leave')) {
                $leaves = Leave::where('organization_id' , auth()->user()->organization_id )->latest()->paginate();
            }
            return view('profile.home', [
                'leaves' => $leaves
            ]);
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
}
