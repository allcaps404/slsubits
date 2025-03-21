@extends('layouts.alumni.index')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Profile Information</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @elseif(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                    <form id="profileForm" action="{{ route('alumni.profile.update') }}" method="POST" {{ $isProfileComplete ? 'onsubmit="return false;"' : '' }}>
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            @if(!auth()->user()->firstname)
                                <input type="text" name="firstname" value="{{ old('firstname', auth()->user()->firstname) }}" class="form-control" id="firstname">
                            @else
                                <input type="text" value="{{ old('firstname', auth()->user()->firstname) }}" class="form-control" id="firstname" disabled>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            @if(!auth()->user()->lastname)
                                <input type="text" name="lastname" value="{{ old('lastname', auth()->user()->lastname) }}" class="form-control" id="lastname">
                            @else
                                <input type="text" value="{{ old('lastname', auth()->user()->lastname) }}" class="form-control" id="lastname" disabled>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="middlename">Middle Name</label>
                            @if(!auth()->user()->middlename)
                                <input type="text" name="middlename" value="{{ old('middlename', auth()->user()->middlename) }}" class="form-control" id="middlename">
                            @else
                                <input type="text" value="{{ old('middlename', auth()->user()->middlename) }}" class="form-control" id="middlename" disabled>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="dateofbirth">Date of Birth</label>
                            @if(!auth()->user()->dateofbirth)
                                <input type="date" name="dateofbirth" value="{{ old('dateofbirth', auth()->user()->dateofbirth) }}" class="form-control" id="dateofbirth">
                            @else
                                <input type="date" value="{{ old('dateofbirth', auth()->user()->dateofbirth) }}" class="form-control" id="dateofbirth" disabled>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            @if(!auth()->user()->email)
                                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="form-control" id="email">
                            @else
                                <input type="email" value="{{ old('email', auth()->user()->email) }}" class="form-control" id="email" disabled>
                            @endif
                        </div>

                        <hr>

                        <h5 class="mt-4">Other Details</h5>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select class="form-control" name="gender" id="gender">
                                        <option value="" disabled {{ old('gender', optional($otherDetails)->gender) == '' ? 'selected' : '' }}>Select a Gender</option>
                                        <option value="Male" {{ old('gender', optional($otherDetails)->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('gender', optional($otherDetails)->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                        <option value="Other" {{ old('gender', optional($otherDetails)->gender) == 'Other' ? 'selected' : '' }}>LGBTQ+</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="course">Course</label>
                                    @if(!isset($otherDetails->course))
                                        <select name="course" class="form-control" id="course">
                                            <option value="">Select Course</option>
                                            <option value="BSIT" {{ old('course', optional($otherDetails)->course) == 'BSIT' ? 'selected' : '' }}>
                                                Bachelor of Science in Information Technology
                                            </option>
                                        </select>
                                    @else
                                        <select class="form-control" id="course" disabled>
                                            <option value="BSIT" {{ old('course', optional($otherDetails)->course) == 'BSIT' ? 'selected' : '' }}>
                                                Bachelor of Science in Information Technology
                                            </option>
                                        </select>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="academic_year">Academic Year</label>
                                    @if(!isset($otherDetails->academic_year))
                                        <select name="academic_year" class="form-control" id="academic_year">
                                            <option value="">Select Academic Year</option>
                                            @for ($year = date('Y'); $year >= 2000; $year--)
                                                @php $nextYear = $year + 1; @endphp
                                                <option value="{{ $year }}-{{ $nextYear }}" 
                                                    {{ old('academic_year', optional($otherDetails)->academic_year) == "$year-$nextYear" ? 'selected' : '' }}>
                                                    {{ $year }} - {{ $nextYear }}
                                                </option>
                                            @endfor
                                        </select>
                                    @else
                                        <select class="form-control" id="academic_year" disabled>
                                            <option value="">Select Academic Year</option>
                                            @for ($year = date('Y'); $year >= 2000; $year--)
                                                @php $nextYear = $year + 1; @endphp
                                                <option value="{{ $year }}-{{ $nextYear }}" 
                                                    {{ old('academic_year', optional($otherDetails)->academic_year) == "$year-$nextYear" ? 'selected' : '' }}>
                                                    {{ $year }} - {{ $nextYear }}
                                                </option>
                                            @endfor
                                        </select>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="birthplace">Birthplace</label>
                            @if(!isset($otherDetails->birthplace))
                                <input type="text" name="birthplace" value="{{ old('birthplace', optional($otherDetails)->birthplace) }}" class="form-control" id="birthplace">
                            @else
                                <input type="text" value="{{ old('birthplace', optional($otherDetails)->birthplace) }}" class="form-control" id="birthplace" disabled>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="address">Address</label>
                            @if(!isset($otherDetails->address))
                                <textarea name="address" class="form-control" id="address">{{ old('address', optional($otherDetails)->address) }}</textarea>
                            @else
                                <textarea class="form-control" id="address" disabled>{{ old('address', optional($otherDetails)->address) }}</textarea>
                            @endif
                        </div>


                        <div class="form-group">
                            <label for="photoUpload">Upload Photo</label>
                            <input type="file" id="photoUpload" class="form-control-file" accept="image/*">
                            <input type="hidden" name="photo" id="photoBase64"> 

                            @if(isset($otherDetails->photo) && !empty($otherDetails->photo))
                                <img id="previewImage" 
                                     src="data:image/jpeg;base64,{{ $otherDetails->photo }}" 
                                     class="mt-2 rounded thumbnail-preview" 
                                     style="display: block;">
                            @else
                                <img id="previewImage" class="mt-2 rounded thumbnail-preview" style="display: none;">
                            @endif
                        </div>

                        <div class="form-group text-center">
                            @if(!$isProfileComplete)
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const photoUploadInput = document.getElementById('photoUpload');
    const photoBase64Input = document.getElementById('photoBase64');
    const previewImage = document.getElementById('previewImage');

    photoUploadInput.addEventListener('change', function() {
    const file = this.files[0];
    const reader = new FileReader();
    reader.onloadend = function() {
        const base64String = reader.result; // This will include the "data:image/png;base64," part
        photoBase64Input.value = base64String; // Save the full Base64 string (with prefix)
        previewImage.style.display = 'block';
        previewImage.src = base64String; // Display the image preview
    };
    if (file) {
        reader.readAsDataURL(file); // Read file as Data URL (Base64)
    }
});
</script>

<style>
    .thumbnail-preview {
        width: 250px;
        height: 300px;
        object-fit: cover;
    }
</style>

@endsection
