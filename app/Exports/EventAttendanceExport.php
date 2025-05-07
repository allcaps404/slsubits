<?php

namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EventAttendanceExport implements FromCollection, WithHeadings, WithMapping
{
    protected $event;
    protected $filters;
    
    public function __construct(Event $event, array $filters = [])
    {
        $this->event = $event;
        $this->filters = $filters;
    }
    
    public function collection()
    {
        $query = $this->event->attendanceLogs()->with(['student', 'student.otherDetail']);
        
        if (!empty($this->filters['student_id'])) {
            $query->whereHas('student.otherDetail', function($q) {
                $q->where('idnumber', 'like', '%' . $this->filters['student_id'] . '%');
            });
        }
        
        if (!empty($this->filters['student_name'])) {
            $query->whereHas('student', function($q) {
                $q->where('firstname', 'like', '%' . $this->filters['student_name'] . '%')
                  ->orWhere('lastname', 'like', '%' . $this->filters['student_name'] . '%');
            });
        }
        
        // Add other filters as needed...
        
        return $query->get();
    }
    
    public function headings(): array
    {
        return [
            'Student ID',
            'Student Name',
            'Course',
            'Year',
            'Section',
            'Login Time',
            'Logout Time',
            'Duration'
        ];
    }
    
    public function map($log): array
    {
        return [
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
    }
}