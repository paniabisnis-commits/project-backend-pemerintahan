<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index(Request $r)
    {
        $query = Event::query();

        // Search
        if ($r->search) {
            $query->where('title', 'like', "%{$r->search}%");
        }

        // Filter tanggal event
        if ($r->date) {
            $query->whereDate('event_date', $r->date);
        }

        return $query->latest()->paginate(10);
    }

    public function store(Request $r)
    {
        $r->validate([
            'title' => 'required',
            'description' => 'required',
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

    public function update(Request $request, $id)
{
    $event = Event::findOrFail($id);

    $event->update([
        'title' => $request->title,
        'description' => $request->description,
        'event_date' => $request->event_date,
        'image' => $request->image,
    ]);

    return response()->json($event);
}


    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
