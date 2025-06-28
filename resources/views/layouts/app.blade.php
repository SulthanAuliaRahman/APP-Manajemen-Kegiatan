<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-indigo-900 text-white flex h-screen">
    <div class="flex h-full">
        <x-sidebar />
        <div class="flex-1 p-6">
            @yield('content')
        </div>
    </div>
    
    <!-- Load specific JavaScript files based on current route -->
    @if(request()->routeIs('manageUser'))
        @vite(['resources/js/manageUser.js'])
    @elseif(request()->routeIs('kegiatanSaya'))
        @vite(['resources/js/kegiatanSaya.js'])
    @endif
    
    <!-- Stack for additional scripts -->
    @stack('scripts')
</body>
</html>