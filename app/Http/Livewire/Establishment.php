<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Establishent;

class Establishment extends Component
{
    public $latitude;
    public $longitude;
    public $ip_latitude;
    public $ip_longitude;
    public $north_latitude;
    public $south_latitude;
    public $east_longitude;
    public $west_longitude;
    public $issue;
    public $solution;
    
    public function submit()
    {
        $validatedData = $this->validate([
            'latitude' => 'required|between:-90,90',
            'longitude' => 'required|between:-180,180',
            'ip_latitude' => 'required|between:-90,90',
            'ip_longitude' => 'required|between:-180,180',
            'north_latitude' => 'required|between:-90,90',
            'south_latitude' => 'required|between:-90,90',
            'east_longitude' => 'required|between:-180,180',
            'west_longitude' => 'required|between:-180,180',
            'issue' => 'required|max:255',
            'solution' => 'required|max:255',
        ]);
  
        Establishent::create($validatedData);
  
        return redirect()->to('/dashboard');
    }

    public function render()
    {
        return view('livewire.establishment');
    }
}
