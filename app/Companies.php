<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property int $id
 * @property int $country_id
 * @property int $owner_id
 * @property string $name
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property Country $country
 * @property User $user
 * @property BookWash[] $bookWashes
 * @property CompanyCampaing[] $companyCampaings
 * @property Offer[] $offers
 */
class Companies extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['country_id', 'owner_id', 'name', 'city_id','description', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'owner_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookWashes()
    {
        return $this->hasMany('App\BookWash');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companyCampaings()
    {
        return $this->hasMany('App\CompanyCampaing');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function offers()
    {
        return $this->hasMany('App\Offer');
    }

    public function getAllCompanies($cityId){

       $allCompanies =  Companies::select('companies.id as company_id',
           'companies.name as company',
           'countries.name as country',
           'cities.name as city',
           'working_times.*')
            ->join('countries', 'countries.id', '=', 'companies.country_id')
            ->join('cities', 'cities.id', '=', 'companies.city_id')
            ->join('working_times', 'working_times.company_id', '=', 'companies.id')
            ->where('companies.city_id','=',$cityId)
            ->get();

        foreach ($allCompanies as $companyObjectsArray){
            $companyObjectsArray['workingHours'] = [
                ['day' => 'monday', 'value' => $companyObjectsArray['monday']],
                ['day' => 'tuesday', 'value' => $companyObjectsArray['tuesday']],
                ['day' => 'wednesday', 'value' => $companyObjectsArray['wednesday']],
                ['day' => 'thursday', 'value' => $companyObjectsArray['thursday']],
                ['day' => 'friday', 'value' => $companyObjectsArray['friday']],
                ['day' => 'saturday', 'value' => $companyObjectsArray['saturday']],
                ['day' => 'sunday', 'value' => $companyObjectsArray['sunday']],
            ];
        }

        return $allCompanies;
    }

    public function getStatistic($staticData) {


        if($staticData['status'] === -1){
            $statistics = DB::table('book_washes')
                ->select(DB::raw('COUNT(*) as bookings, MONTH(date) as month'))
                ->whereYear('date', '=', $staticData['year'])
                ->groupby('month')
                ->where('company_id','=', $staticData['companyId'])
                ->get();
            return $statistics;
        }

        $statistics = DB::table('book_washes')
            ->select(DB::raw('COUNT(*) as bookings, MONTH(date) as month'))
            ->whereYear('date', '=', $staticData['year'])
            ->where('book_status','=', $staticData['status'])
            ->where('company_id','=', $staticData['companyId'])
            ->groupby('month')
            ->get();

        return $statistics;

    }

    public function getWorkingHoursForCompanyById($id){

        $allCompanies =  WorkingTimes::where('company_id',$id)
            ->get();

        return $allCompanies;
    }

    public function getCompanyOffers($id){

        $companyOffers =  Companies::select('companies.id as company_id',
            'companies.name as company',
            'companies.address as companyAddress',
            'countries.name as country',
            'cities.name as city',
            'companies.longLat',
            'companies.description',
            'offers.id',
            'offers.name as offerName',
            'offers.description as description',
            'offers.price as price',
            'offers.price as time')
            ->join('offers', 'offers.company_id', '=', 'companies.id')
            ->join('countries', 'countries.id', '=', 'companies.country_id')
            ->join('cities', 'cities.id', '=', 'companies.city_id')
            ->where('companies.id', '=', $id)->get();

        return $companyOffers;

    }


    public function getCompanyById($id){

        $company =  Companies::select('companies.name as company',
            'countries.name as country',
            'cities.name as city',
            'companies.longLat',
            'companies.description',
            'companies.address')
            ->join('countries', 'countries.id', '=', 'companies.country_id')
            ->join('cities', 'cities.country_id', '=', 'countries.id')
            ->where('companies.id', '=', $id)->get();

        return $company;

    }
}
