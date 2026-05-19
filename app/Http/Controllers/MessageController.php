<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = auth()->user()->receivedMessages()->with('sender', 'trip')->latest()->get();
        return view('messages.index', compact('messages'));
    }

    public function store(Request $request, Trip $trip)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $receiverId = $trip->driver_id === auth()->id() 
            ? $request->input('receiver_id') // Driver replies to passenger
            : $trip->driver_id; // Passenger messages driver

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $receiverId,
            'trip_id' => $trip->id,
            'content' => $request->input('content'),
        ]);

        return back()->with('success', 'Message envoyé avec succès !');
    }
}
