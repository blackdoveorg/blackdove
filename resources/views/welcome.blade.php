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
        @livewireStyles
        
        <!-- Scripts -->
        
        <!-- The line below is only needed for old environments like Internet Explorer and Android 4.x -->
        <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=fetch,requestAnimationFrame,Element.prototype.classList,URL"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.js"></script>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <style>
            
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <nav wire:id="OlkDchdyqKNfSb7pMPVn" wire:initial-data="{&quot;fingerprint&quot;:{&quot;id&quot;:&quot;OlkDchdyqKNfSb7pMPVn&quot;,&quot;name&quot;:&quot;navigation-dropdown&quot;,&quot;locale&quot;:&quot;en&quot;},&quot;effects&quot;:{&quot;listeners&quot;:[&quot;refresh-navigation-dropdown&quot;]},&quot;serverMemo&quot;:{&quot;children&quot;:[],&quot;errors&quot;:[],&quot;htmlHash&quot;:&quot;6317f330&quot;,&quot;data&quot;:[],&quot;dataMeta&quot;:[],&quot;checksum&quot;:&quot;2d0f62cc8d0b3f971291ca58679108f99856aaaf848abbe72919dde09b046f4e&quot;}}" x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="">
                        <img src="{{ asset('img/kallipolis.svg') }}" width="150px"/>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                @auth
                @else
                    @if (Route::has('register'))
                    <a class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-olive focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out" href="{{ route('register') }}">
                        Register
                    </a>
                    @endif
                    <a class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-olive focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out" href="{{ route('login') }}">
                        Login
                    </a>
                @endif
                    <a class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-olive focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out" href="{{ route('about') }}">
                        About
                    </a>
                    <!-- <a class="tutorial inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-olive focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                        Tutorial
                    </a> -->
                </div>
            </div>

            <!-- Settings Dropdown -->
        
            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
        @auth
        @else
            @if (Route::has('register'))
            <a class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out" href="{{ route('register') }}">
                Register
            </a>
            @endif
            <a class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out" href="{{ route('login') }}">
                Login
            </a>
            <a class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out" href="{{ route('about') }}">
                About
            </a>
        @endif
            <!-- <a class="tutorial block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">
                Tutorial
            </a> -->
        </div>

        <!-- Responsive Settings Options -->
    </div>
</nav>
            <!-- Page Content -->
            <main>
                <div class="grid flex grid-cols-6 bg-gray-200 bg-opacity-25 p-6 border-t border-gray-200 md:border-l gap-4">
                    <div class="col-span-6 block justify-self-center text-center col-span-1 block bg-white overflow-hidden shadow-xl sm:rounded-lg w-full sm:w-2/3 p-4">
                        <p class="text-3xl text-center m-3">Connect the elected with the electorate.</p>
                        <p class="text-xl text-center m-1">Explore important issues, and modernize political discourse together.</p>
                    </div>
                    <div class="col-span-6 block sm:hidden">
                        <button type="button" id="jumpBottom" onclick="jumpBetween('#jumpBottom', '#cy')" class="w-full justify-self-center items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-800 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">View Relationship Data</button>
                    </div>
                    <div class="lg:col-span-1">
                    </div>
                    <div class="lg:col-span-2 col-span-6">
                        <div id="browseMap" wire:ignore="browseMap" class="shadow col-span-2 self-center min-h-full" style="height: 500px;"></div>
                    </div>
                    <div class="lg:col-span-2 col-span-6">
                        <div id="cy" class="shadow grid col-span-1 min-h-full" style="height: 500px;"></div>
                    </div>
                    <div class="lg:col-span-1">
                    </div>
                    <div class="col-span-6 block sm:hidden">
                        <button type="button" id="jumpTop" onclick="jumpBetween('#jumpTop', '#jumpBottom')"  class="w-full justify-self-center items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-800 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">View Map Data</button>
                    </div>
                    <div class="col-span-6 block justify-self-center text-center col-span-1 block bg-white overflow-hidden shadow-xl sm:rounded-lg w-full sm:w-2/3 p-4">
                        <p class="text-3xl text-center m-3">How does it work?</p>
                        <p class="text-xl text-center m-1">Register, click on a map, type up an issue, a solution, and then categorize your responses. We share that data and provide a platform for the exchange of ideas.</p>
                        <p class="text-3xl text-center m-3">Contribute to the community.</p>
                        <p class="text-xl text-center m-1">Join us and provide an issue and solution for a location that matters to you.</p>
                        <a href="{{ route('register') }}" class="m-auto"><button type="button" class="m-2 justify-self-center items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-800 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">Register</button></a>
                    </div>
                </div>
                <div id="overlay-container" class="overlay-container">
                    <a href="#" id="overlay-popup-closer" class="align-right ol-popup-closer">Close</a>
                    <center>
                        <b>Issue</b><br/>
                        <span class="browse-issue"></span><br/><br/>
                        <b>Solution</b><br/>
                        <span class="browse-solution"></span><br/><br/>
                        <b>Metadata</b><br/>
                        <div class="compass-color"></div><br/>
                        Social: <span class="social-compass"></span>, Economic: <span class="economic-compass"></span>
                    </center>
                </div>
                <div id="cluster-container" class="cluster-container">
                    <a href="#" id="cluster-popup-closer" class="align-right ol-popup-closer">Close</a>
                    <center>
                        <b>Data</b><br/>
                        <span class="cluster-data"></span>
                    </center>
                </div>
                <input  class="form-input rounded-md shadow-sm mt-1 block w-full form-input rounded-md shadow-sm" readonly="readonly" hidden="hidden" id="ip_latitude" value="0" wire:ignore="ip_latitude">
                <input  class="form-input rounded-md shadow-sm mt-1 block form-input rounded-md shadow-sm" readonly="readonly" hidden="hidden" id="ip_longitude" value="0" wire:ignore="ip_longitude">
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@2.0.0/dist/tf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cytoscape/3.17.1/cytoscape.min.js" integrity="sha512-dR5Qb5zIoRodLJCkh0InsAi/uyP1Pd3lMAliXEdv5ol71k2qCwWFS9N18LIGH9MQuAPWu3adPyww5SK2deReog==" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ asset('js/home.js') }}"></script> 
    <script src="{{ asset('js/interface.js') }}"></script>
    <script src="{{ asset('js/path.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.js"></script> 
</html>
