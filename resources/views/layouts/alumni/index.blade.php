<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Landing Page</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    @yield('styles')
    @yield('scripts')
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            overflow-x: hidden;
            height: 100vh;
            display: flex;
            flex-direction: column;
            background-color:hsl(206, 63.10%, 87.30%);
        }

        #sidebar-wrapper {
            width: 16rem;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(180deg, #003366, #00509E);
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
            overflow-y: auto;
            transition: all 0.3s ease-in-out;
            z-index: 1000;
        }

        #sidebar-wrapper .sidebar-heading {
            padding: 1rem;
            font-size: 1.4rem;
            font-weight: bold;
            background-color: #FFC107;
            color: #003366;
            text-align: center;
            border-bottom: 3px solid #FFD54F;
        }

        .list-group-item {
            border: none;
            padding: 1rem 1.5rem;
            color: white;
            background-color: transparent;
            font-size: 1.1rem;
            font-weight: 500;
            transition: all 0.3s ease-in-out;
        }

        .list-group-item:hover, 
        .list-group-item:focus {
            background-color: #FFC107;
            color: #003366;
            font-weight: bold;
            border-radius: 5px;
        }

        .navbar {
            position: fixed; 
            top: 0;
            left: 16rem;
            right: 0;
            z-index: 1001;
            background: white;
            border-bottom: 3px solid #FFC107;
            padding: 0.75rem 1.5rem;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar h2 {
            color: #003366; 
            font-weight: bold;
        }

        .navbar .btn-white {
            color: #003366;
            font-weight: bold;
        }

        #page-content-wrapper {
            margin-left: 16rem;
            padding-top: 70px;
            flex-grow: 1;
            padding: 62px;
            transition: all 0.3s;
            background-color:rgb(180, 218, 245);
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            background:rgb(90, 153, 216);
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #003366;
        }

        .card-text {
            font-size: 1rem;
            color: #6c757d;
        }

        .profile-img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #FFC107;
        }

        .btn-primary {
            background-color: #00509E;
            border: none;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #003366;
        }

        @media (max-width: 767px) {
            #sidebar-wrapper {
                left: -16rem;
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
        <div class="border-right" id="sidebar-wrapper">
            <div class="sidebar-heading">Alumni Portal</div>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action" href="{{url('/alumni')}}"><i class="fas fa-home mr-2"></i> Home</a>
                <a class="list-group-item list-group-item-action" href="#"><i class="fas fa-calendar-alt mr-2"></i> Events</a>
                <a class="list-group-item list-group-item-action" href="{{ route('yearbook.index') }}"><i class="fas fa-book mr-2"></i> Yearbook</a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light">
                <button class="btn btn-primary d-block d-md-none" id="menu-toggle"><i class="fas fa-bars"></i></button>
                <h2 class="ml-3 my-0">{{ $page ?? ' ' }}</h2>
                <div class="ml-auto">
                    <div class="dropdown">
                        <button class="btn btn-white dropdown-toggle" id="accountDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if(auth()->user()->otherDetail && auth()->user()->otherDetail->photo)
                                <img src="data:image/jpeg;base64,{{ auth()->user()->otherDetail->photo }}" class="profile-img mr-2" alt="Profile">
                            @else
                                <img src="https://via.placeholder.com/40" class="profile-img mr-2" alt="Profile">
                            @endif
                            {{ Auth::user()->firstname }}
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
