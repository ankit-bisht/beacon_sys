<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonModel extends Controller
{
    public function responseGenerate($respCode, $respMessage, $data = '')
    {
        $res = [];
        $res['respCode'] = $respCode;
        $res['respMessage'] = $respMessage;
        $res['data'] = $data;
        return $res;
    }
}
