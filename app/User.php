<?php

namespace App;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject as JWTSubject;

/**
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $firstname
 * @property string $lastname
 * @property int $isOwner
 * @property string $image
 * @property string $code
 * @property string $displayName
 * @property int $city_id
 * @property int $country_id
 * @property string $updated_at
 * @property string $created_at
 * @property BookWash[] $bookWashes
 * @property Company[] $companies
 * @property UserCampaing[] $userCampaings
 */
class User extends Authenticatable implements JWTSubject
{

    /**
     * Get the identifier that will be stored in the subject claim of the JWT
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @var array
     */
    protected $fillable = ['email', 'password', 'firstname', 'lastname', 'isOwner', 'image', 'code', 'displayName','city_id', 'country_id', 'updated_at', 'created_at'];

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
    public function companies()
    {
        return $this->hasMany('App\Company', 'owner_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userCampaings()
    {
        return $this->hasMany('App\UserCampaing');
    }
}
