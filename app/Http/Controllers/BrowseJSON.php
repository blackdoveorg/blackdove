<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use BeyondCode\ServerTiming\Facades\ServerTiming;

class BrowseJSON extends Controller
{
    public function getUserBrowseData($id)
    {
        $currentBrowse = DB::table('current_reports')->latest()->get();
        if (!empty($currentBrowse))
        {
            return $currentBrowse;
        }
    }

    public function buildBrowseGeoJSON($id)
    {
        $data = $this->getUserBrowseData($id);
        $counter = 1;
        $dataCounter = count($data);
        $browseJSON['type'] = "FeatureCollection";
        $browseJSON['features'] = array();
        if (!empty($data))
        {
            foreach ($data as $report)
            {
                $report->longitude = (float) $report->longitude;
                $report->latitude = (float) $report->latitude;
                $thisReportJSON['type'] = "Feature";
                $thisReportJSON['properties']['color'] = $report->compass_color;
                $thisReportJSON['properties']['social-compass'] = $report->social_compass;
                $thisReportJSON['properties']['economic-compass'] = $report->economic_compass;
                $thisReportJSON['properties']['issue'] = htmlspecialchars($report->issue);
                $thisReportJSON['properties']['solution'] = htmlspecialchars($report->solution);
                $thisReportJSON['properties']['issue_category'] = json_decode($report->issue_category);
                $thisReportJSON['properties']['solution_category'] = json_decode($report->solution_category);
                $thisReportJSON['geometry']['type'] = "Point";
                $thisReportJSON['geometry']['coordinates'] = array($report->longitude, $report->latitude);
                $browseJSON['features'][] = $thisReportJSON;
            }
            return json_encode($browseJSON);
        }
    }

    function browseJSON()
    {
        ServerTiming::start("browseJSON");
        $id = Auth::user()->id;
        $json = new BrowseJSON();
        $json = $this->buildBrowseGeoJSON($id);
        ServerTiming::stop("browseJSON");
        return $json;
    }
}
