<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use BeyondCode\ServerTiming\Facades\ServerTiming;

class FlyJSON extends Controller
{
    public function getUserFlyData($id)
    {
        $currentFly = DB::table('current_perches')->latest()->limit(5000)->get();
        if (!empty($currentFly))
        {
            return $currentFly;
        }
    }

    public function buildFlyGeoJSON($id)
    {
        $data = $this->getUserFlyData($id);
        $counter = 1;
        $dataCounter = count($data);
        $flyJSON['type'] = "FeatureCollection";
        $flyJSON['features'] = array();
        if (!empty($data))
        {
            foreach ($data as $perch)
            {
                $perch->longitude = (float) $perch->longitude;
                $perch->latitude = (float) $perch->latitude;
                $thisPerchJSON['type'] = "Feature";
                $thisPerchJSON['properties']['color'] = $perch->compass_color;
                $thisPerchJSON['properties']['social-compass'] = $perch->social_compass;
                $thisPerchJSON['properties']['economic-compass'] = $perch->economic_compass;
                $thisPerchJSON['properties']['issue'] = htmlspecialchars($perch->issue);
                $thisPerchJSON['properties']['solution'] = htmlspecialchars($perch->solution);
                $thisPerchJSON['properties']['issue_category'] = json_decode($perch->issue_category);
                $thisPerchJSON['properties']['solution_category'] = json_decode($perch->solution_category);
                $thisPerchJSON['geometry']['type'] = "Point";
                $thisPerchJSON['geometry']['coordinates'] = array($perch->longitude, $perch->latitude);
                $flyJSON['features'][] = $thisPerchJSON;
            }
            return json_encode($flyJSON);
        }
    }

    function flyJSON()
    {
        ServerTiming::start("flyJSON");
        $id = Auth::user()->id;
        $json = new FlyJSON();
        $json = $this->buildFlyGeoJSON($id);
        ServerTiming::stop("flyJSON");
        return $json;
    }
}
