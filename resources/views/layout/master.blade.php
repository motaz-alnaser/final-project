<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('css/templatemo-prism-flux.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owner_admin.css') }}">
    
    @yield('styles')
</head>
<body>

    @include('layout.header')


        @yield('content')



    @include('layout.footer')


<script src="{{ asset('js/templatemo-prism-scripts.js') }}"></script>
@yield('scripts')

</body>
</html>
