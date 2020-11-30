<x-jet-form-section submit="createPerch">
    <x-slot name="title">
        {{ __('Perch') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Perch allows you to declare issues you believe you have a solution for. If you could protest anywhere in the world, where would it be?') }}
    </x-slot>
    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <div id="perchMap" wire:ignore="perchMap" class="map self-center"></div>
            <div class="overlay-container">
                <center>
                    <span class="compass-color"></span><br/>
                    Social: <span class="social-compass"></span>,  Economic: <span class="economic-compass"></span>
                </center>
                <center><b>Issue</b></center>
                <span class="perch-issue"></span><br/>
                <center><b>Solution</b></center>
                <span class="perch-solution"></span>
            </div>
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="issue" value="{{ __('Issue Description') }}" />
            <textarea id="issue" class="mt-1 block w-full w-full form-input rounded-md shadow-sm" rows="3" maxlength="255" wire:model="issue"></textarea>
            <x-jet-input-error for="issue" class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="solution" value="{{ __('Solution Description') }}" />
            <textarea id="solution" class="mt-1 block w-full form-input rounded-md shadow-sm" rows="3" maxlength="255" wire:model="solution"></textarea>
            <x-jet-input-error for="solution" class="mt-2" />
        </div>
        <!-- <div class="col-span-4 grid grid-cols-2 gap-4">
            <div>
                <x-jet-label for="latitude" value="{{ __('Perch Latitude (North/South)') }}" /> -->
                <x-jet-input readonly hidden class="mt-1 block w-full form-input rounded-sm shadow-sm" id="latitude" name="latitude" wire:model="latitude" autocomplete="off"/>
            <!-- </div> 
            <div>
                <x-jet-label for="longitude" value="{{ __('Perch Longitude (East/West)') }}" /> -->
                <x-jet-input readonly hidden class="mt-1 block w-full form-input rounded-md shadow-sm" id="longitude" name="longitude" wire:model="longitude" autocomplete="off"/>
            <!-- </div>
        </div>
        <div class="col-span-4 grid grid-cols-2 gap-4">
            <div>
                <x-jet-label for="issue" value="{{ __('North Latitude') }}" />  -->
                <x-jet-input readonly hidden class="mt-1 block w-full form-input rounded-md shadow-sm" id="north_latitude" wire:model="north_latitude"/>
            <!-- </div>
            <div>
                <x-jet-label for="issue" value="{{ __('South Latitude') }}" /> -->
                <x-jet-input readonly hidden class="mt-1 block w-full form-input rounded-md shadow-sm" id="south_latitude" wire:model="south_latitude"/>
            <!-- </div>
        </div>
        <div class="col-span-4 grid grid-cols-2 gap-4">
            <div>
                <x-jet-label for="issue" value="{{ __('East Longitude') }}" /> -->
                <x-jet-input readonly hidden class="mt-1 block w-full form-input rounded-md shadow-sm" id="east_longitude" wire:model="east_longitude"/>
            <!-- </div>
            <div>
                <x-jet-label for="issue" value="{{ __('West Longitude') }}" /> -->
                <x-jet-input readonly hidden class="mt-1 block w-full form-input rounded-md shadow-sm" id="west_longitude" wire:model="west_longitude"/>
            <!-- </div>
        </div> -->
        <x-jet-input readonly hidden class="mt-1 block w-full form-input rounded-md shadow-sm" id="ip_latitude" value="{{ geoip()->getLocation()->lat }}" wire:ignore="ip_latitude"/>
        <x-jet-input readonly hidden class="mt-1 block form-input rounded-md shadow-sm" id="ip_longitude" value="{{ geoip()->getLocation()->lon }}" wire:ignore="ip_longitude"/>
        <x-jet-input readonly hidden class="mt-1 block form-input rounded-md shadow-sm" id="perch_flag"/>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved" wire:click="saved">
            {{ __('Perched.') }}
        </x-jet-action-message>

        <x-jet-button>
            {{ __('Perch') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>