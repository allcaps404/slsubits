@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h5 mb-2 text-gray-800">Event Management</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="GET" action="{{ route('admin.events.index') }}" class="mb-3">
        <div class="row">
            <div class="col-md-3 mb-2">
                <input type="text" name="name" class="form-control" placeholder="Filter by Event Name" value="{{ request('name') }}">
            </div>
            <div class="col-md-3 mb-2">
                <input type="date" name="event_date" class="form-control" value="{{ request('event_date') }}">
            </div>
            <div class="col-md-3 mb-2">
                <select name="academic_year" class="form-control">
                    <option value="">Filter by Academic Year</option>
                    @for($year = 2021; $year <= 2030; $year++)
                        <option value="{{ $year }}" {{ request('academic_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3 mb-2">
                <select name="semester" class="form-control">
                    <option value="">Filter by Semester</option>
                    <option value="1st Semester" {{ request('semester') == '1st Semester' ? 'selected' : '' }}>1st Semester</option>
                    <option value="2nd Semester" {{ request('semester') == '2nd Semester' ? 'selected' : '' }}>2nd Semester</option>
                </select>
            </div>
            <div class="col-md-3 mb-2">
                <button type="submit" class="btn btn-primary btn-block">Search</button>
            </div>
        </div>
    </form>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('events.create') }}" class="btn btn-primary btn-sm">Create New Event</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="small">Event Name</th>
                            <th class="small">Short Description</th> <!-- New Column for Short Description -->
                            <th class="small">Event Date</th>
                            <th class="small">Login DateTime</th>
                            <th class="small">Logout DateTime</th>
                            <th class="small">Academic Year</th>
                            <th class="small">Semester</th>
                            <th class="small">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                            <tr>
                                <td class="small">{{ $event->name }}</td>
                                <td class="small">{{ $event->short_description }}</td> <!-- Short Description -->
                                <td class="small">{{ \Carbon\Carbon::parse($event->event_date)->format('F j, Y') }}</td>
                                <td class="small">{{ \Carbon\Carbon::parse($event->login_datetime)->format('F j, Y H:i') }}</td>
                                <td class="small">{{ \Carbon\Carbon::parse($event->logout_datetime)->format('F j, Y H:i') }}</td>
                                <td class="small">{{ $event->academic_year }}</td>
                                <td class="small">{{ $event->semester }}</td>
                                <td>
                                    <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $events->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [],
            "paging": true,
            "info": false,
            "columnDefs": [
                { "orderable": false, "targets": [7] }
            ]
        });
    });
</script>
@endsection
