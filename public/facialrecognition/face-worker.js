importScripts("https://cdn.jsdelivr.net/npm/face-api.js");

async function loadModels() {
    await faceapi.nets.tinyFaceDetector.loadFromUri("/models");
    await faceapi.nets.faceLandmark68Net.loadFromUri("/models");
    await faceapi.nets.faceRecognitionNet.loadFromUri("/models");
}

loadModels();

onmessage = async function (event) {
    const img = await faceapi.bufferToImage(event.data.imageData);
    const detection = await faceapi.detectSingleFace(img, new faceapi.TinyFaceDetectorOptions())
        .withFaceLandmarks()
        .withFaceDescriptor();

    postMessage(detection ? detection.descriptor : null);
};
