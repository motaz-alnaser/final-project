<div class="admin-sidebar">
    <div class="logo-icon">
                <img src="{{ asset('images/downloadlogo-removebg-preview (1).png') }}" alt="PRISM FLUX Logo" class="logo-img">
            </div>

    <ul class="sidebar-menu">
        
        @if(Auth::check() && Auth::user()->role === 'admin')
            <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a></li>
            <li><a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">Users</a></li>
            <li><a href="{{ route('admin.hosts') }}" class="{{ request()->routeIs('admin.hosts') ? 'active' : '' }}">Hosts</a></li>
            <li><a href="{{ route('admin.earnings') }}" class="{{ request()->routeIs('admin.earnings_by_activity') ? 'active' : '' }}">Earnings</a></li>
            <li><a href="{{ route('admin.activities') }}" class="{{ request()->routeIs('admin.activities') ? 'active' : '' }}">Activities</a></li>
            <li><a href="{{ route('admin.create_activity') }}" class="{{ request()->routeIs('admin.create_activity') ? 'active' : '' }}">Create Activity</a></li>
            <li><a href="{{ route('admin.bookings') }}" class="{{ request()->routeIs('admin.bookings') ? 'active' : '' }}">Bookings</a></li>
            <li><a href="{{ route('admin.admin_profile') }}" class="{{ request()->routeIs('admin.admin_profile') ? 'active' : '' }}">Admin Profile</a></li>
            <li><a href="{{ route('admin.reviews') }}" class="{{ request()->routeIs('admin.reviews') ? 'active' : '' }}">Reviews & Ratings</a></li>

        
        @elseif(Auth::check() && Auth::user()->role === 'host')
            <li><a href="{{ route('owner.dashboard') }}" class="{{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">Dashboard</a></li>
            <li><a href="{{ route('owner.bookings') }}" class="{{ request()->routeIs('owner.bookings') ? 'active' : '' }}">My Bookings</a></li>
            <li><a href="{{ route('owner.earnings') }}" class="{{ request()->routeIs('owner.earnings') ? 'active' : '' }}">My Earnings</a></li>
            <li><a href="{{ route('owner.reviews') }}" class="{{ request()->routeIs('owner.reviews') ? 'active' : '' }}">My Reviews</a></li>
            <li><a href="{{ route('owner.add_activity') }}" class="{{ request()->routeIs('owner.add_activity') ? 'active' : '' }}">Add Activity</a></li>

        
        @else
            <li><a href="{{ route('login') }}">Login</a></li>
        @endif

       
        @auth
            <li style="margin-top: 20px;">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn" style="
                        width: 100%;
                        padding: 14px 16px;
                        border-radius: 10px;
                        background: transparent;
                        border: 1px solid var(--metal-dark);
                        color: var(--text-secondary);
                        text-decoration: none;
                        font-size: 15px;
                        transition: all 0.3s ease;
                        cursor: pointer;
                    ">Log Out</button>
                </form>
            </li>
        @endauth
    </ul>
</div>