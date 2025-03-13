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

                        <div class="form-group">
                            <label for="idnumber">ID Number</label>
                            @if(!isset($otherDetails->idnumber))
                                <input type="text" name="idnumber" value="{{ old('idnumber', optional($otherDetails)->idnumber) }}" class="form-control" id="idnumber">
                            @else
                                <input type="text" value="{{ old('idnumber', optional($otherDetails)->idnumber) }}" class="form-control" id="idnumber" disabled>
                            @endif
                        </div>

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

                        <!-- <div class="form-group">
                            <label for="year">Year</label>
                            @if(!isset($otherDetails->year))
                                <select name="year" class="form-control" id="year">
                                    <option value="">Select Year</option>
                                    <option value="1st" {{ old('year', optional($otherDetails)->year) == '1st' ? 'selected' : '' }}>1st Year</option>
                                    <option value="2nd" {{ old('year', optional($otherDetails)->year) == '2nd' ? 'selected' : '' }}>2nd Year</option>
                                    <option value="3rd" {{ old('year', optional($otherDetails)->year) == '3rd' ? 'selected' : '' }}>3rd Year</option>
                                    <option value="4th" {{ old('year', optional($otherDetails)->year) == '4th' ? 'selected' : '' }}>4th Year</option>
                                </select>
                            @else
                                <select class="form-control" id="year" disabled>
                                    <option value="1st" {{ old('year', optional($otherDetails)->year) == '1st' ? 'selected' : '' }}>1st Year</option>
                                    <option value="2nd" {{ old('year', optional($otherDetails)->year) == '2nd' ? 'selected' : '' }}>2nd Year</option>
                                    <option value="3rd" {{ old('year', optional($otherDetails)->year) == '3rd' ? 'selected' : '' }}>3rd Year</option>
                                    <option value="4th" {{ old('year', optional($otherDetails)->year) == '4th' ? 'selected' : '' }}>4th Year</option>
                                </select>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="section">Section</label>
                            @if(!isset($otherDetails->section))
                                <select name="section" class="form-control" id="section">
                                    <option value="">Select Section</option>
                                    <option value="A" {{ old('section', optional($otherDetails)->section) == 'A' ? 'selected' : '' }}>Section A</option>
                                    <option value="B" {{ old('section', optional($otherDetails)->section) == 'B' ? 'selected' : '' }}>Section B</option>
                                    <option value="C" {{ old('section', optional($otherDetails)->section) == 'C' ? 'selected' : '' }}>Section C</option>
                                    <option value="D" {{ old('section', optional($otherDetails)->section) == 'D' ? 'selected' : '' }}>Section D</option>
                                </select>
                            @else
                                <select class="form-control" id="section" disabled>
                                    <option value="A" {{ old('section', optional($otherDetails)->section) == 'A' ? 'selected' : '' }}>Section A</option>
                                    <option value="B" {{ old('section', optional($otherDetails)->section) == 'B' ? 'selected' : '' }}>Section B</option>
                                    <option value="C" {{ old('section', optional($otherDetails)->section) == 'C' ? 'selected' : '' }}>Section C</option>
                                    <option value="D" {{ old('section', optional($otherDetails)->section) == 'D' ? 'selected' : '' }}>Section D</option>
                                </select>
                            @endif
                        </div> -->

                        <!-- <div class="form-group">
                            <label for="semester">Semester</label>
                            @if(!isset($otherDetails->semester))
                                <select name="semester" class="form-control" id="semester">
                                    <option value="">Select Semester</option>
                                    <option value="1st" {{ old('semester', optional($otherDetails)->semester) == '1st' ? 'selected' : '' }}>1st Semester</option>
                                    <option value="2nd" {{ old('semester', optional($otherDetails)->semester) == '2nd' ? 'selected' : '' }}>2nd Semester</option>
                                    <option value="Summer" {{ old('semester', optional($otherDetails)->semester) == 'Summer' ? 'selected' : '' }}>Summer</option>
                                </select>
                            @else
                                <select class="form-control" id="semester" disabled>
                                    <option value="1st" {{ old('semester', optional($otherDetails)->semester) == '1st' ? 'selected' : '' }}>1st Semester</option>
                                    <option value="2nd" {{ old('semester', optional($otherDetails)->semester) == '2nd' ? 'selected' : '' }}>2nd Semester</option>
                                    <option value="Summer" {{ old('semester', optional($otherDetails)->semester) == 'Summer' ? 'selected' : '' }}>Summer</option>
                                </select>
                            @endif
                        </div> -->

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
                                     class="mt-2 max-w-xs rounded" 
                                     style="display: block;">
                            @else
                                <img id="previewImage" class="mt-2 max-w-xs rounded" style="display: none;">
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
            const base64String = reader.result.split(',')[1]; // Extract base64 part
            photoBase64Input.value = base64String;
            previewImage.style.display = 'block';
            previewImage.src = reader.result; // Display the image
        };
        if (file) {
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
