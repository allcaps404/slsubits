<?php

namespace App\Http\Controllers\Scanner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AttendanceLog;
use App\Models\OtherDetail;
use App\Models\Event;
use Carbon\Carbon;

class QRScannerController extends Controller
{
     public function showScanner()
    {
        $events = Event::get();
        return view('scanner.index', compact('events'));
    }

    public function getStudent(Request $request, $qr_code)
    {
        $student = User::where('qr_code', $qr_code)->first();
        $event_id = $request->query('event_id');

        if (!$student) {
            return response()->json(['success' => false, 'message' => 'Student not found.']);
        }

        $event = Event::find($event_id);
        if (!$event) {
            return response()->json(['success' => false, 'message' => 'Invalid event.']);
        }

        $now = Carbon::now();
        if ($now < $event->login_datetime || $now > $event->logout_datetime) {
            return response()->json(['success' => false, 'message' => 'Attendance not allowed at this time.']);
        }

        $existingLog = AttendanceLog::where('event_id', $event_id)
            ->where('student_id', $student->id)
            ->first();

        if ($existingLog) {
            return response()->json(['success' => false, 'message' => 'Already logged in for this event.']);
        }

        AttendanceLog::create([
            'event_id' => $event_id,
            'student_id' => $student->id,
            'login_time' => Carbon::now(),
        ]);

        $details = OtherDetail::where('user_id', $student->id)->first();

        return response()->json([
            'success' => true,
            'name' => $student->name,
            'photo' => asset($student->photo ?? 'images/default.png'),
            'course' => $details->course ?? 'N/A',
            'year' => $details->year ?? 'N/A',
            'section' => $details->section ?? 'N/A',
            'semester' => $details->semester ?? 'N/A',
            'academic_year' => $details->academic_year ?? 'N/A',
        ]);
    }
}
