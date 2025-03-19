<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Roles'}}</title>
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    @yield('styles')
    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f0f4f8; /* Light background for the body */
        }

        #wrapper {
            background-color: #ffffff; /* White background for the wrapper */
        }

        #content-wrapper {
            margin-left: 250px; /* Adjust this value based on your sidebar width */
            margin-top: 56px; /* Adjust this value based on your navbar height */
            transition: margin-left 0.2s, margin-top 0.2s; /* Smooth transition for margin changes */
        }

        /* Sidebar styles */
        .sidebar {
            background: linear-gradient(180deg, #4db8ff 10%, #0099cc 100%); /* Cool blue gradient */
        }

        .sidebar .nav-link {
            color: #ffffff; /* White text for sidebar links */
        }

        .sidebar .nav-link.active {
            background-color: #007acc; /* Darker shade for active link */
            color: #ffffff; /* White text for active link */
        }

        .sidebar .nav-link:hover {
            background-color: #007acc; /* Darker shade on hover */
            color: #ffffff; /* White text on hover */
        }

        /* Topbar styles */
        .topbar {
            background-color: #ffffff; /* White background for navbar */
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow for navbar */
        }

        .topbar .nav-link {
            color: #333333; /* Dark text for navbar links */
        }

        .topbar .nav-link:hover {
            color: #007acc; /* New primary color on hover */
        }

        .active {
            background-color: #007acc; /* Darker shade for active state */
            color: #ffffff; /* White text for active state */
        }

        @media (max-width: 768px) {
            #content-wrapper {
                margin-left: 0; /* Remove margin on smaller screens */
                margin-top: 0; /* Remove top margin on smaller screens */
            }
        }
    </style>
</head>
<body id="page-top">
    <div id="wrapper">
        @include('layouts.sidebar')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('layouts.navbar')
                <div class="container-fluid mt-4">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <!-- SB Admin 2 Scripts -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.8/dist/sweetalert2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.8/dist/sweetalert2.min.css" rel="stylesheet">
</body>
</html>