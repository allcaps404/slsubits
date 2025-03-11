@extends('layouts.scanner.index')

@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Left Side: QR Scanner -->
        <div class="col-md-6 text-center">
            <h4>Scan QR Coddde</h4>
            <video id="preview" class="border rounded w-100"></video>
        </div>

        <!-- Right Side: Student Details -->
        <div class="col-md-6">
            <h4>Student Details</h4>
            <div class="card">
                <div class="card-body text-center">
                    <img id="student-photo" src="{{ asset('images/default.png') }}" class="img-fluid rounded-circle mb-3" width="150" height="150">
                    <h5 id="student-name">---</h5>
                    <p id="student-course">---</p>
                    <p id="student-year-section">---</p>
                    <p id="student-semester">---</p>
                    <p id="student-academic-year">---</p>
                    <button id="download-btn" class="btn btn-primary mt-3">Download QR Code with Margin</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for QR Scanner and QR Code Download -->
<script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });

        scanner.addListener('scan', function(qr_code) {
            fetchStudentDetails(qr_code);
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

        function fetchStudentDetails(qr_code) {
            // Check if data is cached and if it is still valid
            let cachedData = localStorage.getItem(qr_code);
            let cacheTimestamp = localStorage.getItem(`${qr_code}-timestamp`);
            const cacheDuration = 10 * 60 * 1000; // Cache duration: 10 minutes in milliseconds

            if (cachedData && cacheTimestamp) {
                let currentTime = new Date().getTime();
                if (currentTime - cacheTimestamp < cacheDuration) {
                    // Data is cached and still valid, use it
                    displayStudentDetails(JSON.parse(cachedData));
                    return;
                }
            }

            // If no valid cache, fetch from the server
            fetch(`/get-student/${qr_code}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Cache the data and set a timestamp
                        localStorage.setItem(qr_code, JSON.stringify(data));
                        localStorage.setItem(`${qr_code}-timestamp`, new Date().getTime());
                        displayStudentDetails(data);
                    } else {
                        alert('Student not found.');
                    }
                })
                .catch(error => console.error('Error fetching student details:', error));
        }

        function displayStudentDetails(data) {
            document.getElementById("student-photo").src = data.photo;
            document.getElementById("student-name").textContent = data.name;
            document.getElementById("student-course").textContent = "Course: " + data.course;
            document.getElementById("student-year-section").textContent = "Year & Section: " + data.year + " - " + data.section;
            document.getElementById("student-semester").textContent = "Semester: " + data.semester;
            document.getElementById("student-academic-year").textContent = "Academic Year: " + data.academic_year;

            // Generate QR Code with padding and enable download button
            generateQrCodeWithMargin(data.qr_code);
        }

        function generateQrCodeWithMargin(qrCodeData) {
            const margin = 20; // Margin size (in pixels)

            // Create QR code using the provided data
            QRCode.toCanvas(document.createElement('canvas'), qrCodeData, { width: 200 }, function(error, qrCanvas) {
                if (error) {
                    console.error(error);
                    return;
                }

                // Create a new canvas to add margin
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                
                // Get the original QR code dimensions
                const qrWidth = qrCanvas.width;
                const qrHeight = qrCanvas.height;

                // Set new canvas size with margin
                canvas.width = qrWidth + margin * 2;
                canvas.height = qrHeight + margin * 2;

                // Fill the canvas with white color (margin area)
                context.fillStyle = 'white';
                context.fillRect(0, 0, canvas.width, canvas.height);

                // Draw the QR code onto the canvas with margin
                context.drawImage(qrCanvas, margin, margin);

                // Add functionality to download the QR code with margin
                document.getElementById('download-btn').onclick = function() {
                    const imageUrl = canvas.toDataURL('image/png');
                    const link = document.createElement('a');
                    link.href = imageUrl;
                    link.download = 'qrcode-with-margin.png';
                    link.click();
                };
            });
        }
    });
</script>
@endsection
