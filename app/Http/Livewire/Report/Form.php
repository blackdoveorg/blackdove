<?php

namespace App\Http\Livewire\Report;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Reports;
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
    public $compass_color;

    protected $listeners = [
        'set:map-attributes' => 'setMapAttributes'
    ];

    protected $rules = [
        'latitude' => 'required|between:-90, 90|not_in:0',
        'longitude' => 'required|between:-180, 180|not_in:0',
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
        'issue_category' => 'required',
        'solution_category' => 'required',
    ];

    protected $messages = [
        'latitude.not_in' => 'Please provide a location for your Report.',
        'issue_category.required' => 'Please provide at least one category for the identified issue.',
        'solution_category.required' => 'Please provide at least one category for the identified solution.',
    ];

    public function setMapAttributes($latitude, $longitude, $north_latitude, $south_latitude, $east_longitude, $west_longitude) 
    {
        $this->latitude = (float) $latitude;
        $this->longitude = (float) $longitude;
        $this->ip_latitude = session('geoip')->lat;
        $this->ip_longitude = session('geoip')->lon;
        $this->north_latitude = (float) $north_latitude;
        $this->south_latitude = (float) $south_latitude;
        $this->east_longitude = (float) $east_longitude;
        $this->west_longitude = (float) $west_longitude;
        $this->cross_distance = distance($this->north_latitude, $this->east_longitude, $this->south_latitude, $this->west_longitude, 'K');
        $this->ip_issue_distance = distance($this->latitude, $this->longitude, $this->ip_latitude, $this->ip_longitude, 'K');
    }

    public function createReport()
    {
        $this->validate();

        $this_user_id = Auth::id();
        // Get user data from users table, store it for later use.
        $user_data = DB::table('users')->where('id', '=', $this_user_id)->get()->first();

        // Build the Report.
        $report = new Reports();
        $report->user_id = $this_user_id;
        $report->latitude = $this->latitude;
        $report->longitude = $this->longitude;
        $report->ip_latitude = session('geoip')->lat;
        $report->ip_longitude = session('geoip')->lon;   
        $report->north_latitude = $this->north_latitude;
        $report->south_latitude = $this->south_latitude;
        $report->east_longitude = $this->east_longitude;
        $report->west_longitude = $this->west_longitude;
        $report->cross_distance = $this->cross_distance;
        $report->ip_issue_distance = $this->ip_issue_distance;
        $report->issue = $this->issue;
        $report->solution = $this->solution;
        $report->issue_category = json_encode($this->issue_category);
        $report->solution_category = json_encode($this->solution_category);
        $report->social_compass = $user_data->social_compass;
        $report->economic_compass = $user_data->economic_compass;
        $report->compass_color = $user_data->compass_color;
        
        $report_array['user_id'] = $report->user_id;
        $report_array['created_at'] = \Carbon\Carbon::now();
        $report_array['updated_at'] = \Carbon\Carbon::now();
        $report_array['latitude'] = $report->latitude;
        $report_array['longitude'] = $report->longitude;
        $report_array['ip_latitude'] = $report->ip_latitude;
        $report_array['ip_longitude'] = $report->ip_longitude;
        $report_array['north_latitude'] = $report->north_latitude;
        $report_array['south_latitude'] = $report->south_latitude;
        $report_array['east_longitude'] = $report->east_longitude;
        $report_array['west_longitude'] = $report->west_longitude;
        $report_array['cross_distance'] = $report->cross_distance;
        $report_array['ip_issue_distance'] = $report->ip_issue_distance;
        $report_array['issue'] = $report->issue;
        $report_array['solution'] = $report->solution;
        $report_array['issue_category'] = $report->issue_category;
        $report_array['solution_category'] = $report->solution_category;
        $report_array['social_compass'] = $report->social_compass;
        $report_array['economic_compass'] = $report->economic_compass;
        $report_array['compass_color'] = $report->compass_color;
 
        // Save the Report, update the current_reportes table, and clear the form.
        $report->save();
        $current_report_update = DB::table('current_reports')->updateOrInsert([ 'user_id' => $this_user_id ], $report_array);

        $this->emit('saved');
        $this->render();
    }

    public function mount()
    {
        $this_user_id = Auth::id();
        $user_data = DB::table('users')->where('id', '=', $this_user_id)->get()->first();
        $current_report_data = DB::table('current_reports')->where('user_id', '=', $this_user_id)->get()->first();
        if (!empty($current_report_data))
        {
            $this->issue = $current_report_data->issue;
            $this->solution = $current_report_data->solution;
            $this->issue_category = json_decode($current_report_data->issue_category);
            $this->solution_category = json_decode($current_report_data->solution_category);
            $this->latitude = $current_report_data->latitude;
            $this->longitude = $current_report_data->longitude;
            $this->compass_color = $user_data->compass_color;
        } else
        {
            $this->latitude = '';
            $this->longitude = '';
            $this->compass_color = $user_data->compass_color;
            $this->ip_latitude = session('geoip')->lat;
            $this->ip_longitude = session('geoip')->lon; 
        }
    }

    public function render()
    {
        return view('livewire.report.form');
    }
}
