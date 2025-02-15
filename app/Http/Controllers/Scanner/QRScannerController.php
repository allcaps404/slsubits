<?php

namespace App\Http\Controllers\Scanner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AttendanceLog;
use App\Models\OtherDetail;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Cache;

class QRScannerController extends Controller
{
    public function showScanner()
    {
        $events = Event::get();
        return view('scanner.index', compact('events'));
    }
	public function getStudent(Request $request, $qr_code)
	{
	    $ip = $request->ip();
	    $limitKey = 'scan-attempts:' . $ip;

	    // ✅ Rate Limiting: Allow only 5 scans per minute per IP
	    if (RateLimiter::tooManyAttempts($limitKey, 5)) {
	        return response()->json([
	            'success' => false,
	            'message' => '❌ Too many scan attempts. Please wait a moment before trying again.'
	        ], 429);
	    }

	    RateLimiter::hit($limitKey, 60); // Set cooldown time of 60 seconds

	    // ✅ Cache Student Data to Reduce Database Queries
	    $cacheKey = 'student-' . $qr_code;
	    $student = Cache::remember($cacheKey, 600, function () use ($qr_code) {
	        return User::where('qr_code', $qr_code)->first();
	    });

	    if (!$student) {
	        return response()->json(['success' => false, 'message' => '❌ Student not found.'], 400);
	    }

	    $event_id = $request->query('event_id');
	    $event = Event::find($event_id);

	    if (!$event) {
	        return response()->json(['success' => false, 'message' => '❌ Invalid event.'], 400);
	    }

	    // ✅ Set Manila Timezone
	    $now = Carbon::now()->timezone('Asia/Manila');

	    // ✅ Compute Allowed Login & Logout Time Ranges
	    $loginStartTime = Carbon::parse($event->login_datetime)->timezone('Asia/Manila')->subHour();
	    $loginEndTime = Carbon::parse($event->login_datetime)->timezone('Asia/Manila');

	    $logoutStartTime = Carbon::parse($event->logout_datetime)->timezone('Asia/Manila');
	    $logoutEndTime = Carbon::parse($event->logout_datetime)->timezone('Asia/Manila')->addHour();

	    // ✅ Check Attendance Log
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

	    // ✅ Fetch Student Details (Cached)
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
