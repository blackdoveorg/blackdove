<?php

namespace App\Http\Livewire\Perch;

use Illuminate\Support\Facades\Auth;
use App\Models\PerchItem;
use Livewire\Component;

class Form extends Component
{
    public $user_id;
    public $latitude;
    public $longitude;
    public $ip_latitude;
    public $ip_longitude;
    public $north_latitude;
    public $south_latitude;
    public $east_longitude;
    public $west_longitude;
    public $cross_distance;
    public $ip_issue_distance;
    public $issue;
    public $solution;

    protected $rules = [
        'user_id' => 'required',
        'latitude' => 'required|between:-90, 90',
        'longitude' => 'required|between:-180, 180',
        'ip_latitude' => 'required|between:-90, 90',
        'ip_longitude' => 'required|between:-180, 180',
        'north_latitude' => 'required|between:-90, 90',
        'south_latitude' => 'required|between:-90, 90',
        'east_longitude' => 'required|between:-180, 180',
        'west_longitude' => 'required|between:-180, 180',
        'cross_distance' => 'required',
        'ip_issue_distance' => 'required',
        'issue' => 'required|max:255',
        'solution' => 'required|max:255',
    ];

    public function createPerch()
    {
        
        // dd('tets');
        // $this->validate();
        dd($this);
        $item = new PerchItem();
        $item->user_id = Auth::id();
        $item->latitude = 33;
        $item->longitude = $this->longitude;
        
        $item->ip_latitude = geoip()->getLocation()->lat;
        $item->ip_longitude = geoip()->getLocation()->lon;
        
        $item->north_latitude = $this->north_latitude;
        $item->south_latitude = $this->south_latitude;
        $item->east_longitude = $this->east_longitude;
        $item->west_longitude = $this->west_longitude;
        $item->cross_distance = distance($this->north_latitude, $this->east_longitude, $this->south_latitude, $this->west_longitude, 'K');
        $item->issue = $this->issue;
        $item->solution = $this->solution;

        $this->validate();
        
        $item->save();

        $this->emit('saved');
    }

    public function mount()
    {
        // $this->latitude = $latitude;
        // $this->longitude = geoip()->getLocation()->lat;
        $this->user_id = Auth::id();
        $this->ip_latitude = geoip()->getLocation()->lat;
        $this->ip_longitude = geoip()->getLocation()->lon;
        // $this->north_latitude = geoip()->getLocation()->lat;
        // $this->south_latitude = geoip()->getLocation()->lat;
        // $this->east_longitude = geoip()->getLocation()->lat;
        // $this->west_longitude = geoip()->getLocation()->lat;
        $this->cross_distance = distance($this->north_latitude, $this->east_longitude, $this->south_latitude, $this->west_longitude, 'K');
        $this->ip_issue = distance($this->latitude, $this->longitude, $this->ip_latitude, $this->ip_longitude, 'K');
        // $this->issue = geoip()->getLocation()->lat;
        // $this->solution = geoip()->getLocation()->lat;
    }
    public function render()
    {

        return view('livewire.perch.form');
    }
}
