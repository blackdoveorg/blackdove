<x-jet-form-section submit="createReport">
    <x-slot name="title">
        {{ __('Peck') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Report allows you to declare issues you believe you have a solution for.') }}
    </x-slot>
    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <div id="chart" class="box" style="width: 400px;">
        </div>
        <div class="col-span-6 sm:col-span-4">
            <div class="reports"><div id="output"></div></div>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved" wire:click="saved">
            {{ __('Reported.') }}
        </x-jet-action-message>

        <x-jet-button>
            {{ __('Report') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>