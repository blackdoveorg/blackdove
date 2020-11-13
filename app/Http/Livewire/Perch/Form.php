<?php

namespace App\Http\Livewire\Perch;

use Illuminate\Support\Facades\Auth;
use App\Models\Perches;
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

    protected $listeners = [
        'set:map-attributes' => 'setMapAttributes',
    ];

    protected $rules = [
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

    public function setMapAttributes($latitude, $longitude, $north_latitude, $south_latitude, $east_longitude, $west_longitude) 
    {
        $this->latitude = (float) $latitude;
        $this->longitude = (float) $longitude;
        $this->ip_latitude = geoip()->getLocation()->lat;
        $this->ip_longitude = geoip()->getLocation()->lon;
        $this->north_latitude = (float) $north_latitude;
        $this->south_latitude = (float) $south_latitude;
        $this->east_longitude = (float) $east_longitude;
        $this->west_longitude = (float) $west_longitude;
        $this->cross_distance = distance($this->north_latitude, $this->east_longitude, $this->south_latitude, $this->west_longitude, 'K');
        $this->ip_issue_distance = distance($this->latitude, $this->longitude, $this->ip_latitude, $this->ip_longitude, 'K');

    }

    public function createPerch()
    {
        
        $this->validate();
        $perch = new Perches();
        $perch->user_id = Auth::id();
        $perch->latitude = $this->latitude;
        $perch->longitude = $this->longitude;
        $perch->ip_latitude = geoip()->getLocation()->lat;
        $perch->ip_longitude = geoip()->getLocation()->lon;    
        $perch->north_latitude = $this->north_latitude;
        $perch->south_latitude = $this->south_latitude;
        $perch->east_longitude = $this->east_longitude;
        $perch->west_longitude = $this->west_longitude;
        $perch->cross_distance = $this->cross_distance;
        $perch->ip_issue_distance = $this->ip_issue_distance;
        $perch->issue = $this->issue;
        $perch->solution = $this->solution;
        $perch->save();

        $this->emit('saved');
    }
    public function saved()
    {
        $this->render();
    }
    public function render()
    {

        return view('livewire.perch.form');
    }
}
