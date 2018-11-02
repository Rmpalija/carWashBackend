<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $company_id
 * @property int $user_id
 * @property string $dateTime
 * @property string $car_type
 * @property int $book_status
 * @property string $created_at
 * @property string $updated_at
 * @property Company $company
 * @property User $user
 */
class BookWash extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['company_id', 'user_id', 'date', 'startTime', 'endTime', 'car_type', 'book_status','message','phone_number', 'email', 'fullName', 'vehicleMake', 'vehicleModel', 'offer_id', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
