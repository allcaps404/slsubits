@extends('layouts.scanner.index')

@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Left Side: QR Scanner -->
        <div class="col-md-6 text-center">
            <h4>Select Event</h4>
            <select id="event_id" class="form-control mb-3">
                @foreach($events as $event)
                    <option value="{{ $event->id }}">{{ $event->name }} - {{ $event->event_date }}</option>
                @endforeach
            </select>
            <h4>Scan QR Code</h4>
            <video id="preview" class="border rounded w-100"></video>

             <!-- Message Display Below the Scanner -->
            <div id="scan-message" class="alert mt-3 d-none"></div>
        </div>

        <!-- Right Side: Student Details -->
        <div class="col-md-6">
            <h4>Student Details</h4>
            <div class="card">
                <div class="card-body text-center">
                    <img id="student-photo" src="https://www.gravatar.com/avatar/?d=mp" class="img-fluid rounded-circle mb-3" width="150" height="150">
                    <h5 id="student-name">---</h5>
                    <p id="student-course">---</p>
                    <p id="student-year-section">---</p>
                    <p id="student-semester">---</p>
                    <p id="student-academic-year">---</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for QR Scanner -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });

    scanner.addListener('scan', function(qr_code) {
        let event_id = document.getElementById('event_id').value;
        fetchStudentDetails(qr_code, event_id);
    });

    Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
            scanner.start(cameras[0]);
        } else {
            alert('No cameras found.');
        }
    }).catch(function (e) {
        console.error(e);
    });

    function fetchStudentDetails(qr_code, event_id) {
        fetch(`scanner/get-student/${qr_code}?event_id=${event_id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById("student-photo").src = data.photo;
                    document.getElementById("student-name").textContent = data.name;
                    document.getElementById("student-course").textContent = "Course: " + data.course;
                    document.getElementById("student-year-section").textContent = "Year & Section: " + data.year + " - " + data.section;
                    document.getElementById("student-semester").textContent = "Semester: " + data.semester;
                    document.getElementById("student-academic-year").textContent = "Academic Year: " + data.academic_year;
                    showMessage(`✅ Successfully logged in: ${data.name}`, 'success');
                } else {
                    showMessage(`❌ ${data.message}`, 'danger');
                }
            })
            .catch(error => console.error('Error fetching student details:', error));
    }
    function showMessage(message, type) {
        let messageDiv = document.getElementById('scan-message');
        messageDiv.innerHTML = message;
        messageDiv.className = `alert alert-${type} mt-3`;
        messageDiv.classList.remove('d-none');

        // Hide the message after 5 seconds
        setTimeout(() => {
            messageDiv.classList.add('d-none');
        }, 5000);
    }
});
</script>
@endsection
