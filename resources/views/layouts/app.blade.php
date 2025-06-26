<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-indigo-900 text-white flex h-screen">
    <div class="flex h-full">
        <x-sidebar />
        <div class="flex-1 p-6">
            @yield('content')
        </div>
    </div>
</body>
</html>