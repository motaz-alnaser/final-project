<header class="admin-header">
    <div class="header-title">
        <h1>@yield('page_title', 'Admin Dashboard')</h1>
        
    </div>
    <div class="header-user">
        <span>{{ Auth::user()->name ?? 'Admin User' }}</span>
    </div>
</header>