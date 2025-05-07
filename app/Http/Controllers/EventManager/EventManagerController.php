<?php

namespace App\Http\Controllers\EventManager;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Exports\EventAttendanceExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use App\Models\User;


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
   

public function exportExcel(Event $event, Request $request)
{
    $filters = $request->filters ? json_decode($request->filters, true) : [];
    return Excel::download(new EventAttendanceExport($event, $filters), "event-{$event->id}-attendance.xlsx");
}

public function exportWord(Event $event, Request $request)
{
    $filters = $request->filters ? json_decode($request->filters, true) : [];
    $attendanceLogs = $this->getFilteredAttendanceLogs($event, $filters);
    
    $phpWord = new PhpWord();
    $section = $phpWord->addSection();
    
    // Add title
    $section->addText("Attendance Report for {$event->name}", ['bold' => true, 'size' => 16]);
    $section->addTextBreak(2);
    
    // Add table
    $table = $section->addTable();
    $table->addRow();
    // Add headers
    $headers = ['Student ID', 'Student Name', 'Course', 'Year', 'Section', 'Login Time', 'Logout Time', 'Duration'];
    foreach ($headers as $header) {
        $table->addCell(2000)->addText($header, ['bold' => true]);
    }
    
    // Add data rows
    foreach ($attendanceLogs as $log) {
        $table->addRow();
        $cells = [
            $log->student->otherDetail->idnumber ?? 'N/A',
            ($log->student->lastname ?? '') . ', ' . ($log->student->firstname ?? ''),
            $log->student->otherDetail->course ?? 'N/A',
            $log->student->otherDetail->year ?? 'N/A',
            $log->student->otherDetail->section ?? 'N/A',
            $log->login_time ? \Carbon\Carbon::parse($log->login_time)->format('M d, Y h:i A') : 'N/A',
            $log->logout_time ? \Carbon\Carbon::parse($log->logout_time)->format('M d, Y h:i A') : 'N/A',
            $log->login_time && $log->logout_time 
                ? \Carbon\Carbon::parse($log->login_time)->diff(\Carbon\Carbon::parse($log->logout_time))->format('%Hh %Im') 
                : 'N/A'
        ];
        
        foreach ($cells as $cellContent) {
            $table->addCell(2000)->addText($cellContent);
        }
    }
    
    $fileName = "event-{$event->id}-attendance.docx";
    $tempFile = tempnam(sys_get_temp_dir(), 'word');
    $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter->save($tempFile);
    
    return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
}

public function exportPDF(Event $event, Request $request)
{
    $filters = $request->filters ? json_decode($request->filters, true) : [];
    $attendanceLogs = $this->getFilteredAttendanceLogs($event, $filters);
    
    $pdf = PDF::loadView('event_manager.event-attendance-pdf', [
        'event' => $event,
        'attendanceLogs' => $attendanceLogs
    ]);
    
    return $pdf->download("event-{$event->id}-attendance.pdf");
}

private function getFilteredAttendanceLogs(Event $event, array $filters)
{
    $query = $event->attendanceLogs()->with(['student', 'student.otherDetail']);
    
    if (!empty($filters['student_id'])) {
        $query->whereHas('student.otherDetail', function($q) use ($filters) {
            $q->where('idnumber', 'like', '%' . $filters['student_id'] . '%');
        });
    }
    
    if (!empty($filters['student_name'])) {
        $query->whereHas('student', function($q) use ($filters) {
            $q->where('firstname', 'like', '%' . $filters['student_name'] . '%')
              ->orWhere('lastname', 'like', '%' . $filters['student_name'] . '%');
        });
    }
    
    // Add other filters as needed...
    
    return $query->get();
}
public function byStudentIndex(Request $request)
{
    $students = \App\Models\User::query()
        ->whereHas('role', function ($q) {
            $q->where('role_name', 'student');
        })
        ->when($request->student_name, function ($query) use ($request) {
            $query->where(function ($q) use ($request) {
                $q->where('firstname', 'like', '%' . $request->student_name . '%')
                  ->orWhere('lastname', 'like', '%' . $request->student_name . '%');
            });
        })
        ->when($request->student_id, function ($query) use ($request) {
            $query->whereHas('otherDetail', function ($q) use ($request) {
                $q->where('idnumber', 'like', '%' . $request->student_id . '%');
            });
        })
        ->when($request->course, function ($query) use ($request) {
            $query->whereHas('otherDetail', function ($q) use ($request) {
                $q->where('course', 'like', '%' . $request->course . '%');
            });
        })
        ->when($request->gender, function ($query) use ($request) {
            $query->where('gender', $request->gender);
        })
        ->when($request->semester, function ($query) use ($request) {
            $query->whereHas('otherDetail', function ($q) use ($request) {
                $q->where('semester', $request->semester);
            });
        })
        ->when($request->academic_year, function ($query) use ($request) {
            $query->whereHas('otherDetail', function ($q) use ($request) {
                $q->where('academic_year', $request->academic_year);
            });
        })
        ->with(['role', 'otherDetail']) // Eager load relationships
        ->paginate(10);

    return view('event_manager.by_student.index', compact('students'));
}

public function byStudentShow($id)
{
    $student = User::with([
        'otherDetail',
        'attendanceLogs.event' 
    ])->findOrFail($id);

    return view('event_manager.by_student.show', compact('student'));
}

public function byYearSectionIndex(Request $request)
{
    $students = Event::query()
       
        
        ->when($request->course, fn($q) => $q->whereHas('student.otherDetail', function($subQuery) use ($request) {
            $subQuery->where('course', 'like', '%' . $request->course . '%');
        }))
       
        ->when($request->semester, fn($q) => $q->whereHas('student.otherDetail', function($subQuery) use ($request) {
            $subQuery->where('semester', $request->semester);
        }))
        ->when($request->academic_year, fn($q) => $q->whereHas('student.otherDetail', function($subQuery) use ($request) {
            $subQuery->where('academic_year', $request->academic_year);
        }))
        ->withCount('attendanceLogs')
        ->paginate(10);

    return view('event_manager.by_year_section.index', compact('students'));
}

public function byYearSectionShow($id)
{
    $student = Event::with(['attendanceLogs.event', 'student', 'student.otherDetail'])
        ->findOrFail($id);

    return view('event_manager.by_year_section.show', compact('student'));
}
}