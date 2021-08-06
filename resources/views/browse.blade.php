<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Browse') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-3 bg-gray-200 bg-opacity-25 p-6 border-t border-gray-200 md:border-l grid-cols-3 gap-4">
        <div id="jumpBottom" class="col-span-3 block sm:hidden">
            <button type="button" id="jumpBottom" onclick="jumpBetween('#jumpBottom', '#jumpTop', 'bottom')" class="w-full justify-self-center items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-800 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">View Relationship Data</button>
        </div>
        <div class="lg:col-span-2 col-span-3">
            <div id="browseMap" wire:ignore="browseMap" class="shadow col-span-2 self-center min-h-full" style="height: 500px;"></div>
        </div>
        <div class="lg:col-span-1 col-span-3">
            <div id="cy" class="shadow grid col-span-1 min-h-full" style="height: 500px;"></div>
        </div>
        <div id="jumpTop" class="col-span-3 block sm:hidden">
            <button type="button" id="jumpTop" onclick="jumpBetween('#jumpTop', 'nav', 'top')"  class="w-full justify-self-center items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-800 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">View Map Data</button>
        </div>
    </div>
    <div id="overlay-container" class="overlay-container">
        <a href="#" id="overlay-popup-closer" class="align-right ol-popup-closer">x</a>
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
        <a href="#" id="cluster-popup-closer" class="align-right ol-popup-closer">x</a>
        <center>
            <b>Data</b><br/>
            <span class="cluster-data"></span>
        </center>
    </div>
    <x-jet-input readonly hidden class="mt-1 block w-full form-input rounded-md shadow-sm" id="ip_latitude" value="{{ session('geoip')->lat }}" wire:ignore="ip_latitude"/>
    <x-jet-input readonly hidden class="mt-1 block form-input rounded-md shadow-sm" id="ip_longitude" value="{{ session('geoip')->lon }}" wire:ignore="ip_longitude"/>
</x-app-layout>