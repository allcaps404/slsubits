<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('event_date', 'desc')->get();
        $attendedEvents = \DB::table('attendance_logs')
							    ->join('events', 'attendance_logs.event_id', '=', 'events.id')
							    ->where('attendance_logs.student_id', auth()->id())
							    ->whereNotNull('attendance_logs.login_time')
							    ->select('events.name', 'events.event_date', 'attendance_logs.login_time', 'attendance_logs.logout_time')
							    ->get();
							    
        return view('student.events.index', compact('events', 'attendedEvents'));
    }
}