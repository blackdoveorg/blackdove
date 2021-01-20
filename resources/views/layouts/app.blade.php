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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cytoscape/3.17.1/cytoscape.min.js" integrity="sha512-dR5Qb5zIoRodLJCkh0InsAi/uyP1Pd3lMAliXEdv5ol71k2qCwWFS9N18LIGH9MQuAPWu3adPyww5SK2deReog==" crossorigin="anonymous"></script>
    <script>
    var cy = cytoscape({

    container: document.getElementById('cy'), // container to render in

    elements: {
						nodes: [
							{ data: { id: 'v1', weight: 1} },
							{ data: { id: 'v2', weight: 2} },
							{ data: { id: 'v3', weight: 3} },
							{ data: { id: 'v4', weight: 4} },
							{ data: { id: 'v5', weight: 5} },
							{ data: { id: 'v6', weight: 20} },
							{ data: { id: 'v7', weight: 7} }
						],
						edges: [
							{ data: { source: 'v1', target: 'v2', directed: 'false', width: 5} },
							{ data: { source: 'v1', target: 'v4', directed: 'false', width: 2} },
							{ data: { source: 'v1', target: 'v5', directed: 'false', width: 5} },
							{ data: { source: 'v2', target: 'v4', directed: 'false', width: 5} },
							{ data: { source: 'v2', target: 'v6', directed: 'false', width: 5} },
							{ data: { source: 'v3', target: 'v4', directed: 'false', width: 5} },
							{ data: { source: 'v3', target: 'v7', directed: 'false', width: 1} },
							{ data: { source: 'v4', target: 'v5', directed: 'false', width: 5} },
							{ data: { source: 'v4', target: 'v7', directed: 'false', width: 15} },
							{ data: { source: 'v5', target: 'v6', directed: 'false', width: 5} },
							{ data: { source: 'v6', target: 'v7', directed: 'false', width: 5} },
							{ data: { source: 'v6', target: 'v3', directed: 'false', width: 35} }
						]
					},

    style: [ // the stylesheet for the graph
    {
        selector: 'node',
        style: {
        'background-color': '#666',
        'label': 'data(id)'
        }
    },

    {
        selector: 'edge',
        style: {
        'width': 'data(width)',
        'line-color': '#ccc',
        'target-arrow-color': '#ccc',
        'target-arrow-shape': 'triangle',
        'curve-style': 'haystack'
        }
    }
    ],

    layout: {
    name: 'grid',
    rows: 1
    }

    });
    var layout = cy.layout({
    name: 'circle'
    });

    layout.run();
    $(window).resize(function(){
        fixContentHeight();
    });
    </script>
    @endif
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.js"></script> 
</html>
