<?php

namespace App\Http\Controllers;

use App\Cities;
use App\Companies;
use App\Countries;
use App\User;
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

    public function getUserDetails(Request $request) {

        $id = $request->all();

        $user =  User::select('users.firstname',
            'users.lastname',
            'users.email',
            'countries.name as country',
            'cities.name as city')
            ->join('countries', 'countries.id', '=', 'users.country_id')
            ->join('cities', 'cities.id', '=', 'users.city_id')
            ->where('users.id','=',$id['userId'])
            ->get();

        $userCompanies =  Companies::select('companies.name as company',
            'companies.id as companyId',
            'countries.name as country',
            'cities.name as city')
            ->join('countries', 'countries.id', '=', 'companies.country_id')
            ->join('cities', 'cities.id', '=', 'companies.city_id')
            ->where('companies.owner_id','=',$id['userId'])
            ->get();


        return response()->json(['user'=> $user, 'companies'=> $userCompanies], 200);
    }
}
