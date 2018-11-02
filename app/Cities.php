<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $country_id
 * @property string $name
 * @property string $longLat
 * @property string $created_at
 * @property string $updated_at
 * @property Country $country
 */
class Cities extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['country_id', 'name', 'longLat', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo('App\Country');
    }
}
