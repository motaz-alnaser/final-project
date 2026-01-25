<header class="admin-header">
    <div class="header-title">
        <h1>@yield('page_title', 'Admin Dashboard')</h1>
        <p>System overview and management</p>
    </div>
    <div class="header-user">
        <img src="{{ asset('images/admin-avatar.jpg') }}" alt="Admin User" class="user-avatar">
        <span>{{ Auth::user()->name ?? 'Admin User' }}</span>
    </div>
</header>