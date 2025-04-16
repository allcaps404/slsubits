@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h5 mb-0 text-gray-800">Dashboard</h1>
</div>

<div class="row">
    <div class="col-12 col-md-4 mb-4">
        <div class="card shadow">
            <div class="card-body text-center"> 
                <h5 class="card-title">Students</h5>
                <canvas id="studentsChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4 mb-4">
        <div class="card shadow">
            <div class="card-body text-center">
                <h5 class="card-title">Admins</h5>
                <canvas id="adminsChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4 mb-4">
        <div class="card shadow">
            <div class="card-body text-center">
                <h5 class="card-title">Scanners</h5>
                <canvas id="scannersChart"></canvas>
            </div>
        </div>
    </div>


    <div class="col-12 col-md-4 mb-4">
        <div class="card shadow">
            <div class="card-body text-center">
                <h5 class="card-title">Alumni</h5>
                <canvas id="alumniChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    const config = {
        type: 'bar',
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    const studentsChart = new Chart(document.getElementById('studentsChart'), {
        ...config,
        data: {
            labels: ['Total Students'],
            datasets: [{
                label: 'Total Registered Students',
                data: [{{ $totalRegisteredStudents }}],
                backgroundColor: 'rgba(78, 115, 223, 0.5)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 1
            }]
        }
    });

    const adminsChart = new Chart(document.getElementById('adminsChart'), {
        ...config,
        data: {
            labels: ['Total Admins'],
            datasets: [{
                label: 'Total Registered Admins',
                data: [{{ $totalRegisteredAdmins }}], 
                backgroundColor: 'rgba(28, 200, 138, 0.5)',
                borderColor: 'rgba(28, 200, 138, 1)',
                borderWidth: 1
            }]
        }
    });

    const scannersChart = new Chart(document.getElementById('scannersChart'), {
        ...config,
        data: {
            labels: ['Total Scanners'],
            datasets: [{
                label: 'Total Registered Scanners',
                data: [{{ $totalRegisteredScanners }}],
                backgroundColor: 'rgba(255, 193, 7, 0.5)',
                borderColor: 'rgba(255, 193, 7, 1)',
                borderWidth: 1
            }]
        }
    });

    const alumnusChart = new Chart(document.getElementById('alumniChart'), {
        ...config,
        data: {
            labels: ['Total Alumni'],
            datasets: [{
                label: 'Total Registered Alumni',
                data: [{{ $totalRegisteredAlumni }}],
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        }
    });

</script>
@endsection
