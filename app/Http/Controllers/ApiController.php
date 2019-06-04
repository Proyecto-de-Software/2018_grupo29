<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public static function getJSONFromExternalAPI($url) {

        return json_decode(file_get_contents($url));
    }

    public static function getJSONFromExternalAPIWithID($url, $id) {

        return json_decode(file_get_contents($url.$id));
    }
}
