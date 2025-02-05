@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Edit User</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $user->email) }}" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input type="text" class="form-control" name="firstname" id="firstname" value="{{ old('firstname', $user->firstname) }}" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" class="form-control" name="lastname" id="lastname" value="{{ old('lastname', $user->lastname) }}" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="middlename">Middle Name</label>
                    <input type="text" class="form-control" name="middlename" id="middlename" value="{{ old('middlename', $user->middlename ?? '') }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="password">Password (Leave blank to keep current password)</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="role_id">Role</label>
                    <select class="form-control" name="role_id" id="role_id" required>
                        <option value="1" {{ old('role_id', $user->role_id) == 1 ? 'selected' : '' }}>Admin</option>
                        <option value="2" {{ old('role_id', $user->role_id) == 2 ? 'selected' : '' }}>Student</option>
                        <option value="3" {{ old('role_id', $user->role_id) == 3 ? 'selected' : '' }}>Scanner</option>
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
                    <input type="text" class="form-control" name="course" id="course" value="{{ old('course', $user->informations->course ?? '') }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="year">Year</label>
                    <input type="text" class="form-control" name="year" id="year" value="{{ old('year', $user->informations->year ?? '') }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="section">Section</label>
                    <input type="text" class="form-control" name="section" id="section" value="{{ old('section', $user->informations->section ?? '') }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="semester">Semester</label>
                    <input type="text" class="form-control" name="semester" id="semester" value="{{ old('semester', $user->informations->semester ?? '') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="academic_year">Academic Year</label>
                    <input type="text" class="form-control" name="academic_year" id="academic_year" value="{{ old('academic_year', $user->informations->academic_year ?? '') }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="birthdate">Birthdate</label>
                    <input type="date" class="form-control" name="birthdate" id="birthdate" value="{{ old('birthdate', $user->informations->birthdate ?? '') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="birthplace">Birthplace</label>
                    <input type="text" class="form-control" name="birthplace" id="birthplace" value="{{ old('birthplace', $user->informations->birthplace ?? '') }}">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <textarea class="form-control" name="address" id="address" rows="3">{{ old('address', $user->informations->address ?? '') }}</textarea>
        </div>

        <div class="form-group">
            <label for="photo">Photo</label>
            <input type="file" class="form-control-file" name="photo" id="photo">
            @if($user->informations && $user->informations->photo)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $user->informations->photo) }}" alt="Current Photo" class="img-thumbnail" width="150">
                    <p class="text-muted">Current photo</p>
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#email').on('blur', function() {
            let email = $(this).val();
            let userId = {{ $user->id }}; 
            $.ajax({
                url: "{{ route('check-email') }}",
                method: 'GET',
                data: {
                    email: email,
                    user_id: userId
                },
                success: function(response) {
                    if (response.exists) {
                        alert('This email is already in use. Please choose a different one.');
                    }
                }
            });
        });
    });
</script>

@endsection
