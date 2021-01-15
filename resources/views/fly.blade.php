<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Fly') }}
        </h2>
    </x-slot>

    <div>
        <div class="col-span-6 sm:col-span-4">
            <div id="flyMap" wire:ignore="flyMap" class="fly-map self-center"></div>
            <div class="overlay-container">
                <!-- <center>
                    <span class="compass-color"></span><br/>
                    Social: <span class="social-compass"></span>, Economic: <span class="economic-compass"></span>
                </center> -->
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
        <x-jet-input readonly hidden class="mt-1 block w-full form-input rounded-md shadow-sm" id="ip_latitude" value="{{ geoip()->getLocation()->lat }}" wire:ignore="ip_latitude"/>
        <x-jet-input readonly hidden class="mt-1 block form-input rounded-md shadow-sm" id="ip_longitude" value="{{ geoip()->getLocation()->lon }}" wire:ignore="ip_longitude"/>
    </div>
</x-app-layout>