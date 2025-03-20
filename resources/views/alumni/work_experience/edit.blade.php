@extends('layouts.alumni.index')

@section('content')

<div class="container mt-5 p-4">
    <!-- Title -->
    <div class="text-center mb-4">
        <h2>Edit Work Experience</h2>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger"> 
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="card shadow-sm">
                <div class="card-body">
    <form action="{{ route('work_experiences.update', $workExperience->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="position" class="form-label">Position</label>
            <input type="text" name="position" class="form-control" value="{{ $workExperience->position }}" required>
        </div>

        <div class="mb-3">
            <label for="company_name" class="form-label">Company Name</label>
            <input type="text" name="company_name" class="form-control" value="{{ $workExperience->company_name }}" required>
        </div>

        <div class="mb-3">
            <label for="contact_number" class="form-label">Contact Number</label>
            <input type="text" name="contact_number" class="form-control" value="{{ $workExperience->contact_number }}">
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" name="start_date" class="form-control" value="{{ $workExperience->start_date }}" required>
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" name="end_date" class="form-control" value="{{ $workExperience->end_date }}">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="currently_working" class="form-check-input" {{ $workExperience->currently_working ? 'checked' : '' }}>
            <label class="form-check-label">Currently Working</label>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4">{{ $workExperience->description }}</textarea>
        </div>

        <div class="mb-3">
    <label for="respondent_affiliation" class="form-label">Type of Organization</label>
    <select name="respondent_affiliation" id="respondent_affiliation" class="form-control" required>
        <option value="" disabled>Select Organization Type</option>
        <option value="Government" {{ $workExperience->respondent_affiliation == 'Government' ? 'selected' : '' }}>Government</option>
        <option value="Non-Government" {{ $workExperience->respondent_affiliation == 'Non-Government' ? 'selected' : '' }}>Non-Government Organization (NGO)</option>
        <option value="Private" {{ $workExperience->respondent_affiliation == 'Private' ? 'selected' : '' }}>Private Corporation</option>
        <option value="Public Corporation" {{ $workExperience->respondent_affiliation == 'Public Corporation' ? 'selected' : '' }}>Public Corporation</option>
        <option value="Startup" {{ $workExperience->respondent_affiliation == 'Startup' ? 'selected' : '' }}>Startup</option>
        <option value="Multinational Corporation (MNC)" {{ $workExperience->respondent_affiliation == 'Multinational Corporation (MNC)' ? 'selected' : '' }}>Multinational Corporation (MNC)</option>
        <option value="Small and Medium Enterprise (SME)" {{ $workExperience->respondent_affiliation == 'Small and Medium Enterprise (SME)' ? 'selected' : '' }}>Small and Medium Enterprise (SME)</option>
        <option value="Freelance" {{ $workExperience->respondent_affiliation == 'Freelance' ? 'selected' : '' }}>Freelance / Self-Employed</option>
        <option value="Partnership" {{ $workExperience->respondent_affiliation == 'Partnership' ? 'selected' : '' }}>Partnership</option>
        <option value="Cooperative" {{ $workExperience->respondent_affiliation == 'Cooperative' ? 'selected' : '' }}>Cooperative</option>
        <option value="Educational Institution" {{ $workExperience->respondent_affiliation == 'Educational Institution' ? 'selected' : '' }}>Educational Institution (School, University, etc.)</option>
        <option value="Healthcare" {{ $workExperience->respondent_affiliation == 'Healthcare' ? 'selected' : '' }}>Healthcare / Hospital</option>
        <option value="Financial Institution" {{ $workExperience->respondent_affiliation == 'Financial Institution' ? 'selected' : '' }}>Financial Institution (Bank, Insurance, etc.)</option>
        <option value="Manufacturing" {{ $workExperience->respondent_affiliation == 'Manufacturing' ? 'selected' : '' }}>Manufacturing Industry</option>
        <option value="Retail" {{ $workExperience->respondent_affiliation == 'Retail' ? 'selected' : '' }}>Retail / E-commerce</option>
        <option value="Technology" {{ $workExperience->respondent_affiliation == 'Technology' ? 'selected' : '' }}>Technology / IT Company</option>
        <option value="Construction" {{ $workExperience->respondent_affiliation == 'Construction' ? 'selected' : '' }}>Construction / Engineering</option>
        <option value="Hospitality" {{ $workExperience->respondent_affiliation == 'Hospitality' ? 'selected' : '' }}>Hospitality (Hotel, Restaurant, Tourism)</option>
        <option value="Real Estate" {{ $workExperience->respondent_affiliation == 'Real Estate' ? 'selected' : '' }}>Real Estate</option>
        <option value="Media" {{ $workExperience->respondent_affiliation == 'Media' ? 'selected' : '' }}>Media & Entertainment</option>
        <option value="Others" {{ $workExperience->respondent_affiliation == 'Others' ? 'selected' : '' }}>Others</option>
    </select>
</div>

        <button type="submit" class="btn btn-primary">Update Work Experience</button>
        <a href="{{ route('work_experiences.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
