<?php

namespace App\Http\Livewire\Perch;

use Illuminate\Support\Facades\Auth;
use App\Models\Perch;
use Livewire\Component;

class Form extends Component
{
    public $latitude;
    public $longitude;
    public $north_latitude;
    public $south_latitude;
    public $east_longitude;
    public $west_longitude;
    public $issue;
    public $solution;
    
    protected $rules = [
        'latitude' => 'required|between:-90, 90',
        'longitude' => 'required|between:-180, 180',
        'north_latitude' => 'required|between:-90, 90',
        'south_latitude' => 'required|between:-90, 90',
        'east_longitude' => 'required|between:-180, 180',
        'west_longitude' => 'required|between:-180, 180',
        'issue' => 'required|max:255',
        'solution' => 'required|max:255',
    ];
    
    public function createPerch()
    {
        $this->validate();
        Perch::create([
            'user_id' => Auth::userId(),
            'latitude' => $this->latitude,
            'longitude' => geoip()->getLocation()->lat,
            'ip_latitude' => geoip()->getLocation()->lon,
            'north_latitude' => $this->north_latitude,
            'south_latitude' => $this->south_latitude,
            'east_longitude' => $this->east_longitude,
            'west_longitude' => $this->west_longitude,
            'cross_distance' => distance($this->north_latitude, $this->east_longitude, $this->south_latitude, $this->west_longitude, 'K'),
            'latitude' => $this->latitude,
            'issue' => $this->issue,
            'solution' => $this->solution,
        ]);
        $this->emit("saved");
        $this->clearFields();  
    }

    private function clearFields()
    {
        $this->issue = '';
        $this->solution = '';
    }

    public function render()
    {

        return view('livewire.perch.form');
    }
}
