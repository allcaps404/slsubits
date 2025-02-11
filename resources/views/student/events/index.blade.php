@extends('layouts.student.index')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-4">📅 Events/Activities</h2>

    <table class="min-w-full bg-white border border-gray-300">
        <thead>
            <tr>
                <th class="px-4 py-2 border">Event Name</th>
                <th class="px-4 py-2 border">Date</th>
                <th class="px-4 py-2 border">Academic Year</th>
                <th class="px-4 py-2 border">Semester</th>
                <th class="px-4 py-2 border">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
            <tr>
                <td class="px-4 py-2 border">{{ $event->name }}</td>
                <td class="px-4 py-2 border">{{ $event->event_date }}</td>
                <td class="px-4 py-2 border">{{ $event->academic_year }}</td>
                <td class="px-4 py-2 border">{{ $event->semester }}</td>
                <td class="px-4 py-2 border text-center">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 attend-btn" data-id="{{ $event->id }}">
                        ✅ Attend
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
