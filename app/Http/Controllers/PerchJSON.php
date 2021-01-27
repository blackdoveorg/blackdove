<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PerchJSON extends Controller
{
    public function getUserPerchData($id)
    {
        $currentPerch = DB::table('current_perches')->where('user_id', $id)->first();
        if (!empty($currentPerch))
        {
            return $currentPerch;
        }
    }

    public function buildPerchGeoJSON($id)
    {
        $data = $this->getUserPerchData($id);
        // dd($data);
        $perchJSON['type'] = "FeatureCollection";
        $perchJSON['features'] = array();
        if (!empty($data))
        {
            // $json .= "LENGTH = " . count($data);
            $data->longitude = (float) $data->longitude;
            $data->latitude = (float) $data->latitude;
            $thisPerchJSON['type'] = "Feature";
            $thisPerchJSON['properties']['color'] = $data->compass_color;
            $thisPerchJSON['properties']['social-compass'] = $data->social_compass;
            $thisPerchJSON['properties']['economic-compass'] = $data->economic_compass;
            $thisPerchJSON['properties']['issue'] = htmlspecialchars($data->issue);
            $thisPerchJSON['properties']['solution'] = htmlspecialchars($data->solution);
            $thisPerchJSON['geometry']['type'] = "Point";
            $thisPerchJSON['geometry']['coordinates'] = array($data->longitude, $data->latitude);
            $perchJSON['features'][] = $thisPerchJSON;
        }
        return json_encode($perchJSON);
    }

    function perchJSON()
    {
        $id = Auth::user()->id;
        $json = new PerchJSON();
        $json = $this->buildPerchGeoJSON($id);
        return $json;
    }
}
