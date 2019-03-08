<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controller\CommonModel;

class BeaconController extends Controller
{
    public function fetchNodes(Request $request)
    {
        $beacon_uuid = $request->input('beacon_uuid');
        $data['current_node'] = DB::table('beacon_listings')
                                    ->where('beacon_uuid',$beacon_uuid)
                                    ->first();
        $res = (new CommonModel)->responseGenerate(
            config('apiconstants.success_code'),
            config('apiconstants.success_message.nodes_fetched_success_message'),
            $data
        );
    }
}
