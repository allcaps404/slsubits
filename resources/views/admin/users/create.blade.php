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
                                        <option value="1">Admin</option>
                                        <option value="2">Student</option>
                                        <option value="3">Scanner</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <h5 class="mt-4">Additional Information</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="course">Course</label>
                                    <input type="text" class="form-control" name="course" id="course" placeholder="Enter course">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="year">Year</label>
                                    <input type="text" class="form-control" name="year" id="year" placeholder="Enter year">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="section">Section</label>
                                    <input type="text" class="form-control" name="section" id="section" placeholder="Enter section">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="semester">Semester</label>
                                    <input type="text" class="form-control" name="semester" id="semester" placeholder="Enter semester">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="academic_year">Academic Year</label>
                                    <input type="text" class="form-control" name="academic_year" id="academic_year" placeholder="Enter academic year">
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

                        <div class="form-group mb-3">
                            <label for="photo">Upload Photo</label>
                            <input type="file" name="photo" id="photo" class="form-control" onchange="validateFile()">
                            <div id="error-message" style="color: red; display: none;"></div>
                        </div>
                       

                        <button type="submit" class="btn btn-primary btn-block" id="submitBtn">Create User</button>
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
        e.preventDefault(); // Prevent form submission until confirmed

        // Confirmation alert
        if (confirm('Are you sure you want to submit the form?')) {
            // Show loading spinner
            document.getElementById('loadingSpinner').style.display = 'block';
            
            // Submit the form after confirmation
            this.submit();
        }
    });

    // Optional: File validation (uncomment if file upload is enabled)
    function validateFile() {
        const fileInput = document.getElementById('photo');
        const file = fileInput.files[0];
        const errorMessage = document.getElementById('error-message');

        errorMessage.style.display = 'none';
        errorMessage.textContent = '';

        if (!file) {
            return;
        }

        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        if (!allowedTypes.includes(file.type)) {
            errorMessage.textContent = 'Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.';
            errorMessage.style.display = 'block';
            fileInput.value = ''; 
            return;
        }

        const maxSize = 2 * 1024 * 1024; 
        if (file.size > maxSize) {
            errorMessage.textContent = 'File size exceeds 2MB. Please upload a smaller file.';
            errorMessage.style.display = 'block';
            fileInput.value = ''; 
            return;
        }
    }
</script>
@endsection
