<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;


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
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'required|string',
            'event_date' => 'required|date',
            'login_datetime' => 'required|date_format:Y-m-d\TH:i',
            'logout_datetime' => 'required|date_format:Y-m-d\TH:i|after:login_time',
            'academic_year' => 'required|string',
            'semester' => 'required|string',
        ]);

        try {
            // Create and save the event using mass assignment
            Event::create($validatedData);

            // Redirect with success message
            return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
        } catch (\Exception $e) {
            // Redirect back with an error message
            return redirect()->back()->withInput()->with('error', $e.'An error occurred while saving the event.');
        }
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
    public function update(Request $request, $id)
    {
        // Validate input fields
        $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'event_date' => 'required|date',
            'login_datetime' => 'required|date_format:Y-m-d\TH:i',
            'logout_datetime' => 'required|date_format:Y-m-d\TH:i|after:login_datetime',
            'academic_year' => 'required|string',
            'semester' => 'required|string|in:1st Semester,2nd Semester',
        ], [
            'name.required' => 'The event name is required.',
            'short_description.required' => 'Please provide a short description.',
            'event_date.required' => 'The event date is required.',
            'login_datetime.required' => 'The login datetime is required.',
            'logout_datetime.required' => 'The logout datetime is required.',
            'logout_datetime.after' => 'Logout datetime must be after login datetime.',
            'academic_year.required' => 'Academic year is required.',
            'semester.required' => 'Please select a semester.',
        ]);

        // Find the event by ID
        $event = Event::findOrFail($id);

        try {
            // Update event details
            $event->update([
                'name' => $request->name,
                'short_description' => $request->short_description,
                'event_date' => Carbon::parse($request->event_date),
                'login_datetime' => Carbon::parse($request->login_datetime),
                'logout_datetime' => Carbon::parse($request->logout_datetime),
                'academic_year' => $request->academic_year,
                'semester' => $request->semester,
            ]);

            return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while updating the event.');
        }
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }
}

