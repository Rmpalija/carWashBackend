<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property string $description
 * @property float $price
 * @property string $created_at
 * @property string $updated_at
 * @property Company $company
 */
class Offers extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['company_id', 'name', 'description', 'time', 'price', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('App\Company');
    }
}
