<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Overpass:wght@200&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <style>
            .map {
                width: 100%;
                height: 350px;
            }
            .overlay-container {
                width: 250px;
                font-size: 11px;
                background-color: #f5f5f5;
                color: #000;
                border: 1px solid black;
                border-radius: 5px;
                padding: 5px;
                position: absolute;
                z-index: 1000;
                bottom: 100%;
                left: 100%;
                margin-left: -125px;
            }
            .compass-color {
                margin: 3px;
                height: 15px;
                width: 15px;
                background-color: #bbb;
                border-radius: 50%;
                display: inline-block;
            }
            .fly-map {
                position: absolute;
                top: 146px; /* Header Height */
                bottom: 0px; /* Footer Height */
                width: 100%;
                /* z-index: -999; */
            }
        </style>
        @livewireStyles

        <!-- Scripts -->
        
        <!-- The line below is only needed for old environments like Internet Explorer and Android 4.x -->
        <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=fetch,requestAnimationFrame,Element.prototype.classList,URL"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-dropdown')

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
    <script src="https://d3js.org/d3.v6.min.js"></script>
    @if (Route::currentRouteName() == 'dashboard-perch')
    <script type="text/javascript" src="{{ asset('/js/perch.js') }}"></script> 
    @endif
    @if (Route::currentRouteName() == 'dashboard-fly')
    <script type="text/javascript" src="{{ asset('/js/fly.js') }}"></script> 
    @endif
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.js"></script> 
</html>
