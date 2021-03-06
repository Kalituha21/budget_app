<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Budget app') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    <style>
        html, body {
            height: 100%;
        }

        .height-100 {
            height: 100%;
        }

        .height-95 {
            height: 95%;
        }
    </style>
</head>
<body>
    <div id="app" class="height-100">
        <main class="height-100">
            @yield('content')
        </main>
    </div>
</body>
</html>
