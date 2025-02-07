@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit User</h1>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <form action="{{ route('usersmanagement.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Email Field -->
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $user->email) }}" required>
                </div>
            </div>

            <!-- First Name Field -->
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input type="text" class="form-control" name="firstname" id="firstname" value="{{ old('firstname', $user->firstname) }}" required>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Last Name Field -->
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" class="form-control" name="lastname" id="lastname" value="{{ old('lastname', $user->lastname) }}" required>
                </div>
            </div>

            <!-- Middle Name Field -->
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="middlename">Middle Name</label>
                    <input type="text" class="form-control" name="middlename" id="middlename" value="{{ old('middlename', $user->middlename ?? '') }}">
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Password Field -->
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="password">Password (Leave blank to keep current password)</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
            </div>

            <!-- Role Field -->
            <div class="col-md-6 mb-3">
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
            <!-- Course Field -->
            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <label for="course">Course</label>
                    <input type="text" class="form-control" name="course" id="course" value="{{ old('course', $user->OtherDetail->course ?? '') }}">
                </div>
            </div>

            <!-- Year Field -->
            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <label for="year">Year</label>
                    <input type="text" class="form-control" name="year" id="year" value="{{ old('year', $user->OtherDetail->year ?? '') }}">
                </div>
            </div>

            <!-- Section Field -->
            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <label for="section">Section</label>
                    <input type="text" class="form-control" name="section" id="section" value="{{ old('section', $user->OtherDetail->section ?? '') }}">
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Semester Field -->
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="semester">Semester</label>
                    <input type="text" class="form-control" name="semester" id="semester" value="{{ old('semester', $user->OtherDetail->semester ?? '') }}">
                </div>
            </div>

            <!-- Academic Year Field -->
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="academic_year">Academic Year</label>
                    <input type="text" class="form-control" name="academic_year" id="academic_year" value="{{ old('academic_year', $user->OtherDetail->academic_year ?? '') }}">
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Birthdate Field -->
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="dateofbirth">Birthdate</label>
                    <input type="date" class="form-control" name="dateofbirth" id="dateofbirth" value="{{ old('dateofbirth', optional($user)->dateofbirth ? \Carbon\Carbon::parse($user->dateofbirth)->format('Y-m-d') : '') }}">
                </div>
            </div>

            <!-- Birthplace Field -->
            <div class="col-md-6 mb-3">
                <div class="form-group">    
                    <label for="birthplace">Birthplace</label>
                    <input type="text" class="form-control" name="birthplace" id="birthplace" value="{{ old('birthplace', $user->OtherDetail->birthplace ?? '') }}">
                </div>
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="address">Address</label>
            <textarea class="form-control" name="address" id="address" rows="3">{{ old('address', $user->OtherDetail->address ?? '') }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label for="photo">Photo</label>
            <input type="file" class="form-control-file" name="photo" id="photo">
            @if($user->OtherDetail && $user->OtherDetail->photo)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $user->OtherDetail->photo) }}" alt="Current Photo" class="img-thumbnail" width="150">
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
