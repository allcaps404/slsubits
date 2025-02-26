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
                    <h3>Create New User</h3>
                </div>
                <div class="card-body">
                    <form id="userForm" method="POST" action="{{ route('usersmanagement.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="firstname">First Name</label>
                                    <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Enter first name" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="lastname">Last Name</label>
                                    <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Enter last name" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="middlename">Middle Name</label>
                                    <input type="text" class="form-control" name="middlename" id="middlename" placeholder="Enter middle name">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="role_id">Role</label>
                                    <select class="form-control" name="role_id" id="role_id" required>
                                        <option value="" disabled selected>Select role</option>
                                        <option value="1">Admin</option>
                                        <option value="2">Student</option>
                                        <option value="3">Scanner</option>
                                        <option value="4">Event Organizer</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <h5 class="mt-4">Additional Information</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="course">Course</label>
                                    <select class="form-control" name="course" id="course">
                                        <!-- <option value="" disabled selected>Select a course</option> -->
                                        <option value="BSIT">Bachelor of Science in Information Technology</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="year">Year</label>
                                    <select class="form-control" name="year" id="year">
                                        <option value="" disabled selected>Select year level</option>
                                        <option value="1st Year">1st Year</option>
                                        <option value="2nd Year">2nd Year</option>
                                        <option value="3rd Year">3rd Year</option>
                                        <option value="4th Year">4th Year</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="section">Section</label>
                                    <select class="form-control" name="section" id="section">
                                        <option value="" disabled selected>Select section</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="semester">Semester</label>
                                    <select class="form-control" name="semester" id="semester">
                                        <option value="" disabled selected>Select semester</option>
                                        <option value="1st Semester">1st Semester</option>
                                        <option value="2nd Semester">2nd Semester</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="academic_year">Academic Year</label>
                                    <select class="form-control" name="academic_year" id="academic_year">
                                        <option value="" disabled selected>Select academic year</option>
                                        @for($year = 2021; $year <= 2030; $year++)
                                            <option value="{{ $year }}-{{ $year + 1 }}">{{ $year }}-{{ $year + 1 }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="dateofbirth">Birthdate</label>
                                    <input type="date" class="form-control" name="dateofbirth" id="dateofbirth">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="birthplace">Birthplace</label>
                                    <input type="text" class="form-control" name="birthplace" id="birthplace" placeholder="Enter birthplace">
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="address">Address</label>
                            <textarea class="form-control" name="address" id="address" rows="3" placeholder="Enter address"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="photo">Photo</label>
                            <input type="file" class="form-control-file" id="photo" name="photo" accept="image/*" onchange="previewPhoto(this)">

                            @if(isset($user->OtherDetail->photo) && !empty($user->OtherDetail->photo))
                                <img id="previewImage" 
                                    src="{{ $user->OtherDetail->photo }}" 
                                    alt="User photo" 
                                    class="rounded-full mt-3" 
                                    style="max-width: 150px; max-height: 150px; width: auto; height: auto;">
                            @else
                                <img id="previewImage" 
                                    src="https://www.gravatar.com/avatar/?d=mp" 
                                    alt="Default profile picture" 
                                    class="rounded-full mt-3" 
                                    style="max-width: 150px; max-height: 150px; width: auto; height: auto;">
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm" id="submitBtn">Create User</button>
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
    document.getElementById('userForm').addEventListener('submit', function (e) {
        e.preventDefault();
        if (confirm('Are you sure you want to submit the form?')) {
            document.getElementById('loadingSpinner').style.display = 'block';
            this.submit();
        }
    });

    function previewPhoto(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('previewImage').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
