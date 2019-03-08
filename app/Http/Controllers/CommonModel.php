<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CommonModel extends Controller
{
    public function responseGenerate($respCode, $respMessage, $data = '')
    {
        $res = [];
        $res['responseCode'] = $respCode;
        $res['responseMessage'] = $respMessage;
        $res['data'] = $data;
        return $res;
    }

    public function fetchNodeByUUID()
    { }

    public function fetchNodeByID($id)
    {
        $node_data = DB::table('beacon_listings')
            ->where('id', $id)
            ->select('desc', 'id')
            ->first();
        return $node_data;
    }
}
