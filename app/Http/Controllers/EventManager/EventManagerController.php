<?php

namespace App\Http\Controllers\EventManager;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EventManagerController extends Controller
{
    public function index(Request $request)
    {
        // Get distinct academic years for filter dropdown
        $academicYears = Event::select('academic_year')
            ->distinct()
            ->orderBy('academic_year', 'desc')
            ->pluck('academic_year');
    
        // Query events with filters
        $events = Event::withCount('attendanceLogs')
            ->when($request->event_name, function ($query) use ($request) {
                return $query->where('name', 'like', '%'.$request->event_name.'%');
            })
            ->when($request->academic_year, function ($query) use ($request) {
                return $query->where('academic_year', $request->academic_year);
            })
            ->when($request->semester, function ($query) use ($request) {
                return $query->where('semester', $request->semester);
            })
            ->when($request->event_date, function ($query) use ($request) {
                return $query->whereDate('event_date', $request->event_date);
            })
            ->orderBy('event_date', 'desc')
            ->paginate(10);
    
        return view('event_manager.index', compact('events', 'academicYears'));
    }
    public function create()
    {
        $title = 'Create Event';
        return view('event_manager.create', compact('title'));
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
            return redirect()->route('event_manager.index')->with('success', 'Event created successfully.');
        } catch (\Exception $e) {
            // Redirect back with an error message
            return redirect()->back()->withInput()->with('error', $e.'An error occurred while saving the event.');
        }
    }

    public function show(Event $event, Request $request)
    {
        $query = $event->attendanceLogs()->with(['student', 'student.otherDetail']);
        
        // Apply filters using when() method for cleaner conditional queries
        $query->when($request->filled('student_id'), function ($q) use ($request) {
            $q->whereHas('student.otherDetail', function($subQuery) use ($request) {
                $subQuery->where('idnumber', 'like', '%'.$request->student_id.'%');
            });
        });
        
        $query->when($request->filled('student_name'), function ($q) use ($request) {
            $q->whereHas('student', function($subQuery) use ($request) {
                $subQuery->where('firstname', 'like', '%'.$request->student_name.'%')
                      ->orWhere('lastname', 'like', '%'.$request->student_name.'%');
            });
        });
        
        $query->when($request->filled('course'), function ($q) use ($request) {
            $q->whereHas('student.otherDetail', function($subQuery) use ($request) {
                $subQuery->where('course', $request->course);
            });
        });
        
        $query->when($request->filled('year'), function ($q) use ($request) {
            $q->whereHas('student.otherDetail', function($subQuery) use ($request) {
                $subQuery->where('year', $request->year);
            });
        });
        
        $query->when($request->filled('section'), function ($q) use ($request) {
            $q->whereHas('student.otherDetail', function($subQuery) use ($request) {
                $subQuery->where('section', $request->section);
            });
        });
        $attendanceLogs = $query->paginate(10)->appends($request->query());
        
        return view('event_manager.show', compact('event', 'attendanceLogs'));
    }
    public function edit(Event $event)
    {
        $title = 'Edit Event';
        return view('event_manager.edit', compact('event', 'title'));
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

            return redirect()->route('event_manager.index')->with('success', 'Event updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while updating the event.');
        }
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('event_manager.index')->with('success', 'Event deleted successfully.');
    }
}