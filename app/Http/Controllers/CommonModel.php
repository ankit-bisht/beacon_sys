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
    {
    }

    public function fetchNodeByID($id)
    {
        $node_data = DB::table('beacon_listings')
            ->where('id', $id)
            ->select('desc', 'id')
            ->first();
        return $node_data;
    }

    public function bearing($lat1_d, $lon1_d, $lat2_d, $lon2_d)
    {
        $lat1 = deg2rad($lat1_d);
        $lon1 = deg2rad($lon1_d);
        $lat2 = deg2rad($lat2_d);
        $lon2 = deg2rad($lon2_d);
        $L    = $lon2 - $lon1;
        $cosD = sin($lat1)*sin($lat2) + cos($lat1)*cos($lat2)*cos($L);
        $calculatedVal    = acos($cosD);
        $cosC = (sin($lat2) - $cosD*sin($lat1))/(sin($calculatedVal)*cos($lat1));
        $result = 180.0*acos($cosC)/pi();
        if (sin($L) < 0.0) {
            $result = 360.0 - $result;
        }
        $result = (int)($result);
        $calculateDirectionName = $this->calculateDirectionName($result);
        return $calculateDirectionName;
    }

    public function calculateDirectionName($result)
    {
            if (($result >= 0 && $result <= 22) || ($result >= 338 && $result <= 360)) {
                $directionVal = 'North';
            } else if ($result >=23 && $result<= 75) {
                $directionVal = 'North East';
            } else if ($result >=76 && $result<= 112) {
                $directionVal = 'East';
            } else if ($result >=113 && $result<= 157) {
                $directionVal = 'South East';
            } else if ($result >=158 && $result<= 202) {
                $directionVal = 'South';
            } else if ($result >=203 && $result<= 247) {
                $directionVal = 'South West';
            } else if ($result >=248 && $result<= 292) {
                $directionVal = 'West';
            } else if ($result >=293 && $result <= 337) {
                $directionVal = 'North West';
            }
        return $directionVal;
    }
}
