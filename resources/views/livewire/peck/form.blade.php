<x-jet-form-section submit="createPerch">
    <x-slot name="title">
        {{ __('Peck') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Perch allows you to declare issues you believe you have a solution for. If you could protest anywhere in the world, where would it be?') }}
    </x-slot>
    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <div id="chart">
            </div>
                <canvas class="draw" width="350" height="350" style="z-index: 1;"></canvas>
                <canvas class="box grdnt" width="350" height="350" style="margin-top: -350px; pointer-events: none; z-index: -1;"></canvas>
            <div class="bbox"></div>
        </div>
        <div class="col-span-6 sm:col-span-4">
            <div class="perches"><div id="output"></div></div>
        </div>
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