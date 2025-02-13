@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h3>Edit Event</h3>
                </div>
                <div class="card-body">
                    <form id="eventForm" method="POST" action="{{ route('admin.events.update', $event->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="event_name">Event Name</label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $event->name) }}" required>
                                </div>
                            </div>

                            <!-- Short Description Field next to Name -->
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="short_description">Short Description</label>
                                    <textarea class="form-control" name="short_description" id="short_description" rows="3" required>{{ old('short_description', $event->short_description) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="event_date">Event Date</label>
                                    <input type="date" class="form-control" name="event_date" id="event_date" value="{{ old('event_date', \Carbon\Carbon::parse($event->event_date)->format('Y-m-d')) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="login_time">Login Time</label>
                                    <input type="time" class="form-control" name="login_time" id="login_time" value="{{ old('login_time', \Carbon\Carbon::parse($event->login_time)->format('H:i')) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="logout_time">Logout Time</label>
                                    <input type="time" class="form-control" name="logout_time" id="logout_time" value="{{ old('logout_time', \Carbon\Carbon::parse($event->logout_time)->format('H:i')) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="academic_year">Academic Year</label>
                                    <select class="form-control" name="academic_year" id="academic_year" required>
                                        @for($year = 2021; $year <= 2030; $year++)
                                            <option value="{{ $year }}-{{ $year + 1 }}" {{ old('academic_year', $event->academic_year) == "$year-" . ($year + 1) ? 'selected' : '' }}>
                                                {{ $year }}-{{ $year + 1 }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="semester">Semester</label>
                                    <select class="form-control" name="semester" id="semester" required>
                                        <option value="1st Semester" {{ old('semester', $event->semester) == '1st Semester' ? 'selected' : '' }}>1st Semester</option>
                                        <option value="2nd Semester" {{ old('semester', $event->semester) == '2nd Semester' ? 'selected' : '' }}>2nd Semester</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm" id="submitBtn">Update Event</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('eventForm').addEventListener('submit', function (e) {
        e.preventDefault();
        if (confirm('Are you sure you want to submit the form?')) {
            this.submit();
        }
    });
</script>
@endsection
