<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="position: fixed; top: 0; left: 0; height: 100vh; overflow-y: auto; z-index: 1000;">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">BITS Admin</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('events.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('events.index') }}">
            <i class="fas fa-fw fa-calendar-alt"></i>
            <span>Events</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('usersmanagement.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('usersmanagement.index') }}">
            <i class="fas fa-fw fa-user-graduate"></i>
            <span>Users</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('roles.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('roles.index') }}">
            <i class="fas fa-fw fa-user-graduate"></i>
            <span>Roles</span>
        </a>
    </li>
</ul>