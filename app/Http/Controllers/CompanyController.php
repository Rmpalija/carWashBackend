<?php

namespace App\Http\Controllers;

use App\Companies;
use App\Http\Requests\CreateCompany;
use App\User;
use App\UserCompanies;
use App\WorkingTimes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;


class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companieModel = new Companies();

        $cityId = Input::get('cityId');

        $companies = $companieModel->getAllCompanies($cityId);

        return response()->json(['status'=>'success', 'companies'=> $companies],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreateCompany  $request
     * @return \Illuminate\Http\Response
     */
    public function create(CreateCompany $request)
    {
        $input = $request->only('name','description','country_id','city_id');

        $input['owner_id'] = Auth::user()->id;

        $newCompany = Companies::create($input);

        $inputUserCompanies= [
            "user_id"=> $input['owner_id'],
            "company_id"=> $newCompany->id
        ];

        UserCompanies::create($inputUserCompanies);

        return response()->json(['status'=>'success','company_id'=>$newCompany->id],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Companies::find($id);

        $offerForCompany = $company->getCompanyOffers($id);

        if ($offerForCompany)
        {
            return response()->json(['status'=>'success','companyOffer'=> $offerForCompany],200);
        }
        return response()->json(['status'=>'failed','message'=>'Company with this Id dose not exist!'],404);
    }


    public function getCompanyById($id) {

        $company = Companies::find($id);

        $singleCompany = $company->getCompanyById($id);

        if ($company)
        {
            return response()->json(['status'=>'success','company' => $singleCompany[0]],200);
        }
        return response()->json(['status'=>'failed','message'=>'Company dont\'t exist!'],404);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input   = $request->only('name','description','country_id');
        $company = Companies::find($id);

        if($company && sizeof($input)>0)
        {
            $company->update($input);
            return response()->json(['status'=>'success','company'=>$company->toArray()],200);
        }

        return response()->json(['status'=>'failed','message'=>'No company with this id or there is nothing to update'],404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Companies::find($id))
        {
            Companies::destroy($id);
            return response()->json(['status'=>'success','message'=>'Company deleted!'],200);
        }
        return response()->json(['status'=>'failed','message'=>'Company with this Id dose not exist!'],404);
    }

    public function getOwnerCompanies($id){

        $ownerompanies = Companies::select('companies.id as company_id','countries.name as country', 'cities.name as city', 'companies.name as company')
            ->join('countries','countries.id','=','companies.country_id')
            ->join('cities','cities.id','=','companies.city_id')
            ->where('owner_id','=', $id)
            ->get();

        return response()->json(['status'=>'success','companies'=>$ownerompanies], 200);

    }
    public function saveCompanyTime(Request $request) {

        $input = $request->all();


        $inputCompaniesTime= [
            "company_id" => $input['companyId'],
            "monday"=> $input['mondayStartTime']['hour'].':'.$input['mondayStartTime']['minute'].'-'.$input['mondayEndTime']['hour'].':'.$input['mondayEndTime']['minute'],
            "tuesday"=> $input['tuesdayStartTime']['hour'].':'.$input['tuesdayStartTime']['minute'].'-'.$input['tuesdayEndTime']['hour'].':'.$input['tuesdayEndTime']['minute'],
            "wednesday"=> $input['wednesdayStartTime']['hour'].':'.$input['wednesdayStartTime']['minute'].'-'.$input['wednesdayEndTime']['hour'].':'.$input['wednesdayEndTime']['minute'],
            "thursday"=> $input['thursdayStartTime']['hour'].':'.$input['thursdayStartTime']['minute'].'-'.$input['thursdayEndTime']['hour'].':'.$input['thursdayEndTime']['minute'],
            "friday"=> $input['fridayStartTime']['hour'].':'.$input['fridayStartTime']['minute'].'-'.$input['fridayEndTime']['hour'].':'.$input['fridayEndTime']['minute'],
            "saturday"=> $input['saturdayStartTime']['hour'].':'.$input['saturdayStartTime']['minute'].'-'.$input['saturdayEndTime']['hour'].':'.$input['saturdayEndTime']['minute'],
            "sunday"=> $input['sundayStartTime']['hour'].':'.$input['sundayStartTime']['minute'].'-'.$input['sundayEndTime']['hour'].':'.$input['sundayEndTime']['minute']
        ];

        $time = WorkingTimes::where('company_id',$input['companyId'])->get();


        if(count($time->all()) === 0){
            WorkingTimes::create($inputCompaniesTime);
        }else{
            WorkingTimes::where('company_id','=',$input['companyId'])->update($inputCompaniesTime);
        }


        return response()->json(['status'=>'success','time'=>$inputCompaniesTime], 200);
    }
}
