<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::when($request->name, function ($query) use ($request) {
            return $query->where('name', 'like', '%' . $request->name . '%');
        })
        ->when($request->event_date, function ($query) use ($request) {
            return $query->whereDate('event_date', $request->event_date);
        })
        ->when($request->academic_year, function ($query) use ($request) {
            return $query->where('academic_year', $request->academic_year);
        })
        ->when($request->semester, function ($query) use ($request) {
            return $query->where('semester', $request->semester);
        })
        ->paginate(10); 

        $title = 'Event Management'; 
        return view('admin.events.index', compact('events', 'title'));
    }

    public function create()
    {
        $title = 'Create Event';
        return view('admin.events.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'event_date' => 'required|date',
            'login_time' => 'required|date_format:H:i',
            'logout_time' => 'required|date_format:H:i',
            'academic_year' => 'required|string|max:255',
            'semester' => 'required|string|max:255',
        ]);

        $event = new Event();

        $event->name = $request->name;
        $event->short_description = $request->short_description;
        $event->event_date = $request->event_date;
        $event->login_datetime = $request->event_date . ' ' . $request->login_time;
        $event->logout_datetime = $request->event_date . ' ' . $request->logout_time;
        $event->academic_year = $request->academic_year;
        $event->semester = $request->semester;

        $event->save();

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully');
    }
    public function show(Event $event)
    {
        $title = 'Event Details';
        return view('admin.events.show', compact('event', 'title'));
    }
    public function edit(Event $event)
    {
        $title = 'Edit Event';
        return view('admin.events.edit', compact('event', 'title'));
    }
    
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'event_date' => 'required|date',
            'login_time' => 'required|date_format:H:i',
            'logout_time' => 'required|date_format:H:i',
            'academic_year' => 'required|string|max:255',
            'semester' => 'required|string|max:255',
        ]);
    
        $event->name = $request->name;
        $event->short_description = $request->short_description;
        $event->event_date = $request->event_date;
        $event->login_datetime = $request->event_date . ' ' . $request->login_time;
        $event->logout_datetime = $request->event_date . ' ' . $request->logout_time;
        $event->academic_year = $request->academic_year;
        $event->semester = $request->semester;
    
        $event->save();
    
        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }
    

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }
}

