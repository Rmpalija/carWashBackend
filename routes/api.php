<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE,PATCH,OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With, x-xsrf-token');
header('Access-Control-Allow-Credentials: true');



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('test',function(){
  return response()->json(['a'=>'a'],200);
});

Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::get('countries','InfoController@getCountries');
Route::get('citie/{id}','InfoController@getCityByCountryId');

Route::group(['prefix' => 'auth', 'middleware' => 'jwt.auth'], function () {
    Route::get('user', 'AuthController@user');
    Route::post('logout', 'AuthController@logout');
});

Route::group(['middleware'=> 'jwt.auth'],function(){

    //Company Routes
    Route::get('allCompanies','CompanyController@index');
    Route::get('company/{id}','CompanyController@show');
    Route::get('companyInfo/{id}','CompanyController@getCompanyById');
    Route::get('ownerCompanies/{id}','CompanyController@getOwnerCompanies');
    Route::post('company','CompanyController@create');
    Route::put('company/{id}','CompanyController@update');
    Route::delete('company/{id}','CompanyController@destroy');

});

Route::group(['middleware'=> 'jwt.auth'],function(){

    //Offer Routes
    Route::post('offer','OfferController@create');
    Route::get('offer/{id}','OfferController@getOffer');
    Route::get('offerById/{id}','OfferController@offerById');
    Route::get('offerDelete/{id}','OfferController@deleteOffer');
    Route::post('offerUpdate','OfferController@updateOffer');

});

Route::group(['middleware'=> 'jwt.auth'],function(){

    //Offer Routes
    Route::post('booking','BookingController@create');
    Route::get('booking/{id}','BookingController@showUserBookings');
    Route::get('bookingOwner/{id}','BookingController@showOwnerBookings');
    Route::get('bookingAccept/{id}','BookingController@acceptBooking');
    Route::post('bookingDeclined','BookingController@declinedBooking');
    Route::post('checkDate','BookingController@checkDate');

});


Route::middleware('jwt.refresh')->get('/token/refresh', 'AuthController@refresh');