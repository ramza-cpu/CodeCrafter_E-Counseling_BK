<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    
    {{-- Global CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('app.css') }}">

    {{-- Page-specific CSS --}}
    @stack('styles')

</head>
<body>
    <div class="container">

        {{-- Sidebar Component --}}
        <x-sidebar />

        {{-- Main Content --}}
        <main class="main">
            @yield('content')
        </main>

</div>
    {{-- Global JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        {{-- Page-specific JS --}}
    @stack('scripts')

</body>
</html>
