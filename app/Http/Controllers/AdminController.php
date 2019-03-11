<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CommonModel;
use DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $beaconId = $request->beacon_id;
            $locationX = $request->location_x;
            $locationY = $request->location_y;
            $discription = strtolower($request->description);
            $nodes =  explode(',', $request->adjacent_node);
            $beaconUUIDCheck = DB::Table('beacon_listings')
                ->where('beacon_uuid', $beaconId)
                ->first();
            if (empty($beaconUUIDCheck)) {
                $beaconData = array('beacon_uuid' => $beaconId, 'location_x' => $locationX, 'location_y' => $locationY, 'desc' => $discription, 'created_on' => time(), 'updated_on' => time());
                $saveBeacon = DB::table('beacon_listings')
                    ->insert($beaconData);
                if (!empty($nodes[0])) {
                    foreach ($nodes as $node) {
                        $getLocations = DB::table('beacon_listings')
                            ->where('desc', '=', $node)
                            ->first();
                        $latitudeTo = $getLocations->location_x;
                        $longitudeTo = $getLocations->location_y;
                        $distance = $this->haversineGreatCircleDistance($locationX, $locationY, $latitudeTo, $longitudeTo);
                        $newEntryId = (DB::table('beacon_listings')
                            ->where('beacon_uuid', $beaconId)
                            ->first())->id;
                        $getnodeId = $getLocations->id;
                        $edgeName = $newEntryId . $getnodeId;
                        $directionName = (new CommonModel)->bearing($locationX, $locationY, $latitudeTo, $longitudeTo);
                        $ConnectionsList = array('edge_name' => $edgeName, 'first_node' => $newEntryId, 'second_node' => $getnodeId, 'distance' => $distance, 'direction_name' => $directionName, 'created_on' => time(), 'updated_on' => time());
                        DB::table('beacon_connections_lists')
                            ->insert($ConnectionsList);
                    }
                }

                if ($saveBeacon == true) {
                    $response = (new CommonModel)->responseGenerate(
                        config('apiconstants.success_code'),
                        config('apiconstants.success_message.beacon_saved_success_message')
                    );
                }
            } else {
                $response = (new CommonModel)->responseGenerate(
                    config('apiconstants.error_code.beacon_already_exists_error_code'),
                    config('apiconstants.error_message.beacon_already_exists_error_message')
                );
            }
        } catch (\Exception $e) {
            echo $e;
            die;
            $response = (new CommonModel)->responseGenerate(
                config('apiconstants.error_code.SOMETHING_WENT_WRONG_ERROR_CODE'),
                config('apiconstants.error_message.SOMETHING_WENT_WRONG_ERROR_MESSAGE')
            );
        }
        return $response;
    }


    public function haversineGreatCircleDistance(
        $latitudeFrom,
        $longitudeFrom,
        $latitudeTo,
        $longitudeTo,
        $earthRadius = 63.71000
    ) {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        try {
            $getBeaconData = DB::table('beacon_listings')
                ->get();
            if (!empty($getBeaconData)) {
                $response = (new CommonModel)->responseGenerate(
                    config('apiconstants.success_code'),
                    config('apiconstants.success_message.beacon_fetched_success_message'),
                    $getBeaconData
                );
            } else {
                $response = (new CommonModel)->responseGenerate(
                    config('apiconstants.error_code.DATA_NOT_FOUND'),
                    config('apiconstants.error_message.DATA_NOT_FOUND_MESSAGE')
                );
            }
        } catch (\Exception $e) {
            $response = (new CommonModel)->responseGenerate(
                config('apiconstants.error_code.SOMETHING_WENT_WRONG_ERROR_CODE'),
                config('apiconstants.error_message.SOMETHING_WENT_WRONG_ERROR_MESSAGE')
            );
        }
        return $response;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try { } catch (\Exception $e) { }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getBeaconList()
    {
        try {
            $getList = DB::table('beacon_listings')
                ->select('desc')
                ->get();
            if (!empty($getList)) {
                $response = (new CommonModel)->responseGenerate(
                    config('apiconstants.success_code'),
                    config('apiconstants.success_message.beacon_fetched_success_message'),
                    $getList
                );
            } else {
                $response = (new CommonModel)->responseGenerate(
                    config('apiconstants.error_code.DATA_NOT_FOUND'),
                    config('apiconstants.error_message.DATA_NOT_FOUND_MESSAGE')
                );
            }
        } catch (\Exception $e) {
            $response = (new CommonModel)->responseGenerate(
                config('apiconstants.error_code.SOMETHING_WENT_WRONG_ERROR_CODE'),
                config('apiconstants.error_message.SOMETHING_WENT_WRONG_ERROR_MESSAGE')
            );
        }
        return $response;
    }
}
