@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h5 mb-0 text-gray-800">Dashboard</h1> <!-- Changed h3 to h5 for smaller text -->
</div>
<div class="row">

    <!-- Total Registered Students Chart -->
    <div class="col-12 col-md-4 mb-4"> <!-- Adjusted for responsiveness -->
        <div class="card shadow">
            <div class="card-body text-center">  <!-- Centering the body -->
                <h5 class="card-title">Total Registered Students</h5>
                <canvas id="studentsChart"></canvas> <!-- Canvas for Chart.js -->
            </div>
        </div>
    </div>

    <!-- Total Registered Admins Chart -->
    <div class="col-12 col-md-4 mb-4"> <!-- Adjusted for responsiveness -->
        <div class="card shadow">
            <div class="card-body text-center">  <!-- Centering the body -->
                <h5 class="card-title">Total Registered Admins</h5>
                <canvas id="adminsChart"></canvas> <!-- Canvas for Chart.js -->
            </div>
        </div>
    </div>

    <!-- Total Registered Scanners Chart -->
    <div class="col-12 col-md-4 mb-4"> <!-- Adjusted for responsiveness -->
        <div class="card shadow">
            <div class="card-body text-center">  <!-- Centering the body -->
                <h5 class="card-title">Total Registered Scanners</h5>
                <canvas id="scannersChart"></canvas> <!-- Canvas for Chart.js -->
            </div>
        </div>
    </div>

</div>

<script>
    // Sample data for the charts
    const studentsData = {
        labels: ['Total Students'],
        datasets: [{
            label: 'Total Registered Students',
            data: [{{ $totalRegisteredStudents }}], // Pass the total from the controller
            backgroundColor: 'rgba(78, 115, 223, 0.5)',
            borderColor: 'rgba(78, 115, 223, 1)',
            borderWidth: 1
        }]
    };

    const adminsData = {
        labels: ['Total Admins'],
        datasets: [{
            label: 'Total Registered Admins',
            data: [{{ $totalRegisteredAdmins }}], // Pass the total from the controller
            backgroundColor: 'rgba(28, 200, 138, 0.5)',
            borderColor: 'rgba(28, 200, 138, 1)',
            borderWidth: 1
        }]
    };

    const scannersData = {
        labels: ['Total Scanners'],
        datasets: [{
            label: 'Total Registered Scanners',
            data: [{{ $totalRegisteredScanners }}], // Pass the total from the controller
            backgroundColor: 'rgba(255, 193, 7, 0.5)',
            borderColor: 'rgba(255, 193, 7, 1)',
            borderWidth: 1
        }]
    };

    // Configuration for the charts
    const config = {
        type: 'bar', // You can change this to 'line', 'pie', etc.
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    // Create the charts
    const studentsChart = new Chart(document.getElementById('studentsChart'), {
        ...config,
        data: studentsData
    });

    const adminsChart = new Chart(document.getElementById('adminsChart'), {
        ...config,
        data: adminsData
    });

    const scannersChart = new Chart(document.getElementById('scannersChart'), {
        ...config,
        data: scannersData
    });
</script>
@endsection
