<?php

namespace App\Http\Controllers;

use App\candidates;
use App\Records;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapController extends Controller
{
    public function index()
    {
        return view('map');
    }

    public function addRecord(Request $request)
    {
//        $table->string('name');
//        $table->string('street');
//        $table->string('city', 50);
//        $table->string('state', 2)->nullable();
//        $table->string('zip', 12)->nullable();
//        $table->string('phone', 30)->nullable();
//        $table->float('latitude', 10, 6);
//        $table->float('longitude', 10, 6);

        try {
            $candidates = new candidates();
            $candidates->name = $request->name;
            $candidates->street = $request->street;
            $candidates->city = $request->city;
            $candidates->state = $request->state;
            $candidates->zip = $request->zip;
            $candidates->phone = $request->phone;
            $candidates->latitude = $request->latitude;
            $candidates->longitude = $request->longitude;
            $candidates->save();
            return "success";
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }

    }

    public function getData($distance)
    {
//        $lat = "23.7612256";
//        $lng = "90.42076599999996";
//        $results = DB::select(DB::raw('SELECT id, ( 3959 * acos( cos( radians(' . $lat . ') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(' . $lng . ') ) + sin( radians(' . $lat . ') ) * sin( radians(lat) ) ) ) AS distance FROM records HAVING distance < ' . $distance . ' ORDER BY distance'));
//        print_r($results);

        $circle_radius = 3959;
        $max_distance = 1;
        $lat = "23.7612256";
        $lng = "90.42076599999996";
//
//        $lat = "25.4454443";
//        $lng = "88.88388340000006";

        $candidates = DB::select(
            'SELECT * FROM 
                    (SELECT id, name, street, phone, latitude, longitude, (' . $circle_radius . ' * acos(cos(radians(' . $lat . ')) * cos(radians(latitude)) *
                    cos(radians(longitude) - radians(' . $lng . ')) +
                    sin(radians(' . $lat . ')) * sin(radians(latitude))))
                    AS distance
                    FROM candidates) AS distances
                WHERE distance < ' . $max_distance . '
                ORDER BY distance
                
                LIMIT 20
            ');
//        print_r($candidates);

        foreach ($candidates as $candidate) {
            echo $candidate->name . "<br>";
            echo $candidate->street . "<br>";
            echo substr($this->distance($lat, $lng, $candidate->latitude, $candidate->longitude,"K"),0,4) . " KM <br>";
            echo "======================= <br><br>";
        }
    }

    function distance($lat1, $lon1, $lat2, $lon2, $unit)
    {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

}
