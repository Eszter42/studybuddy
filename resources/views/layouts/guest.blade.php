<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-slate-100">

    <div class="min-h-screen flex flex-col justify-center items-center
                bg-gradient-to-br from-slate-900 via-indigo-950 to-purple-950 px-6">

        <div class="mb-6">
            <a href="/">
                <x-application-logo class="w-20 h-20 text-slate-400" />
            </a>
        </div>

        <div class="w-full sm:max-w-md">
            {{ $slot }}
        </div>

    </div>

</body>
</html>