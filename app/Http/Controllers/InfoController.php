<?php

namespace App\Http\Controllers;

use App\Cities;
use App\Countries;
use Illuminate\Http\Request;

class InfoController extends Controller
{

    public function getCountries(){
        return response()->json(['status'=>'success', 'countries'=> Countries::all()],200);
    }

    public function getCityByCountryId($id) {

       $cities =  Cities::where('country_id','=',$id)->get();

        return response()->json(['status'=>'success', 'cities'=> $cities],200);
    }
}
