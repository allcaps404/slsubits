@extends('layouts.event_manager.index')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Event Info -->
    <div class="flex flex-col md:flex-row justify-between md:items-center mb-6 space-y-4 md:space-y-0">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $event->name }}</h1>
            <p class="text-gray-600 mt-2">{{ $event->description }}</p>
            <div class="mt-2 flex flex-wrap gap-4 text-sm text-gray-500">
                <span>Academic Year: {{ $event->academic_year }}</span>
                <span>
                    {{ $event->semester == 1 ? '1st Semester' : '2nd Semester' }}
                </span>
            </div>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('event_manager.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md transition duration-300">
                Back to Events
            </a>
        </div>
    </div>

  
        <!-- Filters Section -->
<div class="bg-white rounded-lg shadow-md p-4 mb-6">
    <h2 class="text-lg font-semibold mb-4 text-gray-700">Filters</h2>
    <form method="GET" action="{{ route('event_manager.show', $event->id) }}" class="mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Student ID -->
            <div>
                <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1">Student ID</label>
                <input type="text" name="student_id" id="student_id" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md" 
                       placeholder="Enter student ID" 
                       value="{{ request('student_id') }}">
            </div>

            <!-- Student Name -->
            <div>
                <label for="student_name" class="block text-sm font-medium text-gray-700 mb-1">Student Name</label>
                <input type="text" name="student_name" id="student_name" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md" 
                       placeholder="Enter student name" 
                       value="{{ request('student_name') }}">
            </div>

            <!-- Course -->
            <div>
                <label for="course" class="block text-sm font-medium text-gray-700 mb-1">Course</label>
                <select name="course" id="course" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="">All Courses</option>
                    <option value="BSIT" {{ request('course') == 'BSIT' ? 'selected' : '' }}>BSIT</option>
                    
                </select>
            </div>

            <!-- Year -->
            <div>
                <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                <select name="year" id="year" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="">Filter by Year</option>
                    <option value="1st" {{ request('year') == '1st' ? 'selected' : '' }}>1st Year</option>
                    <option value="2nd" {{ request('year') == '2nd' ? 'selected' : '' }}>2nd Year</option>
                    <option value="3rd" {{ request('year') == '3rd' ? 'selected' : '' }}>3rd Year</option>
                    <option value="4th" {{ request('year') == '4th' ? 'selected' : '' }}>4th Year</option>
                </select>
            </div>

            <!-- Section -->
            <div>
                <label for="section" class="block text-sm font-medium text-gray-700 mb-1">Section</label>
                <select name="section" id="section" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="">All Sections</option>
                    <option value="A" {{ request('section') == 'A' ? 'selected' : '' }}>Section A</option>
                    <option value="B" {{ request('section') == 'B' ? 'selected' : '' }}>Section B</option>
                    <option value="C" {{ request('section') == 'C' ? 'selected' : '' }}>Section C</option>
                </select>
            </div>

            

            <!-- Buttons -->
            <div class="flex items-end gap-2">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md transition-colors">
                    Apply Filters
                </button>
                <a href="{{ route('event_manager.show', $event->id) }}" 
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md transition-colors">
                    Clear Filters
                </a>
            </div>
        </div>
    </form>
</div>

    <!-- Attendance Summary -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <h2 class="text-lg font-semibold mb-4 text-gray-700">Attendance Summary</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Add your summary cards here -->
        </div>
    </div>

    <!-- Attendance Logs Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-indigo-600 to-blue-600">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Student ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Student Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Course</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Year</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Section</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Login Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Logout Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Duration</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($attendanceLogs as $log)
                    <tr class="hover:bg-indigo-50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $log->student->otherDetail->idnumber ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-800">
                                {{ $log->student->lastname ?? '' }}, {{ $log->student->firstname ?? '' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $log->student->otherDetail->course ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $log->student->otherDetail->year ?? 'N/A' }} 
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $log->student->otherDetail->section ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $log->login_time ? \Carbon\Carbon::parse($log->login_time)->format('M d, Y h:i A') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $log->logout_time ? \Carbon\Carbon::parse($log->logout_time)->format('M d, Y h:i A') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-700">
                            @if($log->login_time && $log->logout_time)
                                {{ \Carbon\Carbon::parse($log->login_time)->diff(\Carbon\Carbon::parse($log->logout_time))->format('%Hh %Im') }}
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            No attendance records found for this event.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($attendanceLogs->hasPages())
        <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
            {{ $attendanceLogs->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection