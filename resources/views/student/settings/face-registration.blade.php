@extends('layouts.student.index')

@section('content')
<div class="container">
    <h3>Face Registration</h3>
    <p>Register your face for secure authentication.</p>

    <!-- Face Scan Box with Icon -->
    <div id="faceScanBox" class="text-center p-4">
        <i class="fas fa-user-secret text-6xl text-gray-600 animate-pulse"></i>
        <p>Click the button below to scan.</p>
    </div>

    <!-- Button to Start Registration -->
    <button id="registerFace" class="btn btn-primary mt-3">Register Face</button>

    <!-- Hidden Video Element for Face Capture -->
    <video id="faceCam" autoplay hidden></video>

</div>
<script>
    const faceRegisterUrl = @json(route('student.settings.store-face'));
    const csrfToken = @json(csrf_token());
</script>

<script>
	document.getElementById("registerFace").addEventListener("click", async function() {
	    let faceScanBox = document.getElementById("faceScanBox");

	    try {
	        const stream = await navigator.mediaDevices.getUserMedia({ video: true });
	        const video = document.getElementById("faceCam");
	        video.srcObject = stream;
	        video.play();

	        setTimeout(async () => {
	            const canvas = document.createElement("canvas");
	            canvas.width = 128; // Low resolution to reduce lag
	            canvas.height = 128;
	            canvas.getContext("2d").drawImage(video, 0, 0, 128, 128);

	            const imgData = canvas.toDataURL("image/png"); // Ensure proper format

	            // Stop the video stream to prevent lag
	            stream.getTracks().forEach(track => track.stop());

	            faceScanBox.innerHTML = `<p>Uploading...</p>`;

	            // Fix: Use JavaScript variables for Blade routes
	            fetch(faceRegisterUrl, {
	                method: "POST",
	                headers: { 
	                    "Content-Type": "application/json",
	                    "X-CSRF-TOKEN": csrfToken
	                },
	                body: JSON.stringify({ face_descriptor: imgData })
	            })
	            .then(res => res.json())
	            .then(data => {
	                if (data.success) {
	                    faceScanBox.innerHTML = `<p class="text-green-500">Face Registered Successfully!</p>`;
	                } else {
	                    faceScanBox.innerHTML = `<p class="text-red-500">Error: ${data.error}</p>`;
	                }
	            })
	            .catch(err => {
	                faceScanBox.innerHTML = `<p class="text-red-500">Upload failed. Try again.</p>`;
	            });

	        }, 2000);
	    } catch (err) {
	        alert("Camera access denied. Please allow camera permissions.");
	    }
	});
</script>
@endsection