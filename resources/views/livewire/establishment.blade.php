<form class="w-full max-w-lg" wire:submit.prevent="submit">
    <div class="form-group">
        <input type="text" class="form-control" id="latitude" hidden=true wire:model="latitude">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" id="longitude" hidden=true wire:model="longitude">
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
  
    <button type="submit" class="bg-olive text-white py-2 px-4 rounded" id="establish">Establish</button>
</form>