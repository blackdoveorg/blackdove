<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        if (!empty($data))
        {
            $data->longitude = (float) $data->longitude;
            $data->latitude = (float) $data->latitude;
            $point = new \GeoJson\Geometry\Point([$data->longitude, $data->latitude]);
            $point->test = 'test';
            // $point = new \GeoJson\Geometry\MultiPolygon([$data->longitude, $data->latitude]);
            // $json = json_encode($point);
            $json = "{
            \"type\": \"FeatureCollection\",
            \"features\": [
                {
                    \"type\": \"Feature\",
                    \"properties\": {
                        \"color\": \"#" . $data->compass_color . "\",
                        \"social-compass\": \"" . $data->social_compass . "\",
                        \"economic-compass\": \"" . $data->economic_compass . "\",
                        \"issue\": \"" . htmlspecialchars($data->issue) . "\",
                        \"solution\": \"" . htmlspecialchars($data->solution) . "\"
                    },
                    \"geometry\": {
                        \"type\": \"Point\",
                        \"coordinates\": [
                            " . $data->longitude . ",
                            " . $data->latitude . "
                        ]
                    }
                },
                {
                \"type\": \"Feature\",
                \"properties\": {},
                \"geometry\": {
                    \"type\": \"Polygon\",
                    \"coordinates\": [
                        [
                            [
                                " . $data->west_longitude . ",
                                " . $data->north_latitude . "
                            ],
                            [
                                " . $data->east_longitude . ",
                                " . $data->north_latitude . "
                            ],
                            [
                                " . $data->east_longitude . ",
                                " . $data->south_latitude . "
                            ],
                            [
                                " . $data->west_longitude . ",
                                " . $data->south_latitude . "
                            ],
                            [
                                " . $data->west_longitude . ",
                                " . $data->north_latitude . "
                            ]
                        ]
                    ]
                }
            }
        ]
        }";
            
            return $json;
        }
    }

    function perchJSON()
    {
        $id = Auth::user()->id;
        $json = new PerchJSON();
        $json = $this->buildPerchGeoJSON($id);
        return $json;
    }
}
