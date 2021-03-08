<x-jet-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Member Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your information for your Black Dove account. By filling out your profile, we are able to use the information for data analysis and visualization. Different features will display colors which indicate the political leanings of others.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            wire:model="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-jet-label for="photo" value="{{ __('Photo') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview">
                    <span class="block rounded-full w-20 h-20"
                          x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-jet-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </x-jet-secondary-button>
                @endif

                <x-jet-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Name') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autocomplete="name" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="email" value="{{ __('Email') }}" />
            <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" />
            <x-jet-input-error for="email" class="mt-2" />
        </div>

        

        
            <div class="col-span-6 sm:col-span-4">
                <h3 class="text-lg font-medium text-gray-900">
                        {{ __('This section sets your economic and social leanings.') }}
                </h3>

                <div class="mt-3 max-w-xl text-sm text-gray-600">
                    <p>
                    {!! '<a href="https://www.politicalcompass.org/test" target="_blank">The Political Compass</a> identifies your economic and social leanings on a scale of -10 to 10. The lower values being more liberal, and the higher values being more conservative. See the <a href="https://www.politicalcompass.org/crowdchart?Bush=6.0%2C4.0&Castro=-5.0%2C3.0&China=-2.0%2C5.0&Chomsky=-8.0%2C-10.0&Friedman=5.0%2C-3.0&Gandhi=-6.0%2C-3.0&Hitler=3.0%2C9.0&Jefferson=2.0%2C-4.0&Johnson=10.0%2C-2.0&Lenin=-10.0%2C3.0&Luxemburg=-10.0%2C-2.0&Mandela=-6.0%2C-5.0&Mao=-10.0%2C5.0&Marxism=-10.0%2C-6.0&Mugabe=-5.0%2C6.0&Obama=3.0%2C2.0&Pakistan=-3.0%2C2.0&Paul=9.0%2C-4.0&Pinochet=10.0%2C10.0&Proudhon=0.0%2C-10.0&Rand=10.0%2C-7.0&Reagan=8.0%2C7.0&Rothbard=9.0%2C-9.0&Rucker=-4.0%2C-10.0&Russia=1.0%2C4.0&Sanders=-5.0%2C0.0&Saudi=3.0%2C7.0&Stalin=-8.0%2C9.0&Stein=-3.0%2C-2.0&Trotsky=-10.0%2C0.0&Trump=6.0%2C6.0&Vietnam=-8.0%2C2.0&ec=1&name=Washington&soc=-2" target="_blank">Crowd Chart</a> that shows well known political figures. As your views change, update this field.' !!}
                    </p>
                </div>
            </div>
            <!-- Economic Value -->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="economic_compass" value="{{ __('Economic Value') }}" />
                <x-jet-input id="economic_compass" type="number" min="-10" max="10" step="0.01" class="mt-1 block w-full" wire:model.defer="state.economic_compass" autocomplete="economic_compass" />
                <x-jet-input-error for="economic_compass" class="mt-2" />
            </div>

            <!-- Social Value -->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="social_compass" value="{{ __('Social Value') }}" />
                <x-jet-input id="social_compass" type="number" min="-10" max="10" step="0.01" class="mt-1 block w-full" wire:model.defer="state.social_compass" autocomplete="social_compass" />
                <x-jet-input-error for="social_compass" class="mt-2" />
            </div>
                
        <!-- Compass Color Value -->
        <x-jet-input id="compass_color" type="text" wire:model.defer="state.compass_color" autocomplete="compass_color" hidden />
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>