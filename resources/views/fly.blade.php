<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Fly') }}
        </h2>
    </x-slot>

    <div class="bg-gray-200 bg-opacity-25">
        <div id="mapContainer" class="p-6 border-t border-gray-200 md:border-l grid grid-cols-1 wrapper" style="display: flex; flex-direction: column; flex-direction: row;">
            <div class="wrapper" style="flex: 2; display: flex;">
                <div class="wrapper" style="flex: 1 1; width:100%; height: 100%;">
                    <div id="flyMap" wire:ignore="flyMap" class="shadow fly-map self-center min-w-full min-h-full" style="height: 500px;"></div>
                    <div class="overlay-container">
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
                </div>
            </div>
        </div>
        <x-jet-input readonly hidden class="mt-1 block w-full form-input rounded-md shadow-sm" id="ip_latitude" value="{{ geoip()->getLocation()->lat }}" wire:ignore="ip_latitude"/>
        <x-jet-input readonly hidden class="mt-1 block form-input rounded-md shadow-sm" id="ip_longitude" value="{{ geoip()->getLocation()->lon }}" wire:ignore="ip_longitude"/>
    </div>
</x-app-layout>