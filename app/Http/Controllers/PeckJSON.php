<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeckJSON extends Controller
{
    public function getUserPerchData($id)
    {
        $currentPerch = DB::table('current_perches')->where('user_id', $id)->first();
        if (!empty($currentPerch))
        {
            return $currentPerch;
        }
    }

    public function buildPeckJSON($id)
    {
        $data = $this->getUserPerchData($id);
        $counter = 0;
        if (!empty($data))
        {
            $peck_data['name'] = "Peck Data";
            
            for ($x = -10; $x <= 10; $x += 1) {
                for ($y = -10; $y <= 10; $y += 1) {
                    $hex = getleanhex($x, $y);
                    $peck['x'] = $x;
                    $peck['y'] = $y;
                    $peck['fillColor'] = "#$hex";
                    $peck_data['data'][$counter] = $peck;
                    $counter++;
                }
            }

            $json = json_encode($peck_data, JSON_PRETTY_PRINT);

        }

        return $json;
    }

    function peckJSON()
    {
        $id = Auth::user()->id;
        $json = new PeckJSON();
        $json = $this->buildPeckJSON($id);
        return $json;
    }
}