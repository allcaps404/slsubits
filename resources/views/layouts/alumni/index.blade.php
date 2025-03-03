<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Landing Page</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            overflow-x: hidden;
        }

        #sidebar-wrapper {
            width: 15rem;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: white;
            border-right: 1px solid #ddd;
            overflow-y: auto;
            transition: all 0.3s;
            z-index: 1000;
        }

        #sidebar-wrapper .sidebar-heading {
            padding: 0.875rem 1.25rem;
            font-size: 1.2rem;
            font-weight: bold;
            background-color:rgb(37, 99, 235);
            color: white;
            text-align: center;
        }

        .list-group-item {
            border: none;
            padding: 1rem 1.5rem;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
        }

        /* 🔥 FIXED Navbar */
        .navbar {
            position: fixed; /* Keeps navbar at the top */
            top: 0;
            left: 15rem; /* Adjust to match sidebar width */
            right: 0;
            z-index: 1001; /* Higher than sidebar */
            background: white;
            border-bottom: 1px solid #ddd;
            padding: 0.75rem 1.5rem;
        }

        /* Prevent content from going under the navbar */
        #page-content-wrapper {
            margin-left: 15rem; /* Prevents overlap */
            padding-top: 70px; /* Push content down */
            flex-grow: 1;
            padding: 20px;
            transition: all 0.3s;
        }

        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 500;
        }

        .card-text {
            font-size: 1rem;
            color: #6c757d;
        }

        .img-fluid {
            border-radius: 0.75rem;
        }

        /* Responsive Behavior */
        @media (max-width: 767px) {
            #sidebar-wrapper {
                left: -15rem;
            }

            #wrapper.toggled #sidebar-wrapper {
                left: 0;
            }

            .navbar {
                left: 0;
            }

            #page-content-wrapper {
                margin-left: 0; 
                padding-top: 70px;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body class="bg-light">
    <div class="d-flex" id="wrapper">
        <div class="bg-white border-right" id="sidebar-wrapper">
            <div class="sidebar-heading">Alumni Portal</div>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action bg-white" href="{{url('/alumni')}}"><i class="fas fa-home mr-2"></i> Home</a>
                <a class="list-group-item list-group-item-action bg-white" href="#"><i class="fas fa-calendar-alt mr-2"></i> Events</a>
                <a class="list-group-item list-group-item-action bg-white" href="{{ route('yearbook.index') }}"><i class="fas fa-book mr-2"></i> Yearbook</a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light">
                <button class="btn btn-primary d-block d-md-none" id="menu-toggle"><i class="fas fa-bars"></i></button>
                <h2 class="ml-3 my-0">{{ $page ?? 'Yearbook Information' }}</h2>
                <div class="ml-auto">
                    <div class="dropdown">
                        <button class="btn btn-white dropdown-toggle" id="accountDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="https://storage.googleapis.com/a1aa/image/lWklqY928xnSPgHWULfhgIMFk1y4KEZFFI1tbvqvW9Y.jpg" class="rounded-circle mr-2" width="40" height="40" alt="Profile">
                            {{ Auth::user()->firstname}}
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="accountDropdown">
                            <a class="dropdown-item" href="{{ route('alumni.profile') }}">Profile</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
            @yield ('content')
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->

    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
</body>
</html>
