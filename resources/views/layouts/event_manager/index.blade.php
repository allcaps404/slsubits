<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Event Manager Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .sidebar-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .sidebar-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            border-left: 4px solid white;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div id="wrapper" class="flex h-screen">
        <!-- Sidebar -->
        <div id="sidebar-wrapper" class="w-64 bg-blue-700 text-white shadow-lg flex flex-col">
            <!-- Logo/Brand Section -->
            <div class="p-4 flex items-center space-x-3 border-b border-blue-600">
                <div class="bg-white p-2 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h1 class="text-xl font-bold">Event Manager</h1>
            </div>

            

            <!-- Navigation Links -->
            <div class="flex-1 overflow-y-auto py-4">
                <nav>
                    <ul>
                        <li>
                            <a href="{{ route('event_manager.index') }}" class="sidebar-link flex items-center px-6 py-3 transition-all duration-200 {{ request()->routeIs('event_manager.index') ? 'active' : '' }}">
                                <i class="fas fa-tachometer-alt mr-3 text-blue-200"></i>
                                <span>Events</span>
                            </a>
                        </li>
                        <div class="flex-1 overflow-y-auto py-4">
    <nav>
        <ul>
            <li>
                <div class="flex items-center justify-between px-6 py-3 cursor-pointer transition-all duration-200 {{ request()->routeIs('event_manager.index') ? 'active' : '' }}" onclick="toggleDropdown('management-dropdown')">
                    <div class="flex items-center">
                        <i class="fas fa-calendar-alt mr-3 text-blue-200"></i>
                        <span>Attendance Management</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs text-blue-200 transition-transform duration-200" id="management-dropdown-arrow"></i>
                </div>
                <!-- Dropdown menu -->
                <ul class="ml-8 pl-2 border-l-2 border-gray-200 hidden" id="management-dropdown">
                <!-- Sidebar Link -->
                    <li>
                        <a href="{{ route('event_manager.by_student.index') }}" class="sidebar-link flex items-center px-4 py-2 transition-all duration-200">
                            <i class="fas fa-user-graduate mr-3 text-blue-200"></i>
                            <span>By Student</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('event_manager.by_year_section.index') }}" class="sidebar-link flex items-center px-4 py-2 transition-all duration-200">
                            <i class="fas fa-users mr-3 text-blue-200"></i>
                            <span>By Year & Section</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</div>

<script>
    function toggleDropdown(id) {
        const dropdown = document.getElementById(id);
        const arrow = document.getElementById(id + '-arrow');
        
        dropdown.classList.toggle('hidden');
        arrow.classList.toggle('rotate-180');
    }
</script>
                       
                    </ul>
                </nav>
            </div>

            <!-- Collapse Button (Mobile) -->
            <div class="p-4 border-t border-blue-600 lg:hidden">
                <button id="sidebar-toggle" class="w-full flex items-center justify-between text-blue-200 hover:text-white">
                    <span>Collapse Menu</span>
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
        </div>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm">
                <div class="flex justify-between items-center p-4">
                    <!-- Mobile menu button -->
                    <button id="mobile-menu-button" class="lg:hidden text-blue-700">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <h1 class="text-xl font-semibold text-gray-800"></h1>

                    <div class="flex items-center space-x-4">
                       

                        <!-- User Dropdown -->
                        <div class="relative">
                            <button id="user-menu-button" class="flex items-center space-x-2 focus:outline-none">
                                <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-medium">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="hidden md:inline text-gray-700">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                    
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-4 bg-gray-50">
                @yield('content')
            </main>

            
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.8/dist/sweetalert2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.8/dist/sweetalert2.min.css" rel="stylesheet">
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Mobile menu toggle
            document.getElementById('mobile-menu-button').addEventListener('click', function() {
                document.getElementById('sidebar-wrapper').classList.toggle('hidden');
            });

            // Sidebar toggle for mobile
            document.getElementById('sidebar-toggle').addEventListener('click', function() {
                document.getElementById('sidebar-wrapper').classList.toggle('hidden');
            });

            // User dropdown toggle
            document.getElementById('user-menu-button').addEventListener('click', function() {
                document.getElementById('user-dropdown').classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!event.target.closest('#user-menu-button')) {
                    document.getElementById('user-dropdown').classList.add('hidden');
                }
            });

            // SweetAlert notifications
            @if(session('success'))
                Swal.fire({
                    title: "Success!",
                    text: "{{ session('success') }}",
                    icon: "success",
                    confirmButtonText: "OK",
                    confirmButtonColor: "#3B82F6",
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    title: "Error!",
                    text: "{{ session('error') }}",
                    icon: "error",
                    confirmButtonText: "OK",
                    confirmButtonColor: "#EF4444",
                });
            @endif
        });
    </script>
</body>
</html>