<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        return view('notifications.index', [
            'notifications' => auth()->user()->notifications()->latest()->paginate()
        ]);
    }

    public function read()
    {
        auth()->user()->unreadNotifications->each(function ($notification) {
            $notification->markAsRead();
        });

        return response()->json(['message' => 'complete']);
    }
}
