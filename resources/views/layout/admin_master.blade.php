<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>

    <link rel="stylesheet" href="{{ asset('css/templatemo-prism-flux.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owner_admin.css') }}">
    
    @yield('styles')
</head>
<body>

    @include('layout.admin_header')

    <div class="admin-container">
        @include('layout.admin_sidbar')

        <main class="admin-content">
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('js/templatemo-prism-scripts.js') }}"></script>
    @yield('scripts')

</body>
</html>