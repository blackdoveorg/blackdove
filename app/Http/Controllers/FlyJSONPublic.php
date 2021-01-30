<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class FlyJSONPublic extends Controller
{
    public function getUserFlyData()
    {
        $currentFly = DB::table('current_perches')->limit(1000)->get();
        if (!empty($currentFly))
        {
            return $currentFly;
        }
    }

    public function buildFlyGeoJSON()
    {
        $data = $this->getUserFlyData();
        $counter = 1;
        $dataCounter = count($data);
        $flyJSONPublic['type'] = "FeatureCollection";
        $flyJSONPublic['features'] = array();
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
                $flyJSONPublic['features'][] = $thisPerchJSON;
            }
            return json_encode($flyJSONPublic);
        }
    }

    function flyJSONPublic()
    {
        $json = new FlyJSON();
        $json = $this->buildFlyGeoJSON();
        return $json;
    }
}
