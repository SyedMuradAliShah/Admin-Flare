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
    @vite(['resources/css/admin/app.css', 'resources/js/admin/app.js'], 'assets/admin/build')
    {{-- @vite(['resources/css/admin/app.css']) --}}
</head>
<body>
    <body>
        <div class="dashbaord">
            <x-admin.sidebar />
            <div class="main-content">
                <div class=" min-vh-100">
                    <livewire:admin.layout.navigation />

                    <div class="content px-4">
                        <x-admin.page-title :title="$title??''" />

                        {{ $slot }}
                    </div>

                </div>

                <x-admin.footer />
            </div>
        </div>

        {{-- @vite(['resources/js/admin/app.js']) --}}
    </body>
</html>
