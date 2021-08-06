<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReportJSON extends Controller
{
    public function getUserReportData($id)
    {
        $currentReport = DB::table('current_reports')->where('user_id', $id)->first();
        if (!empty($currentReport))
        {
            return $currentReport;
        }
    }

    public function buildReportGeoJSON($id)
    {
        $data = $this->getUserReportData($id);
        // dd($data);
        $reportJSON['type'] = "FeatureCollection";
        $reportJSON['features'] = array();
        if (!empty($data))
        {
            // $json .= "LENGTH = " . count($data);
            $data->longitude = (float) $data->longitude;
            $data->latitude = (float) $data->latitude;
            $thisReportJSON['type'] = "Feature";
            $thisReportJSON['properties']['color'] = $data->compass_color;
            $thisReportJSON['properties']['social-compass'] = $data->social_compass;
            $thisReportJSON['properties']['economic-compass'] = $data->economic_compass;
            $thisReportJSON['properties']['issue'] = htmlspecialchars($data->issue);
            $thisReportJSON['properties']['solution'] = htmlspecialchars($data->solution);
            $thisReportJSON['geometry']['type'] = "Point";
            $thisReportJSON['geometry']['coordinates'] = array($data->longitude, $data->latitude);
            $reportJSON['features'][] = $thisReportJSON;
        }
        return json_encode($reportJSON);
    }

    function reportJSON()
    {
        $id = Auth::user()->id;
        $json = new ReportJSON();
        $json = $this->buildReportGeoJSON($id);
        return $json;
    }
}
