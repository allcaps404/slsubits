@extends('layouts.student.index')

@section('content') 
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <!-- Profile Card -->
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div class="flex items-center space-x-4"> 
            @if(isset($otherdetails->photo) && !empty($otherdetails->photo))
                <img alt="Profile picture of the user" 
                     class="w-24 h-24 rounded-full" 
                     height="100" 
                     src="data:image/jpeg;base64,{{ $otherdetails->photo }}" 
                     width="100" />
            @else
                <img id="previewImage" 
                     src="https://www.gravatar.com/avatar/?d=mp" 
                     class="w-24 h-24 rounded-full">
            @endif
            <div>
                <h2 class="text-xl font-bold"> Hello, {{ Auth::user()->firstname }}! </h2>
                <p class="text-gray-600">
                    <i class="fas fa-id-card"></i> ID Number: {{ $otherdetails->idnumber ?? 'Not available' }}
                </p>
                <p class="text-gray-600">
                    <i class="fas fa-book"></i> Course: {{ $otherdetails->course ?? 'No course available' }}
                </p>
            </div>
        </div>

        <div class="mt-4">
            <h3 class="text-lg font-semibold"> Basic Information </h3>
            <p class="text-gray-600">
                <i class="fas fa-user"></i> Full Name: {{ Auth::user()->firstname }} {{ Auth::user()->middlename ?? '' }} {{ Auth::user()->lastname }}
            </p>
            <p class="text-gray-600">
                <i class="fas fa-envelope"></i> Email: {{ Auth::user()->email ?? 'Email not available' }}
            </p>
            <p class="text-gray-600">
                <i class="fas fa-calendar"></i> Birthdate: {{ Auth::user()->dateofbirth ?? 'Not provided' }}
            </p>
            <p class="text-gray-600">
                <i class="fas fa-map-marker-alt"></i> Birthplace: {{ $otherdetails->birthplace ?? 'Not specified' }}
            </p>
            <p class="text-gray-600">
                <i class="fas fa-home"></i> Address: {{ $otherdetails->address ?? 'Not provided' }}
            </p>
        </div>

        <div class="mt-4">
            <h3 class="text-lg font-semibold"> Academic Information </h3>
            <p class="text-gray-600">
                <i class="fas fa-graduation-cap"></i> Year: {{ $otherdetails->year ?? 'N/A' }}
            </p>
            <p class="text-gray-600">
                <i class="fas fa-users"></i> Section: {{ $otherdetails->section ?? 'Not specified' }}
            </p>
            <p class="text-gray-600">
                <i class="fas fa-university"></i> Academic Year: {{ $otherdetails->academic_year ?? 'Unknown' }}
            </p>
            <p class="text-gray-600">
                <i class="fas fa-clock"></i> Semester: {{ $otherdetails->semester ?? 'Unknown' }} Semester
            </p>
        </div>
    </div>

    <!-- QR Code Display -->
    <div class="bg-white p-6 rounded-lg shadow-lg text-center">
        <h3 class="text-lg font-semibold"> 🎟️ Your QR Code </h3>
        @if(Auth::user()->qr_code)
            <img id="qrCode" 
                 src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ Auth::user()->qr_code }}" 
                 alt="QR Code"
                 class="mx-auto my-3">
           <!--  <a id="downloadQR" 
               href="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ Auth::user()->qr_code }}" 
               download="QR_Code.png"
               class="px-4 py-2 bg-blue-500 text-white rounded shadow hover:bg-blue-600">
                📥 Download QR
            </a> -->
        @else
            <p class="text-gray-600 mt-2">QR Code not generated yet.</p>
        @endif
    </div>

    <!-- Announcements -->
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-semibold mb-4"> 📢 Announcements </h3>
        @if($announcements->isEmpty())
            <p class="text-gray-600"> No announcements at the moment. </p>
        @else
            <ul class="space-y-2">
                @foreach($announcements as $announcement)
                    <li class="border-b pb-2">
                        <strong>{{ $announcement->title }}</strong>
                        <p class="text-gray-600 text-sm">{{ $announcement->content }}</p>
                        <p class="text-xs text-gray-500">📅 {{ $announcement->date }}</p>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection
