<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Shop Homepage')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
