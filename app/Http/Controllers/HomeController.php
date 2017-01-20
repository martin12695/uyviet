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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Auth;



class HomeController
{

    public function initPage() {
        $shopType = DB::select('select id,type from shop_type where status = 1');
        $listProvince = DB::select('select id,name from province');
        $levels = DB::select('select id,type from shop_cap_do_1480213548');
        $tiemnang = DB::select('select id,type from shop_tiem_nang1480213595');
        $quymo = DB::select('select id,type from shop_quy_mo1480440358');
        return view('home', [
            'shopType' => $shopType,
            'listProvince' => $listProvince,
            'levels' => $levels,
            'tiemnang' =>$tiemnang,
            'quymo' => $quymo,
        ]);
    }


    public function findItem(Request $request) {
        $filter = $request->input();
        if ($filter['districtId'] =='' || $filter['districtId'] == 0 ){
            $location = DB::select('select shop.*, icon_url from shop, shop_type where (type_id = shop_type.id) and(user_id = ?) and (shop.province_id = ?)',[$filter['userId'],$filter['provinceId']]);
        }
        else{
            if ($filter['wardId'] == '' || $filter['wardId'] == 0) {
                $location = DB::select('select shop.*, icon_url from shop, shop_type where (type_id = shop_type.id) and(user_id = ?) 
                                    and (shop.province_id = ?) and (shop.district_id = ?)',
                                    [$filter['userId'], $filter['provinceId'], $filter['districtId']]);
            }
            else {
                $location = DB::select('select shop.*, icon_url from shop, shop_type where (type_id = shop_type.id) and(user_id = ?) 
                                    and (shop.province_id = ?) and (shop.district_id = ?) and (shop.ward_id = ?) ',
                                    [$filter['userId'], $filter['provinceId'], $filter['districtId'], $filter['wardId']]);
            }
        }

        return \Response::json($location);
    }

    public function getInfoShop(Request $request) {
        $shopId = $request->input('id');
        $infoLocation = DB::select('select shop.*, shop_select_condition.* from shop, shop_select_condition 
                                    where (shop.id = shop_select_condition.shop_id) and  shop.id = ?',[$shopId]);
        return \Response::json($infoLocation);
    }

    public function getDistrictList(Request $request) {
        $provinceId = $request->input('provinceId');
        $listDistrict = DB::select('select id, name from district where province_id = ?',[$provinceId]);
        return \Response::json($listDistrict);
    }

    public function getWardList(Request $request) {
        $districtId = $request->input('districtId');
        $listWard = DB::select('select id, name from ward where district_id = ?',[$districtId]);
        return \Response::json($listWard);
    }


    public function doLogin() {
        session()->flush();
        $rules = array(
            'user'    => 'required|alphaNum|min:3', // make sure the email is an actual email
            'pass' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('/cd')
                ->withErrors($validator) // send back all errors to the login form
                ->withInput(Input::except('pass')); // send back the input (not the password) so that we can repopulate the form
        } else {
            $passMd5 = md5(Input::get('pass'));;
            $login = DB::select('select id, fullname from user where username = ? and password = ? limit 1',[Input::get('user'),$passMd5]);
            if (!empty($login)) {
                session(['userId' => $login[0]->id,
                        'fullname' => $login[0]->fullname
                ]);
                return Redirect::to('/');
            }
            else {
                return Redirect::to('/');
            }
        }
    }

    public function doLogout() {
        session()->flush();
        return Redirect::to('/');
    }
}