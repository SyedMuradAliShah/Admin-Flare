<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ @$title ? "{$title} - ":"" }}{{ config('setting.site_general_name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    {{-- @vite(['resources/css/admin/app.css', 'resources/js/admin/app.js'], 'assets/admin/build') --}}
    @vite(['resources/css/admin/app.css'])
</head>
<body class="position-relative">

    <x-admin.darkmode-switch class="position-absolute top-0 end-0 p-3" />
    <section class="login vh-100 d-flex align-items-center justify-content-center">
        <div class="container">
            {{ $slot }}
        </div>
    </section>

    @vite(['resources/js/admin/app.js'])
</body>
</html>
