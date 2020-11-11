<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $country_id
 * @property string $currency
 * @property string $currency_code
 * @property string $symbol
 * @property string $created_at
 * @property string $updated_at
 * @property string $is_active
 * @property Country $country
 * @property Organization[] $organization
 */
class Currency extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['country_id', 'currency', 'currency_code', 'created_at', 'symbol', 'updated_at', 'is_active'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function countries()
    {
        return $this->belongsTo('App\Models\Country');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organizations()
    {
        return $this->belongsTo('App\Models\Organization');
    }
}
