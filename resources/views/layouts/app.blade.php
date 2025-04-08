<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Shop Homepage')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body>
    @include('partials.nav')

     @yield('content')
     
     <footer class="py-16 text-center text-sm text-dark">
     &copy 2025 Bloom & Bliss.
     </footer>

    <script src="{{ asset('js/scripts.js') }}"></script>
</body>

</html>
