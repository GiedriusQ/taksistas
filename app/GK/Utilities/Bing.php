<?php

namespace App\GK\Utilities;

use Exception;

class Bing
{

    public static function distanceBetweenTwoPoints($latA, $lngA, $latB, $lngB)
    {
        $url = null;
        try {
            $url = json_decode(file_get_contents("http://dev.virtualearth.net/REST/V1/Routes/Driving?o=json&wp.0={$latA},{$lngA}&wp.1={$latB},{$lngB}&avoid=minimizeTolls"
                . "&key=ApzBhyTdpxIAyswBjJzKEFTAt224INaMQn7pygCpqjhO3jhx-Piw4DMKXc_aApV9"));
        } catch (Exception $e) {
        }
        if (!$url) {
            return -1;
        }

        return $url->resourceSets[0]->resources[0]->travelDistance;
    }
}