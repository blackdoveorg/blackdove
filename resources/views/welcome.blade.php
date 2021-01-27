<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Black Dove</title>

        
        <!-- Styles -->
        <style>
            .logo
            {
                width: 200px;
                margin-top: 50px;
                margin-bottom: 25px;
            }
        </style>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=fetch,requestAnimationFrame,Element.prototype.classList,URL"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
        <!-- Fonts -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 grid grid-cols-1 items-center sm:pt-0">
            @if (Route::has('login'))
                <div class="fixed top-0 right-0 px-6 py-4">
                    @auth
                        <a href="{{ url('/nest') }}" class="text-sm text-gray-700 underline">Nest</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                        @endif
                    @endif
                </div>
            @endif

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col">
                    <div class="md:flex-shrink-0">
                        <center>
                            <img class="logo align-middle" src="{{ asset('img/blackdove.svg') }}" alt="Black Dove"/>
                            <p class="text-5xl break-words" style="font-family: 'Cooper Black', sans-serif;">BLACK DOVE</p>
                            <p class="text-3xl break-words" style="font-family: 'Cooper Black', sans-serif;">GRASSROOTS GOVERNMENT</p>
                        </center>
                    </div>
                </div>
            </div>
            <div id="container" style="width: 100%">
                <canvas id="c" class="flex" style="position: relative;"></canvas>
                <center>
                </center>
            </div>
        </div>
        
    </body>
    <script src="{{ asset('js/wave.js') }}"></script>
    <script>
    $( window ).resize(function() {
        wave();
    });
    </script>
</html>
