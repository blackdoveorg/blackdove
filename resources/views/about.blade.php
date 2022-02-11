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
                    <a href="/">
                        <img src="{{ asset('img/kallipolis.svg') }}" width="150px"/>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                @auth
                    <a class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-olive focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out" href="{{ route('dashboard-report') }}">
                        Report
                    </a>
                    <a class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-olive focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out" href="{{ route('dashboard-browse') }}">
                        Browse
                    </a>
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
            <a class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out" href="{{ route('dashboard-report') }}">
                Report
            </a>
            <a class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out" href="{{ route('dashboard-browse') }}">
                Browse
            </a>
        @else
            @if (Route::has('register'))
            <a class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out" href="{{ route('register') }}">
                Register
            </a>
            @endif
            <a class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out" href="{{ route('login') }}">
                Login
            </a>
        @endif
            <!-- <a class="tutorial block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">
                Tutorial
            </a> -->
        </div>

        <!-- Responsive Settings Options -->
    </div>
</nav>
            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        About
                    </h2>
                </div>
            </header>
            <!-- Page Content -->
            <main>
                <div class="grid flex grid-cols-1 bg-gray-200 bg-opacity-25 p-6 border-t border-gray-200 md:border-l gap-4">
                    <div class="justify-self-center col-span-1 block bg-white overflow-hidden shadow-xl sm:rounded-lg w-full sm:w-2/3 p-4">
                        <p class="text-2xl m-2">About</p>
                        <p class="m-2">Kallipolis is a project to get people to talk to one another, and to focus on solutions to common problems.</p>
                        <p class="m-2">The intent of this project is to find harmony in an otherwise conflicted political environment. We are convinced that the key to peace is through debate and exposure to a multitude of ideas. Through this process, we believe that individuals from across the political spectrum can cooperate to solve society's most difficult issues.</p>
                    </div>
            </main>
        </div>

        @stack('modals')
    </body>
</html>
