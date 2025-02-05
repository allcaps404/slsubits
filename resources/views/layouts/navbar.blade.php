<nav class="navbar navbar-expand navbar-light topbar mb-4 shadow" style="position: fixed; top: 0; left: 250px; width: calc(100% - 250px); z-index: 1000;">
    <ul class="navbar-nav ml-auto">
        <!-- User Profile Dropdown -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @if(Auth::user()->photo)
		            <img src="{{ asset(Auth::user()->photo) }}" alt="User  Photo" class="img-profile rounded-circle" style="width: 40px; height: 40px;">
		        @else
		            <i class="fas fa-user-circle" style="font-size: 40px; color: #007acc;"></i> <!-- Default user icon -->
		        @endif
                <span class="ml-2 d-none d-lg-inline text-gray-600 small">Hi, {{ Auth::user()->firstname }}!</span> 
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <div class="dropdown-divider"></div>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>