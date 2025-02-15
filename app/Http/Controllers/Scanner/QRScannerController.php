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
        // Find the student by QR code
        $student = User::where('qr_code', $qr_code)->first();
        $event_id = $request->query('event_id');

        if (!$student) {
            return response()->json(['success' => false, 'message' => '❌ Student not found.'], 400);
        }

        // Find event details
        $event = Event::find($event_id);
        if (!$event) {
            return response()->json(['success' => false, 'message' => '❌ Invalid event.'], 400);
        }

        // Get current time with Manila timezone
        $now = Carbon::now()->timezone('Asia/Manila');

        // Compute allowed login/logout time ranges
        $loginStartTime = Carbon::parse($event->login_datetime)->timezone('Asia/Manila')->subHour(); // 1 hour before login
        $loginEndTime = Carbon::parse($event->login_datetime)->timezone('Asia/Manila'); // Login time

        $logoutStartTime = Carbon::parse($event->logout_datetime)->timezone('Asia/Manila'); // Logout time
        $logoutEndTime = Carbon::parse($event->logout_datetime)->timezone('Asia/Manila')->addHour(); // 1 hour after logout

        // Check if student already has an attendance log
        $attendance = AttendanceLog::where('event_id', $event->id)
            ->where('student_id', $student->id)
            ->first();

        if (!$attendance) {
            // **LOGIN CASE**: Student is logging in
            if ($now->between($loginStartTime, $loginEndTime)) {
                AttendanceLog::create([
                    'event_id' => $event_id,
                    'student_id' => $student->id,
                    'login_time' => $now,
                ]);
                $message = '✅ Login successful!';
            } else {
                return response()->json(['success' => false, 'message' => '❌ Login is only allowed 1 hour before the event start time.'], 400);
            }
        } elseif ($attendance && !$attendance->logout_time) {
            // **LOGOUT CASE**: Student is logging out
            if ($now->between($logoutStartTime, $logoutEndTime)) {
                $attendance->logout_time = $now;
                $attendance->save();
                $message = '✅ Logout successful!';
            } else {
                return response()->json(['success' => false, 'message' => '❌ Logout is only allowed 1 hour after the event end time.'], 400);
            }
        } else {
            return response()->json(['success' => false, 'message' => '❌ You have already logged out.'], 400);
        }

        // Fetch additional student details
        $details = OtherDetail::where('user_id', $student->id)->first();
        $fullName = trim($student->firstname . ' ' . ($student->middlename ?? '') . ' ' . $student->lastname);

        $photo = $student->photo ? 'data:image/jpeg;base64,' . base64_encode($student->photo) : 'https://www.gravatar.com/avatar/?d=mp';
        return response()->json([
            'success' => true,
            'message' => $message,
            'name' => $fullName,
            'photo' => $photo,
            'course' => $details->course ?? 'N/A',
            'year' => $details->year ?? 'N/A',
            'section' => $details->section ?? 'N/A',
            'semester' => $details->semester ?? 'N/A',
            'academic_year' => $details->academic_year ?? 'N/A',
        ]);
    }
}
