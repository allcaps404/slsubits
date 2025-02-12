<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <title> User Account Landing Page </title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
        <style>
            body {
                font-family: 'Roboto', sans-serif;
            }
        </style>
    </head>
    <body class="bg-gray-100">
        <header class="bg-blue-600 text-white p-4">
            <div class="container mx-auto flex justify-between items-center">
                <h1 class="text-2xl font-bold"><a href="{{ url('/') }}">Student Portal</a>  </h1>
                <nav>
                    <div class="md:hidden">
                        <button class="text-white focus:outline-none" id="menu-button">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                    <ul class="hidden md:flex space-x-4" id="menu">
                        <li>
                            <a class="hover:underline" href="{{ url('/') }}"> Home </a>
                        </li>
                        <li>
                            <a class="block text-white hover:underline" href="{{ route('student.events.index') }}"> Events/Activities </a>
                        </li>
                        <li>
                            <a class="hover:underline" href="#"> Announcements </a>
                        </li>
                        <li>
                            <a class="hover:underline" href="{{ route('student.profile') }}"> Profile </a>
                        </li>
                        <li class="relative group">
                            <a class="hover:underline cursor-pointer">Settings</a>
                            <ul class="absolute left-0 w-48 bg-white shadow-lg rounded-md hidden group-hover:block">
                                <li>
                                    <a href="{{ route('student.settings.change-password') }}" class="block px-4 py-2 hover:bg-gray-600">
                                        🔑 Change Password
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <!-- <a class="nav-link" href="{{ route('student.settings.face-registration') }}" <i class="fas fa-user-secret"></i> Face Registration</a>-->
                                </li>
                            </ul>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;"> @csrf <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout </button>
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="md:hidden">
                <ul class="hidden space-y-2 mt-2" id="mobile-menu">
                    <li>
                        <a class="block text-white hover:underline" href="{{ url('/') }}"> Home </a>
                    </li>
                    <li>
                        <a class="block text-white hover:underline" href="{{ route('student.events.index') }}"> Events/Activities </a>
                    </li>
                    <li>
                        <a class="block text-white hover:underline" href="#"> Announcements </a>
                    </li>
                    <li>
                        <a class="block text-white hover:underline" href="{{ route('student.profile') }}"> Profile </a>
                    </li>
                    <li class="relative group">
                            <a class="hover:underline cursor-pointer">Settings</a>
                            <ul class="absolute left-0 w-48 bg-white shadow-lg rounded-md hidden group-hover:block">
                                <li>
                                    <a href="{{ route('student.settings.change-password') }}" class="block px-4 py-2 hover:bg-gray-600">
                                        🔑 Change Password
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <!-- <a class="nav-link" href="{{ route('student.settings.face-registration') }}">
                                        <i class="fas fa-user-secret"></i> Face Registration
                                    </a> -->
                                </li>
                            </ul>
                        </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;"> @csrf <button type="submit" class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout </button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>
        <main class="container mx-auto mt-8 p-4"> @yield('content') </main>
        <footer class="bg-blue-600 text-white p-4 mt-8">
            <div class="container mx-auto text-center">
                <p> © 2024 Student Portal. All rights reserved. </p>
            </div>
        </footer>
        @php
            $user = Auth::user();
            $otherDetails = App\Models\OtherDetail::where('user_id', $user->id)->first();
            $isProfileComplete = isset($user->firstname, $user->lastname, $user->middlename, $user->dateofbirth, $user->email) 
                && isset($otherDetails->idnumber, $otherDetails->course, $otherDetails->year, $otherDetails->section, $otherDetails->semester, $otherDetails->academic_year, $otherDetails->birthplace, $otherDetails->address);
        @endphp

        @if(!$isProfileComplete && request()->route()->getName() !== 'student.profile')
            <div id="profile-blocker" style="
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                background: rgba(0, 0, 0, 0.7);
                color: white;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
                z-index: 9999;
            ">
                <h2>Please complete your profile before proceeding.</h2>
                <p>All required fields must be filled out.</p>
                <a href="{{ route('student.profile') }}" class="btn btn-primary" style="padding: 10px 20px; margin-top: 15px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;">Proceed to Profile</a>
            </div>
        @endif
        
        <script type="text/javascript" src="{{ asset('facerecognition/face-auth.js') }}"></script>
        <script type="text/javascript" src="{{ asset('facerecognition/face-worker.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                @if(session('success'))
                    Swal.fire({
                        title: "Success!",
                        text: "{{ session('success') }}",
                        icon: "success",
                        confirmButtonText: "OK"
                    });
                @endif

                @if(session('error'))
                    Swal.fire({
                        title: "Error!",
                        text: "{{ session('error') }}",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                @endif
            });
        </script>
        <script>
            document.getElementById('menu-button').addEventListener('click', function() {
                var menu = document.getElementById('mobile-menu');
                if (menu.classList.contains('hidden')) {
                    menu.classList.remove('hidden');
                } else {
                    menu.classList.add('hidden');
                }
            });
        </script>
    </body>
</html>