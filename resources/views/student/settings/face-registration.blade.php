@extends('layouts.student.index')

@section('content')
<div class="container">
    <div class="text-center my-4">
        <h3 class="font-bold text-xl">Face Registration</h3>
        <p class="text-gray-600">Register your face for secure authentication.</p>
    </div>

    <!-- Face Scan Box with Animated Icon -->
    <div id="faceScanBox" class="flex flex-col items-center justify-center p-6 border rounded-lg shadow-md bg-gray-100">
        <i class="fas fa-camera text-6xl text-gray-500 animate-pulse"></i>
        <p class="text-gray-700 mt-2">Click the button below to start scanning.</p>
    </div>

    <!-- Button to Start Face Registration -->
    <div class="text-center mt-4">
        <button id="registerFace" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none">
            <i class="fas fa-user-check mr-2"></i> Register Face
        </button>
    </div>

    <!-- Hidden Video Element for Face Capture -->
    <video id="faceCam" autoplay hidden></video>

    <!-- Feedback Message -->
    <div id="feedbackMessage" class="text-center mt-4"></div>
</div>

<script>
    const faceRegisterUrl = @json(route('student.settings.store-face'));
    const csrfToken = @json(csrf_token());

    document.getElementById("registerFace").addEventListener("click", async function() {
        let faceScanBox = document.getElementById("faceScanBox");
        let feedbackMessage = document.getElementById("feedbackMessage");

        try {
            const stream = await navigator.mediaDevices.getUserMedia({ video: true });
            const video = document.getElementById("faceCam");
            video.srcObject = stream;
            video.play();

            faceScanBox.innerHTML = `<p class="text-blue-500">Scanning face, please wait...</p>`;

            setTimeout(async () => {
                const canvas = document.createElement("canvas");
                canvas.width = 128; // Low resolution to reduce lag
                canvas.height = 128;
                canvas.getContext("2d").drawImage(video, 0, 0, 128, 128);

                const imgData = canvas.toDataURL("image/png");

                // Stop video stream to prevent lag
                stream.getTracks().forEach(track => track.stop());

                faceScanBox.innerHTML = `<p class="text-gray-700">Uploading...</p>`;

                // Upload face data
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
                        feedbackMessage.innerHTML = `<p class="text-green-600 font-bold"><i class="fas fa-check-circle"></i> Face Registered Successfully!</p>`;
                    } else {
                        feedbackMessage.innerHTML = `<p class="text-red-600"><i class="fas fa-exclamation-triangle"></i> Error: ${data.error}</p>`;
                    }
                })
                .catch(err => {
                    feedbackMessage.innerHTML = `<p class="text-red-600"><i class="fas fa-times-circle"></i> Upload failed. Try again.</p>`;
                });

            }, 2000);
        } catch (err) {
            alert("Camera access denied. Please allow camera permissions.");
        }
    });
</script>
@endsection
