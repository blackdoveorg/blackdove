<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Fly') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-3 bg-gray-200 bg-opacity-25 p-6 border-t border-gray-200 md:border-l grid-cols-3 gap-4">
        <div class="lg:col-span-2 col-span-3">
            <div id="flyMap" wire:ignore="flyMap" class="shadow col-span-2 self-center min-h-full" style="height: 50px;"></div>
        </div>
        <div class="lg:col-span-1 col-span-3">
            <div id="cy" class="shadow grid col-span-1 min-h-full" style="height: 500px;"></div>
        </div>
    </div>
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
    <x-jet-input readonly hidden class="mt-1 block w-full form-input rounded-md shadow-sm" id="ip_latitude" value="0" wire:ignore="ip_latitude"/>
    <x-jet-input readonly hidden class="mt-1 block form-input rounded-md shadow-sm" id="ip_longitude" value="0" wire:ignore="ip_longitude"/>
    <!-- <x-jet-input readonly hidden class="mt-1 block w-full form-input rounded-md shadow-sm" id="ip_latitude" value="{{ geoip()->getLocation()->lat }}" wire:ignore="ip_latitude"/>
    <x-jet-input readonly hidden class="mt-1 block form-input rounded-md shadow-sm" id="ip_longitude" value="{{ geoip()->getLocation()->lon }}" wire:ignore="ip_longitude"/> -->
</x-app-layout>