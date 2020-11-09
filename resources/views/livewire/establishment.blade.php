<form class="w-full max-w-lg" wire:submit.prevent="submit">
    <div class="form-group">
        <input type="text" class="form-control" id="latitude" readonly hidden wire:model="latitude">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" id="longitude" readonly hidden wire:model="longitude">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" id="ip_latitude" value="{{ geoip()->getLocation()->lat }}" readonly hidden wire:model="latitude">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" id="ip_longitude" value="{{ geoip()->getLocation()->lon }}"  readonly hidden wire:model="longitude">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" id="north_latitude" readonly hidden wire:model="north_latitude">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" id="south_latitude" readonly hidden wire:model="south_latitude">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" id="east_longitude" readonly hidden wire:model="east_longitude">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" id="west_longitude" readonly hidden wire:model="west_longitude">
    </div>
    <div class="form-group">
        <textarea class="form-control" id="issue" placeholder="What is the issue?" maxlength="255" wire:model="issue"></textarea>
        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
  
    <div class="form-group">
        <textarea class="form-control" id="solution" placeholder="What is your solution?" maxlength="255" wire:model="solution"></textarea>
        @error('body') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
  
    <button type="submit" class="bg-olive text-white py-2 px-4 rounded" id="establish">Establish</button>
</form>