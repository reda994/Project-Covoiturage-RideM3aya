<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('notifications.index', compact('notifications'));
    }
    
    public function markAsRead(Notification $notification)
    {
        $notification->markAsRead();
        
        return back()->with('success', 'Notification marquée comme lue.');
    }
}