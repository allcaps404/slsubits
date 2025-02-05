@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Edit User</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" id="username" value="{{ old('username', $user->username) }}" required>
        </div>

        <div class="form-group">
            <label for="password">Password (Leave blank to keep current password)</label>
            <input type="password" class="form-control" name="password" id="password">
        </div>

        <div class="form-group">
            <label for="role_id">Role</label>
            <select class="form-control" name="role_id" id="role_id" required>
                <option value="1" {{ old('role_id', $user->role_id) == 1 ? 'selected' : '' }}>Admin</option>
                <option value="2" {{ old('role_id', $user->role_id) == 2 ? 'selected' : '' }}>Student</option>
                <option value="3" {{ old('role_id', $user->role_id) == 3 ? 'selected' : '' }}>Scanner</option>
            </select>
        </div>

        <!-- Additional User Information -->
        <div class="form-group">
            <label for="course">Course</label>
            <input type="text" class="form-control" name="course" id="course" value="{{ old('course', $user->information->course ?? '') }}">
        </div>

        <div class="form-group">
            <label for="year">Year</label>
            <input type="text" class="form-control" name="year" id="year" value="{{ old('year', $user->information->year ?? '') }}">
        </div>

        <div class="form-group">
            <label for="section">Section</label>
            <input type="text" class="form-control" name="section" id="section" value="{{ old('section', $user->information->section ?? '') }}">
        </div>

        <div class="form-group">
            <label for="semester">Semester</label>
            <input type="text" class="form-control" name="semester" id="semester" value="{{ old('semester', $user->information->semester ?? '') }}">
        </div>

        <div class="form-group">
            <label for="academic_year">Academic Year</label>
            <input type="text" class="form-control" name="academic_year" id="academic_year" value="{{ old('academic_year', $user->information->academic_year ?? '') }}">
        </div>

        <div class="form-group">
            <label for="birthdate">Birthdate</label>
            <input type="date" class="form-control" name="birthdate" id="birthdate" value="{{ old('birthdate', $user->information->birthdate ?? '') }}">
        </div>

        <div class="form-group">
            <label for="birthplace">Birthplace</label>
            <input type="text" class="form-control" name="birthplace" id="birthplace" value="{{ old('birthplace', $user->information->birthplace ?? '') }}">
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <textarea class="form-control" name="address" id="address" rows="3">{{ old('address', $user->information->address ?? '') }}</textarea>
        </div>

        <div class="form-group">
            <label for="photo">Photo</label>
            <input type="file" class="form-control-file" name="photo" id="photo">
        </div>

        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>
@endsection
