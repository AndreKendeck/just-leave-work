<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SessionController extends Controller
{
    public function index()
    {
        $sessions = Session::latest()->paginate();
        return view('sessions.index', [
            'sessions' => $sessions
        ]);
    }
}
