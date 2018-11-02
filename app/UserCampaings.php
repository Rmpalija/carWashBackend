<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $campaing_id
 * @property string $created_at
 * @property string $updated_at
 * @property CompanyCampaing $companyCampaing
 * @property User $user
 */
class UserCampaings extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'campaing_id', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function companyCampaing()
    {
        return $this->belongsTo('App\CompanyCampaing', 'campaing_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
