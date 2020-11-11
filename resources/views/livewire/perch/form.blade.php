<x-jet-form-section submit="createPerch">
    <x-slot name="title">
        {{ __('Perch') }}
    </x-slot>

    <x-slot name="description">
        {{ __('A Perch is an issue you believe you have a solution for. Think of it as being able to picket for an issue virtually.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <div id="establishmentMap" class="map self-center"></div>
        </div>
        <!-- Hidden Fields !-->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-input class="mt-1 block w-full form-input rounded-md shadow-sm" id="latitude" readonly wire:model.defer="latitude"/>
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-input class="mt-1 block w-full form-input rounded-md shadow-sm" id="longitude" readonly wire:model.defer="longitude"/>
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-input class="mt-1 block w-full form-input rounded-md shadow-sm" id="ip_latitude_temporary" readonly value="{{ geoip()->getLocation()->lat }}" wire:model.defer="ip_latitude"/>
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-input class="mt-1 block w-full form-input rounded-md shadow-sm" id="ip_longitude_temporary" readonly value="{{ geoip()->getLocation()->lon }}" wire:model.defer="ip_longitude"/>
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-input class="mt-1 block w-full form-input rounded-md shadow-sm" id="north_latitude" readonly wire:model.defer="north_latitude"/>
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-input class="mt-1 block w-full form-input rounded-md shadow-sm" id="south_latitude" readonly wire:model.defer="south_latitude"/>
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-input class="mt-1 block w-full form-input rounded-md shadow-sm" id="east_longitude" readonly wire:model.defer="east_longitude"/>
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-input class="mt-1 block w-full form-input rounded-md shadow-sm" id="west_longitude" readonly wire:model.defer="west_longitude"/>
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="issue" value="{{ __('Issue Description') }}" />
            <textarea id="issue" class="mt-1 block w-full form-input rounded-md shadow-sm" wire:model.defer="issue"></textarea>
            <x-jet-input-error for="issue" class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="solution" value="{{ __('Solution Description') }}" />
            <textarea id="solution" class="mt-1 block w-full form-input rounded-md shadow-sm" wire:model.defer="solution"></textarea>
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