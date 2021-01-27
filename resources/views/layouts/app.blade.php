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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.css" />
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
    <!-- Include Choices JavaScript (latest) -->
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.js"></script>
    <script>
        const issueElement = document.querySelector('.issue-choice');
        // Passing options (with default options)
        const issueChoices = new Choices(issueElement, {
            silent: false,
            renderChoiceLimit: -1,
            maxItemCount: -1,
            addItems: true,
            addItemFilter: null,
            removeItems: true,
            removeItemButton: false,
            editItems: false,
            duplicateItemsAllowed: true,
            delimiter: ',',
            paste: true,
            searchEnabled: true,
            searchChoices: true,
            searchFloor: 1,
            searchResultLimit: 10,
            searchFields: ['label', 'value'],
            position: 'auto',
            resetScrollPosition: true,
            shouldSort: true,
            shouldSortItems: false,
            placeholder: true,
            placeholderValue: null,
            searchPlaceholderValue: null,
            prependValue: null,
            appendValue: null,
            renderSelectedChoices: 'auto',
            loadingText: 'Loading...',
            noResultsText: 'No results found',
            noChoicesText: 'No choices to choose from',
            itemSelectText: 'Press to select',
            addItemText: (value) => {
            return `Press Enter to add <b>"${value}"</b>`;
            },
            maxItemText: (maxItemCount) => {
            return `Only ${maxItemCount} values can be added`;
            },
            valueComparer: (value1, value2) => {
            return value1 === value2;
            },
            classNames: {
            containerOuter: 'choices',
            containerInner: 'choices__inner',
            input: 'choices__input',
            inputCloned: 'choices__input--cloned',
            list: 'choices__list',
            listItems: 'choices__list--multiple',
            listSingle: 'choices__list--single',
            listDropdown: 'choices__list--dropdown',
            item: 'choices__item',
            itemSelectable: 'choices__item--selectable',
            itemDisabled: 'choices__item--disabled',
            itemChoice: 'choices__item--choice',
            placeholder: 'choices__placeholder',
            group: 'choices__group',
            groupHeading: 'choices__heading',
            button: 'choices__button',
            activeState: 'is-active',
            focusState: 'is-focused',
            openState: 'is-open',
            disabledState: 'is-disabled',
            highlightedState: 'is-highlighted',
            selectedState: 'is-selected',
            flippedState: 'is-flipped',
            loadingState: 'is-loading',
            noResults: 'has-no-results',
            noChoices: 'has-no-choices'
            },
            // Choices uses the great Fuse library for searching. You
            // can find more options here: https://github.com/krisk/Fuse#options
            fuseOptions: {
            include: 'score'
            },
            callbackOnInit: null,
            callbackOnCreateTemplates: null
        });
        const solutionElement = document.querySelector('.solution-choice');
        // Passing options (with default options)
        const solutionChoices = new Choices(solutionElement, {
            silent: false,
            renderChoiceLimit: -1,
            maxItemCount: -1,
            addItems: true,
            addItemFilter: null,
            removeItems: true,
            removeItemButton: false,
            editItems: false,
            duplicateItemsAllowed: true,
            delimiter: ',',
            paste: true,
            searchEnabled: true,
            searchChoices: true,
            searchFloor: 1,
            searchResultLimit: 4,
            searchFields: ['label', 'value'],
            position: 'auto',
            resetScrollPosition: true,
            shouldSort: true,
            shouldSortItems: false,
            placeholder: true,
            placeholderValue: null,
            searchPlaceholderValue: null,
            prependValue: null,
            appendValue: null,
            renderSelectedChoices: 'auto',
            loadingText: 'Loading...',
            noResultsText: 'No results found',
            noChoicesText: 'No choices to choose from',
            itemSelectText: 'Press to select',
            addItemText: (value) => {
            return `Press Enter to add <b>"${value}"</b>`;
            },
            maxItemText: (maxItemCount) => {
            return `Only ${maxItemCount} values can be added`;
            },
            valueComparer: (value1, value2) => {
            return value1 === value2;
            },
            classNames: {
            containerOuter: 'choices',
            containerInner: 'choices__inner',
            input: 'choices__input',
            inputCloned: 'choices__input--cloned',
            list: 'choices__list',
            listItems: 'choices__list--multiple',
            listSingle: 'choices__list--single',
            listDropdown: 'choices__list--dropdown',
            item: 'choices__item',
            itemSelectable: 'choices__item--selectable',
            itemDisabled: 'choices__item--disabled',
            itemChoice: 'choices__item--choice',
            placeholder: 'choices__placeholder',
            group: 'choices__group',
            groupHeading: 'choices__heading',
            button: 'choices__button',
            activeState: 'is-active',
            focusState: 'is-focused',
            openState: 'is-open',
            disabledState: 'is-disabled',
            highlightedState: 'is-highlighted',
            selectedState: 'is-selected',
            flippedState: 'is-flipped',
            loadingState: 'is-loading',
            noResults: 'has-no-results',
            noChoices: 'has-no-choices'
            },
            // Choices uses the great Fuse library for searching. You
            // can find more options here: https://github.com/krisk/Fuse#options
            fuseOptions: {
            include: 'score'
            },
            callbackOnInit: null,
            callbackOnCreateTemplates: null
        });
    </script>

    @endif
    @if (Route::currentRouteName() == 'dashboard-fly')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cytoscape/3.17.1/cytoscape.min.js" integrity="sha512-dR5Qb5zIoRodLJCkh0InsAi/uyP1Pd3lMAliXEdv5ol71k2qCwWFS9N18LIGH9MQuAPWu3adPyww5SK2deReog==" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ asset('/js/fly.js') }}"></script> 

    @endif
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.js"></script> 
</html>
