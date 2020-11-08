<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Black Dove</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Overpass:wght@200&display=swap" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- Styles -->
        <style>
            html {
                background-color: #f5f5f5 !important;
                font-family: 'Overpass', sans-serif;
            }
            .logo
            {
                width: 200px;
                margin-top: 50px;
                margin-bottom: 25px;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 items-center sm:pt-0">
            @if (Route::has('login'))
                <div class="fixed top-0 right-0 px-6 py-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                        @endif
                    @endif
                </div>
            @endif

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="md:flex">
                    <div class="md:flex-shrink-0">
                        <center>
                            <img class="logo align-middle" src="{{ asset('img/blackdove.svg') }}" alt="Black Dove"/>
                            <p class="text-4xl break-words">BLACK DOVE</p>
                            <p class="text-2xl break-words">A Party for All.</p>
                        </center>
                    </div>
                    
                </div>
            </div>
        </div>
    </body>
</html>
