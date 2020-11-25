<x-jet-form-section submit="createPerch">
    <x-slot name="title">
        {{ __('Peck') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Perch allows you to declare issues you believe you have a solution for. If you could protest anywhere in the world, where would it be?') }}
    </x-slot>
    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <canvas id="box" class="grdnt"></canvas>
            <div id="output"></div>
        </div>
        <div class="col-span-6 sm:col-span-4">
            <div class="perches"><div>
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