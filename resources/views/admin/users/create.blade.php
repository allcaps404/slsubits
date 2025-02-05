@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Create New User</h1>

    <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input type="text" class="form-control" name="firstname" id="firstname" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" class="form-control" name="lastname" id="lastname" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="middlename">Middle Name</label>
                    <input type="text" class="form-control" name="middlename" id="middlename">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>
            </div>
            <div class="col-md-6">
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

        <hr>

        <h5>Additional Information</h5>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="course">Course</label>
                    <input type="text" class="form-control" name="course" id="course">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="year">Year</label>
                    <input type="text" class="form-control" name="year" id="year">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="section">Section</label>
                    <input type="text" class="form-control" name="section" id="section">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="semester">Semester</label>
                    <input type="text" class="form-control" name="semester" id="semester">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="academic_year">Academic Year</label>
                    <input type="text" class="form-control" name="academic_year" id="academic_year">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="birthdate">Birthdate</label>
                    <input type="date" class="form-control" name="dateofbirth" id="dateofbirth">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="birthplace">Birthplace</label>
                    <input type="text" class="form-control" name="birthplace" id="birthplace">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <textarea class="form-control" name="address" id="address" rows="3"></textarea>
        </div>

        <!-- <div class="form-group">
            <label for="photo">Upload Photo</label>
            <input type="file" name="photo" id="photo" onchange="validateFile()">
            <div id="error-message" style="color: red; display: none;"></div>
        </div> -->

        <button type="submit" class="btn btn-primary">Create User</button>
    </form>
</div>

<script>
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
