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
                <center><b>Issue</b></center>
                <span class="fly-issue"></span><br/>
                <center><b>Solution</b></center>
                <span class="fly-solution"></span>
            </div>
        </div>
    </div>
</x-app-layout>