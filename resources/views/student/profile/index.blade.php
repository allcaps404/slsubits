@extends('layouts.student.index')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">Profile Information</h2>
    
    <form id="profileForm" action="{{ route('student.profile.update') }}" method="POST" {{ $isProfileComplete ? 'onsubmit="return false;"' : '' }}>
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700">First Name</label>
            @if(!auth()->user()->firstname)
                <input type="text" name="firstname" value="{{ old('firstname', auth()->user()->firstname) }}" class="w-full p-2 border rounded">
            @else
                <input type="text" value="{{ old('firstname', auth()->user()->firstname) }}" class="w-full p-2 border rounded" disabled>
            @endif
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Last Name</label>
            @if(!auth()->user()->lastname)
                <input type="text" name="lastname" value="{{ old('lastname', auth()->user()->lastname) }}" class="w-full p-2 border rounded">
            @else
                <input type="text" value="{{ old('lastname', auth()->user()->lastname) }}" class="w-full p-2 border rounded" disabled>
            @endif
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Middle Name</label>
            @if(!auth()->user()->middlename)
                <input type="text" name="middlename" value="{{ old('middlename', auth()->user()->middlename) }}" class="w-full p-2 border rounded">
            @else
                <input type="text" value="{{ old('middlename', auth()->user()->middlename) }}" class="w-full p-2 border rounded" disabled>
            @endif
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Date of Birth</label>
            @if(!auth()->user()->dateofbirth)
                <input type="date" name="dateofbirth" value="{{ old('dateofbirth', auth()->user()->dateofbirth) }}" class="w-full p-2 border rounded">
            @else
                <input type="date" value="{{ old('dateofbirth', auth()->user()->dateofbirth) }}" class="w-full p-2 border rounded" disabled>
            @endif
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Email</label>
            @if(!auth()->user()->email)
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full p-2 border rounded">
            @else
                <input type="email" value="{{ old('email', auth()->user()->email) }}" class="w-full p-2 border rounded" disabled>
            @endif
        </div>

        <h3 class="text-xl font-semibold mt-6 mb-4">Other Details</h3>
        <div class="mb-4">
            <label class="block text-gray-700">ID Number</label>
            @if(!isset($otherDetails->idnumber))
                <input type="text" name="idnumber" value="{{ old('idnumber', optional($otherDetails)->idnumber) }}" class="w-full p-2 border rounded">
            @else
                <input type="text" value="{{ old('idnumber', optional($otherDetails)->idnumber) }}" class="w-full p-2 border rounded" disabled>
            @endif
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Course</label>
            @if(!isset($otherDetails->course))
                <select name="course" class="w-full p-2 border rounded">
                    <option value="">Select Course</option>
                    <option value="BSIT" {{ old('course', optional($otherDetails)->course) == 'BSIT' ? 'selected' : '' }}>
                        Bachelor of Science in Information Technology
                    </option>
                </select>
            @else
                <select class="w-full p-2 border rounded" disabled>
                    <option value="">Select Course</option>
                    <option value="BSIT" {{ old('course', optional($otherDetails)->course) == 'BSIT' ? 'selected' : '' }}>
                        Bachelor of Science in Information Technology
                    </option>
                </select>
            @endif
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Year</label>
            @if(!isset($otherDetails->year))
                <select name="year" class="w-full p-2 border rounded">
                    <option value="">Select Year</option>
                    <option value="1st" {{ old('year', optional($otherDetails)->year) == '1st' ? 'selected' : '' }}>1st Year</option>
                    <option value="2nd" {{ old('year', optional($otherDetails)->year) == '2nd' ? 'selected' : '' }}>2nd Year</option>
                    <option value="3rd" {{ old('year', optional($otherDetails)->year) == '3rd' ? 'selected' : '' }}>3rd Year</option>
                    <option value="4th" {{ old('year', optional($otherDetails)->year) == '4th' ? 'selected' : '' }}>4th Year</option>
                </select>
            @else
                <select class="w-full p-2 border rounded" disabled>
                    <option value="">Select Year</option>
                    <option value="1st" {{ old('year', optional($otherDetails)->year) == '1st' ? 'selected' : '' }}>1st Year</option>
                    <option value="2nd" {{ old('year', optional($otherDetails)->year) == '2nd' ? 'selected' : '' }}>2nd Year</option>
                    <option value="3rd" {{ old('year', optional($otherDetails)->year) == '3rd' ? 'selected' : '' }}>3rd Year</option>
                    <option value="4th" {{ old('year', optional($otherDetails)->year) == '4th' ? 'selected' : '' }}>4th Year</option>
                </select>
            @endif
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Section</label>
            @if(!isset($otherDetails->section))
                <select name="section" class="w-full p-2 border rounded">
                    <option value="">Select Section</option>
                    <option value="A" {{ old('section', optional($otherDetails)->section) == 'A' ? 'selected' : '' }}>Section A</option>
                    <option value="B" {{ old('section', optional($otherDetails)->section) == 'B' ? 'selected' : '' }}>Section B</option>
                    <option value="C" {{ old('section', optional($otherDetails)->section) == 'C' ? 'selected' : '' }}>Section C</option>
                    <option value="D" {{ old('section', optional($otherDetails)->section) == 'D' ? 'selected' : '' }}>Section D</option>
                </select>
            @else
                <select class="w-full p-2 border rounded" disabled>
                    <option value="">Select Section</option>
                    <option value="A" {{ old('section', optional($otherDetails)->section) == 'A' ? 'selected' : '' }}>Section A</option>
                    <option value="B" {{ old('section', optional($otherDetails)->section) == 'B' ? 'selected' : '' }}>Section B</option>
                    <option value="C" {{ old('section', optional($otherDetails)->section) == 'C' ? 'selected' : '' }}>Section C</option>
                    <option value="D" {{ old('section', optional($otherDetails)->section) == 'D' ? 'selected' : '' }}>Section D</option>
                </select>
            @endif
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Semester</label>
            @if(!isset($otherDetails->semester))
                <select name="semester" class="w-full p-2 border rounded">
                    <option value="">Select Semester</option>
                    <option value="1st" {{ old('semester', optional($otherDetails)->semester) == '1st' ? 'selected' : '' }}>1st Semester</option>
                    <option value="2nd" {{ old('semester', optional($otherDetails)->semester) == '2nd' ? 'selected' : '' }}>2nd Semester</option>
                    <option value="Summer" {{ old('semester', optional($otherDetails)->semester) == 'Summer' ? 'selected' : '' }}>Summer</option>
                </select>
            @else
                <select class="w-full p-2 border rounded" disabled>
                    <option value="">Select Semester</option>
                    <option value="1st" {{ old('semester', optional($otherDetails)->semester) == '1st' ? 'selected' : '' }}>1st Semester</option>
                    <option value="2nd" {{ old('semester', optional($otherDetails)->semester) == '2nd' ? 'selected' : '' }}>2nd Semester</option>
                    <option value="Summer" {{ old('semester', optional($otherDetails)->semester) == 'Summer' ? 'selected' : '' }}>Summer</option>
                </select>
            @endif
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Academic Year</label>
            @if(!isset($otherDetails->academic_year))
                <select name="academic_year" class="w-full p-2 border rounded">
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
                <select class="w-full p-2 border rounded" disabled>
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

        <div class="mb-4">
            <label class="block text-gray-700">Birthplace</label>
            @if(!isset($otherDetails->birthplace))
                <input type="text" name="birthplace" value="{{ old('birthplace', optional($otherDetails)->birthplace) }}" class="w-full p-2 border rounded">
            @else
                <input type="text" value="{{ old('birthplace', optional($otherDetails)->birthplace) }}" class="w-full p-2 border rounded" disabled>
            @endif
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Address</label>
            @if(!isset($otherDetails->address))
                <textarea name="address" class="w-full p-2 border rounded">{{ old('address', optional($otherDetails)->address) }}</textarea>
            @else
                <textarea class="w-full p-2 border rounded" disabled>{{ old('address', optional($otherDetails)->address) }}</textarea>
            @endif
        </div>
        
      <div class="mb-4">
            <label class="block text-gray-700">Upload Photo</label>
            <input type="file" id="photoUpload" class="w-full p-2 border rounded" accept="image/*">
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
        <div class="mt-6">
            @if(!$isProfileComplete)
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save Changes </button>
            @else
                <button class="bg-blue-600 text-white px-4 py-2 rounded" disabled>Save Changes </button>
            @endif
        </div>
    </form>
</div>
<script>
    document.getElementById('profileForm').addEventListener('submit', function(event) {
        event.preventDefault();

        Swal.fire({
            title: "Are you sure?",
            text: "Do you really want to proceed with updating your profile?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, update it!"
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit(); // Submit the form if confirmed
            }
        });
    });
    document.getElementById('photoUpload').addEventListener('change', function(event) {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function() {
                const base64String = reader.result.split(',')[1]; // Extract Base64 data
                document.getElementById('photoBase64').value = base64String;
                document.getElementById('previewImage').src = reader.result;
                document.getElementById('previewImage').style.display = 'block';
            };
        }
    });
</script>
@endsection