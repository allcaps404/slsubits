<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AttendanceLog;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function attend(Request $request)
    {
        $event = Event::findOrFail($request->event_id);
        $user = Auth::user();
        $currentTime = Carbon::now()->timezone('Asia/Manila'); 
        $eventLoginTime = Carbon::parse($event->login_datetime)->timezone('Asia/Manila');
        $allowedLoginStartTime = $eventLoginTime->copy()->subHour();

        // Ensure login is within the allowed range
        if (!($currentTime->between($allowedLoginStartTime, $eventLoginTime))) {
            return response()->json(['error' => 'Login is only allowed within one hour before the event login time.'], 400);
        }

        // Check if user already logged in
        $attendance = AttendanceLog::where('event_id', $event->id)
            ->where('student_id', $user->id)
            ->first();

        if ($attendance) {
            return response()->json(['error' => 'You have already logged in for this event.'], 400);
        }

        // Save attendance
        $attendance = new AttendanceLog();
        $attendance->event_id = $event->id;
        $attendance->student_id = $user->id;
        $attendance->login_time = $currentTime;
        $attendance->save();

        return response()->json(['success' => 'Login successful.'], 200);
    }
    public function logout(Request $request)
    {
        $event = Event::findOrFail($request->event_id);
        $user = Auth::user();
        $currentTime = Carbon::now();
        $eventLogoutTime = Carbon::parse($event->logout_datetime);
        $allowedLogoutEndTime = $eventLogoutTime->copy()->addHour(); // Use copy() to avoid modifying original object

        // Check if logout time is within the allowed range
        if ($currentTime->lt($eventLogoutTime) || $currentTime->gt($allowedLogoutEndTime)) {
            return response()->json(['error' => 'Logout is only allowed during and up to one hour after the event logout time.'], 400);
        }

        // Find attendance record
        $attendance = AttendanceLog::where('event_id', $event->id)
            ->where('student_id', $user->id)
            ->first();

        if (!$attendance) {
            $attendance = new AttendanceLog();
            $attendance->event_id = $event->id;
            $attendance->student_id = $user->id;
            $attendance->logout_time = $currentTime;
        }else{
            $attendance->event_id = $event->id;
            $attendance->student_id = $user->id;
            $attendance->logout_time= $currentTime;
        }
        $attendance->save();
        return response()->json(['success' => 'Logout successful.'], 200);

    }
}
