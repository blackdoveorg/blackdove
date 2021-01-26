<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class FlyJSON extends Controller
{
    public function getUserFlyData($id)
    {
        $currentFly = DB::table('current_perches')->limit(5000)->get();
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
            // $json .= "LENGTH = " . count($data);
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
                $thisPerchJSON['properties']['issue_category'] = $perch->issue_category;
                $thisPerchJSON['properties']['solution_category'] = $perch->solution_category;
                $thisPerchJSON['geometry']['type'] = "Point";
                $thisPerchJSON['geometry']['coordinates'] = array($perch->longitude, $perch->latitude);
                $flyJSON['features'][] = $thisPerchJSON;
            }
            return json_encode($flyJSON);
        }
    }

    function flyJSON()
    {
        $id = Auth::user()->id;
        $json = new FlyJSON();
        $json = $this->buildFlyGeoJSON($id);
        return $json;
    }
}
