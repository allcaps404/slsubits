@extends('layouts.event_manager.index')

@section('content')
<div class="container mx-auto px-4 py-6 w-full">
    
    <!-- Combined Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
    <!-- Card Header -->
        <div class="relative bg-indigo-50 px-6 py-4 border-b border-gray-200">
            <!-- Print Button (Top Right) -->
            <button onclick="window.print()" 
                class="absolute top-4 right-4 flex items-center px-3 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-100 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Print
            </button>

            <!-- Student Name -->
            <h1 class="text-xl font-bold text-gray-800">{{ $student->lastname }}, {{ $student->firstname }}</h1>

            <!-- Student Details (Vertical Layout) -->
                <div class="mt-3 space-y-2 text-sm text-gray-700">
                    <div class="px-3 py-2">
                        <strong>ID:</strong> {{ $student->otherDetail->idnumber }}
                    </div>
                    <div class="px-3 py-2">
                        <strong>Course:</strong> {{ $student->otherDetail->course }}
                    </div>
                    <div class="px-3 py-2">
                        <strong>Year & Section:</strong> {{ $student->otherDetail->year }} - {{ $student->otherDetail->section }}
                    </div>
                    <div class="px-3 py-2">
                        <strong>Semester:</strong> {{ $student->otherDetail->semester }}
                    </div>
                    <div class="px-3 py-2">
                        <strong>Academic Year:</strong> {{ $student->otherDetail->academic_year }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Body -->
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                </svg>
                Events Attended
            </h2>

            @if($student->attendanceLogs->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-sm text-gray-600 border-b">
                            <th class="pb-2 font-medium">Event Name</th>
                            <th class="pb-2 font-medium">Login Time</th>
                            <th class="pb-2 font-medium">Logout Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($student->attendanceLogs as $log)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="py-3 pr-4">{{ $log->event->name }}</td>
                            <td class="py-3 text-blue-600">{{ $log->login_time ?? '--' }}</td>
                            <td class="py-3 text-purple-600">{{ $log->logout_time ?? '--' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-8 bg-gray-50 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="mt-2 text-gray-500">No attendance records found</p>
            </div>
            @endif
        </div>

        <!-- Card Footer -->
        <div class="bg-gray-50 px-6 py-3 text-xs text-gray-500 border-t border-gray-200">
            Generated on {{ now()->format('M d, Y h:i A') }}
        </div>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .container, .container * {
            visibility: visible;
        }
        .container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            max-width: 100%;
        }
        button {
            display: none !important;
        }
    }
</style>
@endsection