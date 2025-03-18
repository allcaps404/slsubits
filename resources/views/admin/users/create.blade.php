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
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" value="{{ old('email') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="firstname">First Name</label>
                                    <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Enter first name" value="{{ old('firstname') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="lastname">Last Name</label>
                                    <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Enter last name" value="{{ old('lastname') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="middlename">Middle Name</label>
                                    <input type="text" class="form-control" name="middlename" id="middlename" placeholder="Enter middle name" value="{{ old('middlename') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <div class="input-group">
                                        <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}" required>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                                                <i id="toggleIcon" class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="role_id">Role</label>
                                    <select class="form-control" name="role_id" id="role_id" required>
                                        <option value="" disabled {{ old('role_id') == '' ? 'selected' : '' }}>Select a role</option>
                                        @php
                                            $roles = \App\Models\Role::all();
                                        @endphp
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->role_name }}</option>
                                        @endforeach
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
                                        <option value="" disabled {{ old('course') == '' ? 'selected' : '' }}>Select a Course</option>
                                        <option value="BSIT" {{ old('course') == 'BSIT' ? 'selected' : '' }}>Bachelor of Science in Information Technology</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="year">Year</label>
                                    <select class="form-control" name="year" id="year">
                                        <option value="" disabled {{ old('year') == '' ? 'selected' : '' }}>Select a Year Level</option>
                                        <option value="1st Year" {{ old('year') == '1st Year' ? 'selected' : '' }}>1st Year</option>
                                        <option value="2nd Year" {{ old('year') == '2nd Year' ? 'selected' : '' }}>2nd Year</option>
                                        <option value="3rd Year" {{ old('year') == '3rd Year' ? 'selected' : '' }}>3rd Year</option>
                                        <option value="4th Year" {{ old('year') == '4th Year' ? 'selected' : '' }}>4th Year</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="section">Section</label>
                                    <select class="form-control" name="section" id="section">
                                        <option value="" disabled {{ old('section') == '' ? 'selected' : '' }}>Select a Section</option>
                                        <option value="A" {{ old('section') == 'A' ? 'selected' : '' }}>A</option>
                                        <option value="B" {{ old('section') == 'B' ? 'selected' : '' }}>B</option>
                                        <option value="C" {{ old('section') == 'C' ? 'selected' : '' }}>C</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="semester">Semester</label>
                                    <select class="form-control" name="semester" id="semester">
                                        <option value="" disabled {{ old('semester') == '' ? 'selected' : '' }}>Select a Semester</option>
                                        <option value="1st Semester" {{ old('semester') == '1st Semester' ? 'selected' : '' }}>1st Semester</option>
                                        <option value="2nd Semester" {{ old('semester') == '2nd Semester' ? 'selected' : '' }}>2nd Semester</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="academic_year">Academic Year</label>
                                    <select class="form-control" name="academic_year" id="academic_year">
                                        <option value="" disabled {{ old('academic_year') == '' ? 'selected' : '' }}>Select academic year</option>
                                        @for($year = 2021; $year <= 2030; $year++)
                                            <option value="{{ $year }}-{{ $year + 1 }}" {{ old('academic_year') == $year . '-' . ($year + 1) ? 'selected' : '' }}>{{ $year }}-{{ $year + 1 }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="dateofbirth">Birthdate</label>
                                    <input type="date" class="form-control" name="dateofbirth" id="dateofbirth" value="{{ old('dateofbirth') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="birthplace">Birthplace</label>
                                    <input type="text" class="form-control" name="birthplace" id="birthplace" placeholder="Enter birthplace" value="{{ old('birthplace') }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="address">Address</label>
                            <textarea class="form-control" name="address" id="address" rows="3" placeholder="Enter address">{{ old('address') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="photo">Photo</label>
                            <input type="file" class="form-control-file" id="photo" name="photo" accept="image/*" onchange="previewPhoto(this)">
                            <img id="previewImage" 
                                src="https://www.gravatar.com/avatar/?d=mp" 
                                alt="Default profile picture" 
                                class="rounded-full mt-3" 
                                style="max-width: 150px; max-height: 150px; width: auto; height: auto;">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm" id="submitBtn">Create User</button>
                        <a href="{{ route('usersmanagement.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewPhoto(input) {
        const preview = document.getElementById('previewImage');
        const file = input.files[0];
        const reader = new FileReader();

        reader.onloadend = function () {
            preview.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "https://www.gravatar.com/avatar/?d=mp";
        }
    }
</script>
@endsection
