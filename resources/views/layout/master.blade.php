<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PRISM FLUX - Where Ideas Refract Into Reality. Discover, create, and connect through amazing activities.">
    <meta name="keywords" content="activities, events, community, experiences, prism flux">
    <title>@yield('title', 'PRISM FLUX - Where Ideas Refract Into Reality')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/templatemo-prism-flux.css') }}">
    
    <!-- Additional Stylesheets -->
    @yield('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

    @include('layout.header')

    <main class="main-content">
        @yield('content')
    </main>

    @include('layout.footer')

    <!-- Main JavaScript -->
    <script src="{{ asset('js/templatemo-prism-scripts.js') }}"></script>
    
    <!-- Additional Scripts -->
    @yield('scripts')

</body>
</html>