@extends('layouts.student.index')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-4 rounded-lg shadow-lg">
    <h2 class="text-lg font-semibold mb-3">📅 Events/Activities</h2>

    <!-- Events Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 text-sm">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-2 py-1 border">Event Name</th>
                    <th class="px-2 py-1 border">Date</th>
                    <th class="px-2 py-1 border">Login Time</th>
                    <th class="px-2 py-1 border">Logout Time</th>
                    <th class="px-2 py-1 border">Acad. Year</th>
                    <th class="px-2 py-1 border">Sem</th>
                    <th class="px-2 py-1 border text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                <tr>
                    <td class="px-2 py-1 border">{{ $event->name }}</td>
                    <td class="px-2 py-1 border">{{ $event->event_date }}</td>
                    <td class="px-2 py-1 border">{{ $event->login_datetime }}</td>
                    <td class="px-2 py-1 border">{{ $event->logout_datetime }}</td>
                    <td class="px-2 py-1 border">{{ $event->academic_year }}</td>
                    <td class="px-2 py-1 border">{{ $event->semester }}</td>
                    <td class="px-2 py-1 border text-center">
                        <button class="bg-blue-500 text-white text-xs px-2 py-1 rounded hover:bg-blue-600 attend-btn" data-id="{{ $event->id }}">
                            ✅
                        </button>
                        <button class="bg-red-500 text-white text-xs px-2 py-1 rounded hover:bg-red-600 logout-btn" data-id="{{ $event->id }}">
                            ❌
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Attended Events Table -->
    <h2 class="text-lg font-semibold mt-6 mb-3">✔️ Attended Events</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 text-sm">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-2 py-1 border">Event Name</th>
                    <th class="px-2 py-1 border">Date</th>
                    <th class="px-2 py-1 border">Login Time</th>
                    <th class="px-2 py-1 border">Logout Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendedEvents as $event)
                <tr>
                    <td class="px-2 py-1 border">{{ $event->name }}</td>
                    <td class="px-2 py-1 border">{{ $event->event_date }}</td>
                    <td class="px-2 py-1 border">{{ $event->login_time }}</td>
                    <td class="px-2 py-1 border">{{ $event->logout_time }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).on('click', '.attend-btn', function() {
        let eventId = $(this).data('id');
        $.post("{{ route('student.attend') }}", { event_id: eventId, _token: "{{ csrf_token() }}" }, function(response) {
            Swal.fire("Success", response.success, "success").then(() => location.reload());
        }).fail(function(xhr) {
            Swal.fire("Error", xhr.responseJSON.error, "error");
        });
    });

    $(document).on('click', '.logout-btn', function() {
        let eventId = $(this).data('id');
        $.post("{{ route('student.logout-attendance') }}", { event_id: eventId, _token: "{{ csrf_token() }}" }, function(response) {
            Swal.fire("Success", response.success, "success").then(() => location.reload());
        }).fail(function(xhr) {
            Swal.fire("Error", xhr.responseJSON.error, "error");
        });
    });
</script>
@endsection
