<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen font-sans antialiased bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950 text-slate-200">
        <div class="min-h-screen relative">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="mx-6 mt-4 glass-card">
                    <div class="max-w-7xl mx-auto py-6 px-6">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="py-8">
                {{ $slot }}
            </main>
        </div>
        <div class="pointer-events-none fixed -top-40 -left-40 h-[520px] w-[520px] rounded-full bg-indigo-600/30 blur-[120px]"></div>
        <div class="pointer-events-none fixed -bottom-40 -right-40 h-[520px] w-[520px] rounded-full bg-fuchsia-600/20 blur-[120px]"></div>
    </body>
</html>