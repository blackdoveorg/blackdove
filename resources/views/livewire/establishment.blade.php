<form class="w-full max-w-lg" wire:submit.prevent="submit">
    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
            <label for="latitude">
                Latitude
            </label>
            <input class="form-control" id="latitude"  readonly wire:model="latitude">
        </div>
        <div class="w-full md:w-1/2 px-3">
            <label for="longitude">
                Longitude
            </label>
            <input class="form-control" id="longitude" readonly wire:model="longitude">
        </div>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" id="north_latitude" hidden=true wire:model="north_latitude">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" id="south_latitude" hidden=true wire:model="south_latitude">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" id="east_longitude" hidden=true wire:model="east_longitude">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" id="west_longitude" hidden=true wire:model="west_longitude">
    </div>
    <div class="form-group">
        <textarea class="form-control" id="issue" placeholder="What is the issue?" wire:model="issue"></textarea>
        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
  
    <div class="form-group">
        <textarea class="form-control" id="solution" placeholder="What is the solution?" wire:model="solution"></textarea>
        @error('body') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
  
    <button type="submit" class="btn btn-primary">Protest</button>
</form>