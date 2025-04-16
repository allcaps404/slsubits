@extends('layouts.event_manager.index')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Event Management</h1>
        <a href="{{ route('event_manager.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition duration-300 shadow-md hover:shadow-lg">
            Create New Event
        </a>
    </div>

  <!-- Filters Card -->
<div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg shadow-md p-4 mb-6 border border-blue-100">
    <form method="GET" action="{{ route('event_manager.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label for="event_name" class="block text-sm font-medium text-blue-700 mb-1">Event Name</label>
            <input type="text" id="event_name" name="event_name" value="{{ request('event_name') }}" 
                   class="w-full border border-blue-200 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white"
                   placeholder="Search by name">
        </div>
        
        <div>
            <label for="academic_year" class="block text-sm font-medium text-blue-700 mb-1">Academic Year</label>
            <select id="academic_year" name="academic_year" class="w-full border border-blue-200 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                <option value="">All Years</option>
                @foreach($academicYears as $year)
                    <option value="{{ $year }}" {{ request('academic_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>
        </div>
        
        <div>
            <label for="semester" class="block text-sm font-medium text-blue-700 mb-1">Semester</label>
            <select id="semester" name="semester" class="w-full border border-blue-200 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                <option value="">All Semesters</option>
                <option value="1st Semester" {{ request('semester') == '1st Semester' ? 'selected' : '' }}>1st Semester</option>
                <option value="2nd Semester" {{ request('semester') == '2nd Semester' ? 'selected' : '' }}>2nd Semester</option>
            </select>
        </div>
        
        <div>
            <label for="event_date" class="block text-sm font-medium text-blue-700 mb-1">Date</label>
            <input type="date" id="event_date" name="event_date" value="{{ request('event_date') }}" 
                   class="w-full border border-blue-200 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
        </div>
        
        <div class="md:col-span-4 flex space-x-2">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition duration-300 shadow-md hover:shadow-lg">
                Apply Filters
            </button>
            @if(request()->hasAny(['event_name', 'academic_year', 'semester', 'event_date']))
            <a href="{{ route('event_manager.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-md transition duration-300 shadow-md hover:shadow-lg">
                Reset Filters
            </a>
            @endif
        </div>
    </form>
</div>

    <!-- Events Table -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-blue-600 to-indigo-600">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Event Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Date & Time</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Academic Year</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Semester</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Attendees</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($events as $event)
                    <tr class="hover:bg-blue-50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium text-gray-900">{{ $event->name }}</div>
                            <div class="text-sm text-gray-600">{{ Str::limit($event->description, 50) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                            {{ $event->event_date}}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                            {{ $event->academic_year }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                            {{ $event->semester }}
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="mr-2 text-gray-700">{{ $event->attendanceLogs->count() }}</span>
                                @if($event->expected_attendees)
                                <span class="text-xs text-blue-600 font-medium">{{ round(($event->attendanceLogs->count()/$event->expected_attendees)*100) }}%</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $now = now();
                                $status = $event->event_date > $now ? 'Upcoming' : 
                                         ($event->event_date == $now->format('Y-m-d') ? 'Today' : 'Completed');
                            @endphp
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $status == 'Upcoming' ? 'bg-purple-100 text-purple-800' : 
                                   ($status == 'Today' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ $status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex space-x-3 justify-end">
                                <a href="{{ route('event_manager.show', $event->id) }}" class="text-blue-600 hover:text-blue-800 transform hover:scale-110 transition duration-200" title="View Attendance">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <a href="{{ route('event_manager.edit', $event->id) }}" class="text-indigo-600 hover:text-indigo-800 transform hover:scale-110 transition duration-200" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </a>
                                <form action="{{ route('event_manager.destroy', $event->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 transform hover:scale-110 transition duration-200" title="Delete" onclick="return confirm('Are you sure you want to delete this event?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500 bg-blue-50">
                            No events found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($events->hasPages())
        <div class="bg-blue-50 px-6 py-3 border-t border-blue-100">
            {{ $events->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection