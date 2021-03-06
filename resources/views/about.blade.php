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
                        <svg xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" width="50" height="50" viewBox="0 0 95.450886 96.97414" version="1.1" id="svg2765" inkscape:version="0.92.4 (5da689c313, 2019-01-14)" sodipodi:docname="blackdove_FACE.svg" inkscape:export-xdpi="96" inkscape:export-ydpi="96">
                        <defs id="defs2759">
                            <clipPath clipPathUnits="userSpaceOnUse" id="clipPath5699">
                            <use height="100%" width="100%" id="use5701" xlink:href="#g5690" y="0" x="0"></use>
                            </clipPath>
                            <clipPath clipPathUnits="userSpaceOnUse" id="clipPath7041">
                            <ellipse ry="48.487068" rx="48.62389" cy="124.06976" cx="136.63841" id="ellipse7043" style="display:inline;overflow:visible;fill:#ff0000;fill-opacity:1;stroke:none;stroke-width:0.80000001;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"></ellipse>
                            </clipPath>
                            <clipPath clipPathUnits="userSpaceOnUse" id="clipPath7045">
                            <ellipse ry="48.487068" rx="48.62389" cy="124.06976" cx="136.63841" id="ellipse7047" style="display:inline;overflow:visible;fill:#ff0000;fill-opacity:1;stroke:none;stroke-width:0.80000001;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"></ellipse>
                            </clipPath>
                            <clipPath clipPathUnits="userSpaceOnUse" id="clipPath7049">
                            <ellipse ry="48.487068" rx="48.62389" cy="124.06976" cx="136.63841" id="ellipse7051" style="display:inline;overflow:visible;fill:#ff0000;fill-opacity:1;stroke:none;stroke-width:0.80000001;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"></ellipse>
                            </clipPath>
                            <clipPath clipPathUnits="userSpaceOnUse" id="clipPath7053">
                            <ellipse ry="48.487068" rx="48.62389" cy="124.06976" cx="136.63841" id="ellipse7055" style="display:inline;overflow:visible;fill:#ff0000;fill-opacity:1;stroke:none;stroke-width:0.80000001;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"></ellipse>
                            </clipPath>
                            <clipPath clipPathUnits="userSpaceOnUse" id="clipPath7057">
                            <ellipse ry="48.487068" rx="48.62389" cy="124.06976" cx="136.63841" id="ellipse7059" style="display:inline;overflow:visible;fill:#ff0000;fill-opacity:1;stroke:none;stroke-width:0.80000001;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"></ellipse>
                            </clipPath>
                        </defs>
                        <sodipodi:namedview id="base" pagecolor="#ffffff" bordercolor="#666666" borderopacity="1.0" inkscape:pageopacity="0.0" inkscape:pageshadow="2" inkscape:zoom="0.7" inkscape:cx="182.06818" inkscape:cy="155.8028" inkscape:document-units="mm" inkscape:current-layer="layer1" showgrid="false" fit-margin-top="0" fit-margin-left="0" fit-margin-right="0" fit-margin-bottom="0" inkscape:window-width="1920" inkscape:window-height="1017" inkscape:window-x="1912" inkscape:window-y="-8" inkscape:window-maximized="1" units="px"></sodipodi:namedview>
                        <metadata id="metadata2762">
                            <rdf:rdf>
                            <cc:work rdf:about="">
                                <dc:format>image/svg+xml</dc:format>
                                <dc:type rdf:resource="http://purl.org/dc/dcmitype/StillImage"></dc:type>
                                <dc:title></dc:title>
                            </cc:work>
                            </rdf:rdf>
                        </metadata>
                        <g inkscape:label="Layer 1" inkscape:groupmode="layer" id="layer1" transform="translate(-283.71257,-50.546982)">
                            <path transform="translate(195.69805,-25.035713)" sodipodi:nodetypes="cccccc" id="path11042" d="M 86.473709,124.94051 C -208.24015,-203.90866 284.44349,431.9899 95.531584,159.74583 l 23.836496,-8.55868 21.45287,-1.71174 -19.54594,-22.25257 c -12.25127,-1.40992 -24.419061,-2.73655 -34.801301,-2.28233 z" style="display:inline;fill:#000000;fill-opacity:1;fill-rule:evenodd;stroke:#ffffff;stroke-width:1.81850016;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1" inkscape:connector-curvature="0" clip-path="url(#clipPath7057)"></path>
                            <ellipse transform="translate(195.69805,-25.035713)" id="path11088" style="display:inline;fill:#000000;fill-opacity:1;stroke:none;stroke-width:1.81850016;stroke-miterlimit:4;stroke-dasharray:none" cx="120.28327" cy="138.9951" rx="1.1798469" ry="1.412111" clip-path="url(#clipPath7053)"></ellipse>
                            <ellipse transform="translate(195.69805,-25.035713)" id="path11090" style="display:inline;fill:#fffff7;fill-opacity:1;stroke:none;stroke-width:1.81850016;stroke-miterlimit:4;stroke-dasharray:none" cx="119.01053" cy="137.9212" rx="2.5028331" ry="2.9955399" clip-path="url(#clipPath7049)"></ellipse>
                            <path transform="translate(195.69805,-25.035713)" sodipodi:nodetypes="cccccccccccc" id="path11092" d="m 139.16085,147.46774 1.68549,-7.06055 c 8.27419,0.009 15.96121,-0.33311 13.65252,-6.65709 5.77155,-0.52106 12.74742,-0.35574 9.43877,-6.05191 5.66486,-0.74944 10.55365,-2.28482 10.45007,-8.87613 15.11829,-1.47921 6.17904,-15.09257 -2.02259,-10.48996 -2.65046,-9.742154 -7.27039,-4.39828 -12.13557,2.82422 -3.25863,-6.0998 -6.51726,-0.72286 -9.77587,6.45536 -2.92153,-5.34725 -5.84305,-0.43496 -8.76458,6.45537 -2.60525,-4.79148 -4.77764,-2.92454 -7.83157,7.85734 l -0.51659,8.96387 z" style="display:inline;fill:#808000;fill-opacity:1;fill-rule:evenodd;stroke:#ffffff;stroke-width:1.81850016;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1" inkscape:connector-curvature="0" clip-path="url(#clipPath7045)"></path>
                            <path transform="translate(195.69805,-25.035713)" sodipodi:nodetypes="ccccc" id="path11108" d="m 133.31245,150.33127 -6.1975,13.55127 c -4.26157,2.69887 -6.10072,0.80719 -6.55503,-3.70877 l 4.40975,-9.98513 z" style="display:inline;fill:#808000;fill-opacity:1;fill-rule:evenodd;stroke:#ffffff;stroke-width:1.81850016;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1" inkscape:connector-curvature="0" clip-path="url(#clipPath7041)"></path>
                            <g id="g5692" clip-path="url(#clipPath5699)" transform="translate(-4.7246981,-7.5595243)">
                            <g inkscape:label="Clip" id="g5690"></g>
                            </g>
                        </g>
                        <g inkscape:groupmode="layer" id="layer2" inkscape:label="Layer 2" transform="translate(-88.014523,-75.582695)"></g>
                        </svg>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                @auth
                    <a class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-olive focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out" href="{{ route('dashboard-perch') }}">
                        Perch
                    </a>
                    <a class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-olive focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out" href="{{ route('dashboard-fly') }}">
                        Fly
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
            <a class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out" href="{{ route('dashboard-perch') }}">
                Perch
            </a>
            <a class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out" href="{{ route('dashboard-fly') }}">
                Fly
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
                        <p class="m-2">Black Dove is a project to get people to talk to one another, and to focus on solutions to common problems.</p>
                        <p class="m-2">The intent of this project is to find harmony in an otherwise conflicted political environment. We are convinced that the key to peace is through debate and exposure to a multitude of ideas. Through this process, we believe that individuals from across the political spectrum can cooperate to solve society's most difficult issues.</p>
                    </div>
            </main>
        </div>

        @stack('modals')
    </body>
</html>
