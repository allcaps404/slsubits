@extends('layouts.event_manager.index')

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
                    <form id="eventForm" method="POST" action="{{ route('event_manager.update', $event->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="name">Event Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                        name="name" id="name" value="{{ old('name', $event->name) }}" required>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="short_description">Short Description</label>
                                    <textarea class="form-control @error('short_description') is-invalid @enderror" 
                                        name="short_description" id="short_description" rows="3" required>{{ old('short_description', $event->short_description) }}</textarea>
                                    @error('short_description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="event_date">Event Date</label>
                                    <input type="date" class="form-control @error('event_date') is-invalid @enderror" 
                                        name="event_date" id="event_date" value="{{ old('event_date', \Carbon\Carbon::parse($event->event_date)->format('Y-m-d')) }}" required>
                                    @error('event_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="login_datetime">Login Time</label>
                                    <input type="datetime-local" class="form-control @error('login_datetime') is-invalid @enderror" 
                                        name="login_datetime" id="login_datetime" value="{{ old('login_datetime', \Carbon\Carbon::parse($event->login_datetime)->format('Y-m-d\TH:i')) }}" required>
                                    @error('login_datetime')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="logout_datetime">Logout Time</label>
                                    <input type="datetime-local" class="form-control @error('logout_datetime') is-invalid @enderror" 
                                        name="logout_datetime" id="logout_datetime" value="{{ old('logout_datetime', \Carbon\Carbon::parse($event->logout_datetime)->format('Y-m-d\TH:i')) }}" required>
                                    @error('logout_datetime')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="academic_year">Academic Year</label>
                                    <select class="form-control @error('academic_year') is-invalid @enderror" name="academic_year" id="academic_year" required>
                                        @for($year = 2021; $year <= 2030; $year++)
                                            <option value="{{ $year }}-{{ $year + 1 }}" 
                                                {{ (old('academic_year') ?? $event->academic_year) == "$year-" . ($year + 1) ? 'selected' : '' }}>
                                                {{ $year }}-{{ $year + 1 }}
                                            </option>
                                        @endfor
                                    </select>
                                    @error('academic_year')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="semester">Semester</label>
                                    <select class="form-control @error('semester') is-invalid @enderror" name="semester" id="semester" required>
                                        <option value="1st Semester" {{ old('semester', $event->semester) == '1st Semester' ? 'selected' : '' }}>1st Semester</option>
                                        <option value="2nd Semester" {{ old('semester', $event->semester) == '2nd Semester' ? 'selected' : '' }}>2nd Semester</option>
                                    </select>
                                    @error('semester')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
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
        if (confirm('Are you sure you want to update this event?')) {
            document.getElementById('submitBtn').disabled = true;
            this.submit();
        }
    });
</script>
@endsection
