<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Attendance Report - {{ $event->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { color: #2d3748; font-size: 24px; margin-bottom: 5px; }
        .subtitle { color: #4a5568; font-size: 14px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #2d3748; color: white; text-align: left; padding: 8px; }
        td { padding: 8px; border-bottom: 1px solid #e2e8f0; }
        tr:nth-child(even) { background-color: #f7fafc; }
    </style>
</head>
<body>
    <h1>Attendance Report for {{ $event->name }}</h1>
    <div class="subtitle">
        Academic Year: {{ $event->academic_year }} - 
        {{ $event->semester == 1 ? '1st Semester' : '2nd Semester' }}
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Course</th>
                <th>Year</th>
                <th>Section</th>
                <th>Login Time</th>
                <th>Logout Time</th>
                <th>Duration</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendanceLogs as $log)
            <tr>
                <td>{{ $log->student->otherDetail->idnumber ?? 'N/A' }}</td>
                <td>{{ $log->student->lastname ?? '' }}, {{ $log->student->firstname ?? '' }}</td>
                <td>{{ $log->student->otherDetail->course ?? 'N/A' }}</td>
                <td>{{ $log->student->otherDetail->year ?? 'N/A' }}</td>
                <td>{{ $log->student->otherDetail->section ?? 'N/A' }}</td>
                <td>{{ $log->login_time ? \Carbon\Carbon::parse($log->login_time)->format('M d, Y h:i A') : 'N/A' }}</td>
                <td>{{ $log->logout_time ? \Carbon\Carbon::parse($log->logout_time)->format('M d, Y h:i A') : 'N/A' }}</td>
                <td>
                    @if($log->login_time && $log->logout_time)
                        {{ \Carbon\Carbon::parse($log->login_time)->diff(\Carbon\Carbon::parse($log->logout_time))->format('%Hh %Im') }}
                    @else
                        N/A
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="margin-top: 30px; font-size: 12px; color: #718096;">
        Generated on {{ now()->format('M d, Y h:i A') }}
    </div>
</body>
</html>