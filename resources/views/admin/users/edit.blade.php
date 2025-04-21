@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit User</h1>

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
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $user->email) }}" required>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input type="text" class="form-control" name="firstname" id="firstname" value="{{ old('firstname', $user->firstname) }}" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" class="form-control" name="lastname" id="lastname" value="{{ old('lastname', $user->lastname) }}" required>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="middlename">Middle Name</label>
                    <input type="text" class="form-control" name="middlename" id="middlename" value="{{ old('middlename', $user->middlename ?? '') }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="password">Password (Leave blank to keep current password)</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="role_id">Role</label>
                    <select class="form-control" name="role_id" id="role_id" required>
                        <option value="" disabled>Select a role</option>
                        @php
                            $roles = \App\Models\Role::all();
                        @endphp
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" 
                                {{ old('role_id', $user->role_id ?? '') == $role->id ? 'selected' : '' }}>
                                {{ $role->role_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>
        <hr>
        <h5>Additional Information</h5>
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="form-group">
                    <label for="course">Course</label>
                    <select class="form-control" name="course" id="course">
                        <!-- <option value="" disabled selected>Select a role</option> -->
                        <option value="BSIT" {{ old('course', $user->OtherDetail->course ?? '') == 'BSIT' ? 'selected' : '' }}>Bachelor of Science in Information Technology</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="form-group">
                    <label for="year">Year</label>
                    <select class="form-control" name="year" id="year">
                        <option value="" disabled selected>Select a year</option>
                        <option value="1st" {{ old('year', $user->OtherDetail->year ?? '') == '1st Year' ? 'selected' : '' }}>1st Year</option>
                        <option value="2nd" {{ old('year', $user->OtherDetail->year ?? '') == '2nd Year' ? 'selected' : '' }}>2nd Year</option>
                        <option value="3rd" {{ old('year', $user->OtherDetail->year ?? '') == '3rd Year' ? 'selected' : '' }}>3rd Year</option>
                        <option value="4th" {{ old('year', $user->OtherDetail->year ?? '') == '4th Year' ? 'selected' : '' }}>4th Year</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="form-group">
                    <label for="section">Section</label>
                    <select class="form-control" name="section" id="section">
                        <option value="" disabled selected>Select a section</option>
                        <option value="A" {{ old('section', $user->OtherDetail->section ?? '') == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('section', $user->OtherDetail->section ?? '') == 'B' ? 'selected' : '' }}>B</option>
                        <option value="C" {{ old('section', $user->OtherDetail->section ?? '') == 'C' ? 'selected' : '' }}>C</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="form-group">
                    <label for="section">Gender</label>
                    <select class="form-control" name="gender" id="gender">
                        <option value="" disabled selected>Select a gender</option>
                        <option value="Male" {{ old('gender', $user->OtherDetail->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender', $user->OtherDetail->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="LGBTQ+" {{ old('gender', $user->OtherDetail->gender ?? '') == 'LGBTQ+' ? 'selected' : ''}}>LGBTQ+</option>  
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="semester">Semester</label>
                    <select class="form-control" name="semester" id="semester">
                        <option value="" disabled selected>Select a semester</option>
                        <option value="1st Semester" {{ old('semester', $user->OtherDetail->semester ?? '') == '1st Semester' ? 'selected' : '' }}>1st Semester</option>
                        <option value="2nd Semester" {{ old('semester', $user->OtherDetail->semester ?? '') == '2nd Semester' ? 'selected' : '' }}>2nd Semester</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="academic_year">Academic Year</label>
                    <select class="form-control" name="academic_year" id="academic_year">
                        @for($year = 2020; $year <= 2027; $year++)
                            <option value="" disabled selected>Select a academic year</option>
                            <option value="{{ $year }}-{{ $year + 1 }}" {{ old('academic_year', $user->OtherDetail->academic_year ?? '') == "$year-$year+1" ? 'selected' : '' }}>
                                {{ $year }}-{{ $year + 1 }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="dateofbirth">Birthdate</label>
                    <input type="date" class="form-control" name="dateofbirth" id="dateofbirth" value="{{ old('dateofbirth', optional($user)->dateofbirth ? \Carbon\Carbon::parse($user->dateofbirth)->format('Y-m-d') : '') }}">
                </div>
            </div>
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

        <div class="form-group">
            <label for="photo">Photo</label>
            <input type="file" class="form-control-file" id="photo" name="photo" accept="image/*" onchange="previewPhoto(this)">

            @if(isset($user->OtherDetail->photo) && !empty($user->OtherDetail->photo))
                <img id="previewImage" 
                    src="data:image/jpeg;base64, {{ $user->OtherDetail->photo }}" 
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
        <button type="submit" class="btn btn-primary">Update User</button>
        <a href="{{ route('usersmanagement.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
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
