<x-jet-form-section submit="createReport">
    <x-slot name="title">
        {{ __('Report') }}
    </x-slot>

    <x-slot name="description">
        <div class="m-4" wire:ignore id="instructions"></div>
    </x-slot>
    <x-slot name="form" >
        <div id="jumpBottom" class="col-span-12 block sm:hidden">
            <button type="button" id="jumpBottom" onclick="jumpBetween('#jumpBottom', '#jumpTop', 'bottom')" class="w-full justify-self-center items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-800 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">Go to Issue</button>
        </div>
        <div class="col-span-12">
            <x-jet-label for="map" value="{{ __('Location') }}" />
            <div id="reportMap" wire:ignore="reportMap" class="map shadow self-center"></div>
            <x-jet-input-error for="latitude" class="mt-2" />
            <div class="overlay-container">
                <!-- <center>
                    <span class="compass-color"></span><br/>
                    Social: <span class="social-compass"></span>, Economic: <span class="economic-compass"></span>
                </center> -->
                <center>
                    <b>Issue</b><br/>
                    <span class="report-issue"></span><br/><br/>
                    <b>Solution</b><br/>
                    <span class="report-solution"></span><br/><br/>
                    <b>Metadata</b><br/>
                    <span class="report-metadata"></span>
                    <div class="compass-color"></div><br/>
                    Social: <span class="social-compass"></span>, Economic: <span class="economic-compass"></span>
                </center>
            </div>
        </div>
        <div id="jumpTop" class="col-span-12 block sm:hidden">
            <button type="button" id="jumpTop" onclick="jumpBetween('#jumpTop', '#jumpBottom', 'top')"  class="w-full justify-self-center items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-800 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">Go to Map</button>
        </div>
        <div class="col-span-12 grid gap-.5">
            <x-jet-label for="issue" value="{{ __('Issue Description') }}" />
            <textarea placeholder="What are the issues in your area?" id="issue" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" rows="3" maxlength="255" wire:model="issue"></textarea>
            <x-jet-input-error for="issue" class="mt-2" />
        </div>
        <div class="col-span-12 grid gap-.5">
            <!-- <x-jet-label for="issue_category" class="py-1" value="{{ __('Issue Categories') }}" /> -->
            <x-input.selectmultiple wire:model="issue_category" prettyname="issue_category" :options="$categories->pluck('category', 'id')->toArray()" selected="{{ json_encode($this->issue_category, TRUE)}}"/>
            <x-jet-input-error for="issue_category" class="mt-2" />
        </div>
        <div class="col-span-12 grid gap-.5">
            <x-jet-label for="solution" value="{{ __('Solution Description') }}" />
            <textarea placeholder="How do you propose we these issues?" id="solution" class="mt-1 block w-full form-input rounded-md shadow-sm" rows="3" maxlength="255" wire:model="solution"></textarea>
            <x-jet-input-error for="solution" class="mt-2" />
        </div>
        <div class="col-span-12 grid gap-.5">
            <!-- <x-jet-label for="solution_category" class="py-1" value="{{ __('Solution Categories') }}" />  -->
            <x-input.selectmultiple wire:model="solution_category" prettyname="solution_category" :options="$categories->pluck('category', 'id')->toArray()" selected="{{ json_encode($this->solution_category, TRUE) }}"/>
            <x-jet-input-error for="solution_category" class="mt-2" />
        </div>
        <div wire:ignore class="col-span-12 grid gap-.5">
            <div id="cy" class="shadow grid col-span-1 min-h-full" style="height: 200px;"></div>
        </div>
        <!-- <div class="col-span-4 grid grid-cols-2 gap-4">
            <div>
                <x-jet-label for="latitude" value="{{ __('Report Latitude (North/South)') }}" /> -->
                <x-jet-input readonly hidden class="mt-1 block w-full form-input rounded-sm shadow-sm" id="latitude" name="latitude" wire:model="latitude" autocomplete="off"/>
            <!-- </div> 
            <div>
                <x-jet-label for="longitude" value="{{ __('Report Longitude (East/West)') }}" /> -->
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
        <x-jet-input readonly hidden class="mt-1 block w-full form-input rounded-md shadow-sm" id="ip_latitude" value="{{ session('geoip')->lat }}" wire:ignore="ip_latitude"/>
        <x-jet-input readonly hidden class="mt-1 block form-input rounded-md shadow-sm" id="ip_longitude" value="{{ session('geoip')->lon }}" wire:ignore="ip_longitude"/>
        <div class="col-span-12 grid gap-.5">
            <x-jet-input readonly hidden wire:ignore class="mt-1 block w-full form-input rounded-md shadow-sm" id="compass_color" name="compass_color" wire:model="compass_color"/>
        </div>
        <!-- <a href="/category" class="col-span-12 text-xs p-0" target="_blank">Category not listed? Propose one.</a> -->
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