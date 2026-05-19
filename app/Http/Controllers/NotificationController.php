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
        $this->authorize('update', $notification);
        $notification->markAsRead();
        
        return back()->with('success', 'Notification marquée comme lue.');
    }

    public function markAllAsRead()
    {
        auth()->user()->notifications()->update(['is_read' => true]);
        return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }

    public function destroy(Notification $notification)
    {
        $this->authorize('delete', $notification);
        $notification->delete();
        
        return back()->with('success', 'Notification supprimée.');
    }
}