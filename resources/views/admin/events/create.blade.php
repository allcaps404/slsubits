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

            {{-- Display Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h3>Create New Event</h3>
                </div>
                <div class="card-body">
                    <form id="eventForm" method="POST" action="{{ route('events.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="name">Event Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           name="name" id="name" 
                                           value="{{ old('name') }}" 
                                           placeholder="Enter event name" required>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="short_description">Short Description</label>
                                    <textarea class="form-control @error('short_description') is-invalid @enderror" 
                                              name="short_description" id="short_description" rows="3" 
                                              placeholder="Enter short description" required>{{ old('short_description') }}</textarea>
                                    @error('short_description')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="event_date">Event Date</label>
                                    <input type="date" class="form-control @error('event_date') is-invalid @enderror" 
                                           name="event_date" id="event_date" 
                                           value="{{ old('event_date') }}" required>
                                    @error('event_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="login_datetime">Login Time</label>
                                    <input type="datetime-local" class="form-control @error('login_datetime') is-invalid @enderror" 
                                           name="login_datetime" id="login_datetime" 
                                           value="{{ old('login_datetime') }}" required>
                                    @error('login_datetime')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="logout_datetime">Logout Time</label>
                                    <input type="datetime-local" class="form-control @error('logout_datetime') is-invalid @enderror" 
                                           name="logout_datetime" id="logout_datetime" 
                                           value="{{ old('logout_datetime') }}" required>
                                    @error('logout_datetime')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="academic_year">Academic Year</label>
                                    <select class="form-control @error('academic_year') is-invalid @enderror" 
                                            name="academic_year" id="academic_year" required>
                                        @for($year = 2021; $year <= 2030; $year++)
                                            <option value="{{ $year }}-{{ $year + 1 }}" 
                                                {{ old('academic_year') == "$year-$year + 1" ? 'selected' : '' }}>
                                                {{ $year }}-{{ $year + 1 }}
                                            </option>
                                        @endfor
                                    </select>
                                    @error('academic_year')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="semester">Semester</label>
                                    <select class="form-control @error('semester') is-invalid @enderror" 
                                            name="semester" id="semester" required>
                                        <option value="1st Semester" {{ old('semester') == '1st Semester' ? 'selected' : '' }}>1st Semester</option>
                                        <option value="2nd Semester" {{ old('semester') == '2nd Semester' ? 'selected' : '' }}>2nd Semester</option>
                                    </select>
                                    @error('semester')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm" id="submitBtn">Create Event</button>
                        <div id="loadingSpinner" class="text-center mt-2" style="display: none;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
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
            document.getElementById('loadingSpinner').style.display = 'block';
            this.submit();
        }
    });
</script>
@endsection
