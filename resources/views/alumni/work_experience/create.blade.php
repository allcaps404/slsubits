@extends('layouts.alumni.index')

@section('content')
<div class="container mt-5 p-4">
    <!-- Title -->
    <div class="text-center mb-4">
        <h2>Add Work Experience</h2>
    </div>

    <!-- Work Experience Form -->
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('work_experiences.store') }}" method="POST">
                        @csrf

                        <!-- Job Position -->
                        <div class="mb-3">
                            <label for="position" class="form-label">Job Position</label>
                            <input type="text" name="position" id="position" class="form-control" required>
                        </div>

                        <!-- Company Name -->
                        <div class="mb-3">
                            <label for="company_name" class="form-label">Company Name</label>
                            <input type="text" name="company_name" id="company_name" class="form-control" required>
                        </div>

                        <!-- Contact Number -->
                        <div class="mb-3">
                            <label for="contact_number" class="form-label">Company Contact Number (Optional)</label>
                            <input type="text" name="contact_number" id="contact_number" class="form-control">
                        </div>

                        <!-- Start Date -->
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" required>
                        </div>

                        <!-- End Date -->
                        <div class="mb-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control">
                        </div>

                        <!-- Currently Working Checkbox -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="currently_working" id="currently_working" class="form-check-input">
                            <label for="currently_working" class="form-check-label">I am currently working here</label>
                        </div>

                        <!-- Job Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Job Description (Optional)</label>
                            <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                        </div>

                        <!-- Respondent Affiliation (Dropdown) -->
                        <div class="mb-3">
                            <label for="respondent_affiliation" class="form-label">Type of Organization</label>
                            <select name="respondent_affiliation" id="respondent_affiliation" class="form-control" required>
                                <option value="" selected disabled>Select Type of Organization</option>
                                <option value="Government">Government</option>
                                <option value="Non-Government">Non-Government</option>
                                <option value="Private Corporation">Private Corporation</option>
                                <option value="Public Corporation">Public Corporation</option>
                                <option value="Startup">Startup</option>
                                <option value="Multinational Corporation (MNC)">Multinational Corporation (MNC)</option>
                                <option value="Small and Medium Enterprise (SME)">Small and Medium Enterprise (SME)</option>
                                <option value="Freelance">Freelance / Self-Employed</option>
                                <option value="Partnership">Partnership</option>
                                <option value="Cooperative">Cooperative</option>
                                <option value="Educational Institution">Educational Institution (School, University, etc.)</option>
                                <option value="Healthcare">Healthcare / Hospital</option>
                                <option value="Financial Institution">Financial Institution (Bank, Insurance, etc.)</option>
                                <option value="Manufacturing">Manufacturing Industry</option>
                                <option value="Retail">Retail / E-commerce</option>
                                <option value="Technology">Technology / IT Company</option>
                                <option value="Construction">Construction / Engineering</option>
                                <option value="Hospitality">Hospitality (Hotel, Restaurant, Tourism)</option>
                                <option value="Real Estate">Real Estate</option>
                                <option value="Media">Media & Entertainment</option>
                            </select>
                        </div>
                                <div class="alert alert-info text-center" role="alert">
                        <strong>Disclaimer:</strong> The information provided in this form should be accurate and truthful. 
                Your data will be used solely for alumni records and career tracking. 
                We respect your privacy and will not share your details without your consent.
                                      </div>
                        <!-- Submit Button -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('work_experiences.index') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Save Experience</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
