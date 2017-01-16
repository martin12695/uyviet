<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 16/01/2017
 * Time: 11:08 SA
 */

namespace App\Http\Controllers;
use App\Http\Requests;
use DB;
use App\Quotation;
use Illuminate\Http\Request;


class HandleIcon
{
    public function handleIconMap(Request $request) {
        $type = $request->input('type');
        if ($type == '2' ) {
            $result = '/images/map-icons/4.jpg';
        }
        imagecreatefromjpeg(base_path().'/public/images/map-icons/4.jpg');
    }
}