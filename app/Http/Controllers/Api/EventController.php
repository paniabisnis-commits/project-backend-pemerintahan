<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('event_date', 'asc')->get();

        return response()->json([
            'success' => true,
            'data' => $events
        ]);
    }


    public function store(Request $r)
    {
        $r->validate([
            'title' => 'required|string|min:3',
            'description' => 'required|string|min:5',
            'event_date' => 'required|date',
            'image' => 'nullable|image|max:2048',
        ]);

        $image = $r->file('image') ? $r->file('image')->store('events', 'public') : null;

        $event = Event::create([
            'title' => $r->title,
            'description' => $r->description,
            'event_date' => $r->event_date,
            'image' => $image
        ]);

        return response()->json($event, 201);
    }

    public function show(Event $event)
    {
        return $event;
    }

    public function update(Request $r, Event $event)
    {
        $r->validate([
            'title' => 'sometimes',
            'description' => 'sometimes',
            'event_date' => 'sometimes|date',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($r->image) {
            $event->image = $r->file('image')->store('events', 'public');
        }

        $event->update($r->only(['title', 'description', 'event_date']));

        return $event;
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
