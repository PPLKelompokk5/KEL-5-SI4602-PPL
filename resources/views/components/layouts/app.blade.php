<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />

        <meta name="application-name" content="{{ config('app.name') }}" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>{{ config('app.name') }}</title>

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        @filamentStyles
        @vite('resources/css/app.css')
    </head>

    <body class="antialiased">
        @yield('content')

        @filamentScripts
        @vite('resources/js/app.js')
        <footer class="w-full text-center py-4 text-gray-500 text-sm mt-10 flex flex-col items-center gap-2">
            <span>
                © 2024 Project Management System. All rights reserved.
            </span>
            <a href="/about"
               class="inline-block px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition font-semibold"
               style="text-decoration: none;">
                About
            </a>
        </footer>
    </body>
</html>
