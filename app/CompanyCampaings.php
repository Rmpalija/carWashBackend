<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property string $description
 * @property string $start_date
 * @property string $end_date
 * @property string $created_at
 * @property string $updated_at
 * @property Company $company
 * @property UserCampaing[] $userCampaings
 */
class CompanyCampaings extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['company_id', 'name', 'description', 'start_date', 'end_date', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userCampaings()
    {
        return $this->hasMany('App\UserCampaing', 'campaing_id');
    }
}
