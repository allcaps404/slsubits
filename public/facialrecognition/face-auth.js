const faceAuthModal = document.getElementById("faceAuthModal");
const worker = new Worker("face-worker.js");

// Start Face Authentication (Show icon, Scan Face)
async function startFaceAuth() {
    faceAuthModal.classList.remove("hidden");

    const stream = await navigator.mediaDevices.getUserMedia({ video: true });
    const video = document.createElement("video");
    video.srcObject = stream;
    video.play();

    setTimeout(async () => {
        // Capture frame and send to Worker
        const canvas = document.createElement("canvas");
        canvas.width = 128;
        canvas.height = 128;
        canvas.getContext("2d").drawImage(video, 0, 0, 128, 128);

        worker.postMessage({ imageData: canvas.toDataURL() });
    }, 1000);
}

// Handle Worker Response
worker.onmessage = async function (event) {
    if (!event.data) {
        alert("Face not detected! Try again.");
        faceAuthModal.classList.add("hidden");
        return;
    }

    // Send face descriptor to server for verification
    const response = await fetch("/verify-face", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ face: event.data })
    });

    const result = await response.json();

    if (result.verified) {
        faceAuthModal.classList.add("hidden");
        window.location.href = "/events";
    } else {
        alert("Face not recognized! Try again.");
        faceAuthModal.classList.add("hidden");
    }
};

// Call Face Authentication when accessing Events Page
document.getElementById("eventsPageLink").addEventListener("click", function (e) {
    e.preventDefault();
    startFaceAuth();
});
