<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Code extends Model{

    // ** Ovdje formatiramo naš resposne u odgovarajući oblik, kada kao parametar primamo niz a vraćamo json ** //

    protected $response = array('status' => 'success', 'code' => '0000', 'message' => '', 'link' => '', 'special' => '');

    public static function generateCode($arguments){
        $response['status']  = $arguments[0];
        $response['code']    = $arguments[1];
        $response['message'] = $arguments[2];
        $response['link']    = $arguments[3];
        $response['special']  = $arguments[4];

        return json_encode($response);
    }
}
