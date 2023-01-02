<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? config()->get('app.name') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite('resources/css/app.css')
    @livewireStyles

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body>
<div class="bg-gray-900 min-h-screen flex items-center justify-center">
    <div class="bg-gray-800 flex-1 flex flex-col space-y-5 lg:space-y-0 lg:flex-row md:p-2 h-screen">
        @if(Auth::hasRole('needs-sync') && !session()->has('success') && !session()->has('synced'))
            <livewire:sync-ldap/>
        @else
            <x-sidebar/>
            <div class="flex-1 md:p-8 sm:px-0 space-y-5 sm:space-y-10 overflow-auto">
                {{ $slot }}
            </div>
        @endif
    </div>
</div>
@livewire('livewire-ui-modal')
@livewireScripts
</body>
</html>
