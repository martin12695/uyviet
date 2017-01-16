<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 14/01/2017
 * Time: 9:58 CH
 */

namespace App\Http\Controllers;
use App\Http\Requests;
use DB;
use App\Quotation;
use Illuminate\Http\Request;



class HomeController
{

    public function initPage() {
        $shopType = DB::select('select type from shop_type where status = 1');
        $listProvince = DB::select('select id,name from province');
        $levels = DB::select('select id,type from shop_cap_do_1480213548');
        $tiemnang = DB::select('select id,type from shop_tiem_nang1480213595');
        return view('home', [
            'shopType' => $shopType,
            'listProvince' => $listProvince,
            'levels' => $levels,
            'tiemnang' =>$tiemnang
        ]);
    }


    public function findItem(Request $request) {
        $location =  DB::select('select (SUBSTRING(`location` from 1 FOR INSTR (location, \',\') - 1) + 0.0 ) as lat, 
                                        (SUBSTRING(`location` from INSTR (location, \',\') + 1 for LENGTH (location) - INSTR (location, \',\'))+0.0) 
                                         as lng from shop where province_id = 89');

        $locationTest = DB::select('select shop.*, icon_url from shop, shop_type where (type_id = shop_type.id) and (shop.province_id = 89) and (shop.district_id = 892)');
        return \Response::json($locationTest);
    }

}