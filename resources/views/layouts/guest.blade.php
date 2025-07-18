<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Welcome to CSK Task Management System') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                background-color: #202225;
                color: white;
            }
            .login-container {
                background-color: #b9bbbe;
                color: white;
            }
            .text-gray-500 {
                color: white !important;
            }

            .login-box {
                background-color: #2f3136
            }

        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="mb-8">
                <img src="{{ asset('images/logo for laravel.png') }}" alt="App Logo" class="h-16 w-auto mx-auto">
            </div>
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 login-container shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>