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
                height: 200px;
                margin-top: 0px;
                margin-bottom: 0px;
            }
            .blackdove {
                font-family: Overpass,system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;
            }
            html, body {
                height: 100%;
                margin: 0;
            }
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
            .cluster-container {
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
            .ol-popup-closer {
                text-decoration: none;
                position: absolute;
                top: 5px;
                right: 5px;
            }
            .compass-color {
                margin: 3px;
                height: 15px;
                width: 15px;
                background-color: #bbb;
                border: 2px solid black;
                border-radius: 50%;
                display: inline-block;
            }
            #cy {
                height: 300px;
                display: block;
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
                        <a href="{{ route('login') }}" class="text-gray-700 underline">Login</a>

                        @if (Route::has('register'))
                            or <a href="{{ route('register') }}" class="text-gray-700 underline">register</a> to contribute.
                        @endif
                    @endif
                </div>
            @endif

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col">
                    <div class="md:flex-shrink-0">
                        <center>
                            <img class="py-4 logo align-middle" src="{{ asset('img/blackdove.svg') }}" alt="Black Dove"/>
                        </center>
                    </div>
                </div>
            </div>          
            <div class="grid grid-cols-3 bg-gray-200 bg-opacity-25 p-6 border-t border-gray-200 md:border-l grid-cols-3 gap-4">
                <div class="lg:col-span-2 col-span-3">
                    <div id="flyMap" wire:ignore="flyMap" class="shadow col-span-2 self-center min-h-full" style="height: 500px;"></div>
                </div>
                <div class="lg:col-span-1 col-span-3">
                    <div id="cy" class="shadow grid col-span-1 min-h-full" style="height: 500px;"></div>
                </div>
            </div>
            <div id="overlay-container" class="overlay-container">
                <a href="#" id="overlay-popup-closer" class="align-right ol-popup-closer">x</a>
                <center>
                    <b>Issue</b><br/>
                    <span class="fly-issue"></span><br/><br/>
                    <b>Solution</b><br/>
                    <span class="fly-solution"></span><br/><br/>
                    <b>Metadata</b><br/>
                    <div class="compass-color"></div><br/>
                    Social: <span class="social-compass"></span>, Economic: <span class="economic-compass"></span>
                </center>
            </div>
            <div id="cluster-container" class="cluster-container">
                <a href="#" id="cluster-popup-closer" class="align-right ol-popup-closer">x</a>
                <center>
                    <b>Data</b><br/>
                    <span class="cluster-data"></span>
                </center>
            </div>
            <x-jet-input readonly hidden class="mt-1 block w-full form-input rounded-md shadow-sm" id="ip_latitude" value="0" wire:ignore="ip_latitude"/>
            <x-jet-input readonly hidden class="mt-1 block form-input rounded-md shadow-sm" id="ip_longitude" value="0" wire:ignore="ip_longitude"/>

        </div>
        <!-- <div id="container" style="width: 100%">
            <canvas id="c" class="flex" style="position: relative;"></canvas>
            <center>
            </center>
        </div>    -->
    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cytoscape/3.17.1/cytoscape.min.js" integrity="sha512-dR5Qb5zIoRodLJCkh0InsAi/uyP1Pd3lMAliXEdv5ol71k2qCwWFS9N18LIGH9MQuAPWu3adPyww5SK2deReog==" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ asset('/js/home.js') }}"></script> 
    <!-- <script type="text/javascript" src="{{ asset('/js/wave.js') }}"></script>  -->
    <script>
    // $( window ).resize(function() {
    //     wave();
    // });  
    </script>
</html>
