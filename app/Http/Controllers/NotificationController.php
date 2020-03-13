<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->latest()->paginate(10);
        return view('notifications.index', [
            'notifications' => $notifications
        ]);
    }

    public function read()
    {
        if (auth()->user()->unreadNotifications->count() > 0) {
            auth()->user()->unreadNotifcations->each(function ($notification) {
                $notification->markAsRead();
            });
        }
        return response()->json(['message' => 'Notifications read' ]);
    }
    public function destroy($id)
    {
        $notification = DatabaseNotification::findOrFail($id);
        $notification->delete();
        return response()->json([
            'message' => 'Deleted'
         ], 200);
    }
}
