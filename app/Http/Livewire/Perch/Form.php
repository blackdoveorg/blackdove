<?php

namespace App\Http\Livewire\Perch;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Perches;
use Livewire\Component;
use BeyondCode\ServerTiming\Facades\ServerTiming;

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
    public $issue_category;
    public $solution_category;
    public $categories;

    protected $listeners = [
        'set:map-attributes' => 'setMapAttributes'
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
        $this_user_id = Auth::id();

        // Get user data from users table, store it for later use.
        $user_data = DB::table('users')->where('id', '=', $this_user_id)->get()->first();

        // Build the Perch.
        $perch = new Perches();
        $perch->user_id = $this_user_id;
        $perch->latitude = $this->latitude;
        $perch->longitude = $this->longitude;
        ServerTiming::start("GeoIP.");
        $perch->ip_latitude = geoip()->getLocation()->lat;
        $perch->ip_longitude = geoip()->getLocation()->lon;   
        ServerTiming::start("GeoIP."); 
        $perch->north_latitude = $this->north_latitude;
        $perch->south_latitude = $this->south_latitude;
        $perch->east_longitude = $this->east_longitude;
        $perch->west_longitude = $this->west_longitude;
        $perch->cross_distance = $this->cross_distance;
        $perch->ip_issue_distance = $this->ip_issue_distance;
        $perch->issue = $this->issue;
        $perch->solution = $this->solution;
        $perch->issue_category = json_encode($this->issue_category);
        $perch->solution_category = json_encode($this->solution_category);
        $perch->social_compass = $user_data->social_compass;
        $perch->economic_compass = $user_data->economic_compass;
        $perch->compass_color = $user_data->compass_color;
        
        $perch_array['user_id'] = $perch->user_id;
        $perch_array['created_at'] = \Carbon\Carbon::now();
        $perch_array['updated_at'] = \Carbon\Carbon::now();
        $perch_array['latitude'] = $perch->latitude;
        $perch_array['longitude'] = $perch->longitude;
        $perch_array['ip_latitude'] = $perch->ip_latitude;
        $perch_array['ip_longitude'] = $perch->ip_longitude;
        $perch_array['north_latitude'] = $perch->north_latitude;
        $perch_array['south_latitude'] = $perch->south_latitude;
        $perch_array['east_longitude'] = $perch->east_longitude;
        $perch_array['west_longitude'] = $perch->west_longitude;
        $perch_array['cross_distance'] = $perch->cross_distance;
        $perch_array['ip_issue_distance'] = $perch->ip_issue_distance;
        $perch_array['issue'] = $perch->issue;
        $perch_array['solution'] = $perch->solution;
        $perch_array['issue_category'] = $perch->issue_category;
        $perch_array['solution_category'] = $perch->solution_category;
        $perch_array['social_compass'] = $perch->social_compass;
        $perch_array['economic_compass'] = $perch->economic_compass;
        $perch_array['compass_color'] = $perch->compass_color;
        $perch_array['economic_compass'] = $perch->economic_compass;
        $perch_array['compass_color'] = $perch->compass_color;
        // dd($perch);
        // Save the Perch, update the current_perches table, and clear the form.
        ServerTiming::start("Inserting Rows.");
        $perch->save();
        $current_perch_update = DB::table('current_perches')->updateOrInsert([ 'user_id' => $this_user_id ], $perch_array);
        ServerTiming::stop("Inserting Rows.");
        // $dur = ServerTiming::stop("Inserting Rows.")->getElapsedTimeInMs();
        // Livewire emit.
        $this->emit('saved');
        ServerTiming::start("Rendering.");
        $this->render();
        dd(ServerTiming::stop("Rendering."));
        //$this->clearPerch();
    }

    public function mount()
    {
        $this_user_id = Auth::id();
        $current_perch_data = DB::table('current_perches')->where('user_id', '=', $this_user_id)->get()->first();
        if (!empty($current_perch_data))
        {
            $this->issue = $current_perch_data->issue;
            $this->solution = $current_perch_data->solution;
            $this->issue_category = json_decode($current_perch_data->issue_category);
            $this->solution_category = json_decode($current_perch_data->solution_category);
            $this->latitude = $current_perch_data->latitude;
            $this->longitude = $current_perch_data->longitude;
        } else
        {
            $this->ip_latitude = geoip()->getLocation()->lat;
            $this->ip_longitude = geoip()->getLocation()->lon; 
        }
    }

    public function clearPerch()
    {
        $this->latitude = '';
        $this->longitude = '';
        $this->ip_latitude = geoip()->getLocation()->lat;
        $this->ip_longitude = geoip()->getLocation()->lon;    
        $this->north_latitude = '';
        $this->south_latitude = '';
        $this->east_longitude = '';
        $this->west_longitude = '';
        $this->cross_distance = '';
        $this->ip_issue_distance = '';
        $this->issue = '';
        $this->solution = '';
        $this->issue_category = '';
        $this->solution_category = '';
        $this->render();
    }

    public function render()
    {
        return view('livewire.perch.form');
    }
}
