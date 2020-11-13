<x-jet-form-section submit="createPerch">
    <x-slot name="title">
        {{ __('Perch') }}
    </x-slot>

    <x-slot name="description">
        {{ __('A Perch is an issue you believe you have a solution for. Think of it as being able to picket for an issue virtually.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <div id="establishmentMap" wire:ignore="establishmentMap" class="map self-center"></div>
        </div>
        <!-- Hidden Fields !-->
        <x-jet-input readonly hidden class="mt-1 block w-full form-input rounded-md shadow-sm" id="latitude" name="latitude" wire:ignore="latitude" autocomplete="off"/>
        <x-jet-input readonly hidden class="mt-1 block w-full form-input rounded-md shadow-sm" id="longitude" name="longitude" wire:ignore="longitude" autocomplete="off"/>
        <x-jet-input readonly hidden class="mt-1 block w-full form-input rounded-md shadow-sm" id="ip_latitude" value="{{ geoip()->getLocation()->lat }}" wire:ignore="ip_latitude"/>
        <x-jet-input readonly hidden class="mt-1 block w-full form-input rounded-md shadow-sm" id="ip_longitude" value="{{ geoip()->getLocation()->lon }}" wire:ignore="ip_longitude"/>
        <x-jet-input readonly hidden class="mt-1 block w-full form-input rounded-md shadow-sm" id="north_latitude" wire:ignore="north_latitude"/>
        <x-jet-input readonly hidden class="mt-1 block w-full form-input rounded-md shadow-sm" id="south_latitude" wire:ignore="south_latitude"/>
        <x-jet-input readonly hidden class="mt-1 block w-full form-input rounded-md shadow-sm" id="east_longitude" wire:ignore="east_longitude"/>
        <x-jet-input readonly hidden class="mt-1 block w-full form-input rounded-md shadow-sm" id="west_longitude" wire:ignore="west_longitude"/>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="issue" value="{{ __('Issue Description') }}" />
            <textarea id="issue" class="mt-1 block w-full form-input rounded-md shadow-sm" wire:model="issue"></textarea>
            <x-jet-input-error for="issue" class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="solution" value="{{ __('Solution Description') }}" />
            <textarea id="solution" class="mt-1 block w-full form-input rounded-md shadow-sm" wire:model="solution"></textarea>
            <x-jet-input-error for="solution" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Perched.') }}
        </x-jet-action-message>

        <x-jet-button>
            {{ __('Perch') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>