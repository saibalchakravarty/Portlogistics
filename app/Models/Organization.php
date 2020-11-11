<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * @OA\Property(property="created_at", type="string", format="date-time", description="Initial creation timestamp", readOnly="true"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp", readOnly="true"),
 * @OA\Property(property="created_by", type="integer", format="int", description="Organization created by user_id", readOnly="true"),
 * @OA\Property(property="updated_by", type="integer", format="int", description="Organization updated by user_id", readOnly="true"),
 * @OA\Property(property="name", type="string", format="text", description="Organization name", readOnly="true"),
 * @OA\Property(property="mobile_no", type="string", format="number", description="Organization mobile number", readOnly="true"),
 * @OA\Property(property="email", type="string", format="email", description="Organization email", readOnly="true"),
 * @OA\Property(property="address", type="string", format="text", description="Organization address", readOnly="true"),
 * @OA\Property(property="address2", type="string", format="text", description="Organization address2", readOnly="true"),
 * @OA\Property(property="primary_contact", type="string", format="text", description="Organization primary contact", readOnly="true"),
 * @OA\Property(property="primary_mobile_no", type="string", format="number", description="Organization primary mobile number", readOnly="true"),
 * @OA\Property(property="primary_email", type="string", format="email", description="Organization primary email", readOnly="true"),
 * @OA\Property(property="secondary_email", type="string", format="email", description="Organization secondary email", readOnly="true"),
 * @OA\Property(property="secondary_mobile_no", type="string", format="number", description="Organization secondary mobile number", readOnly="true"),
 * @OA\Property(property="secondary_contact", type="string", format="text", description="Organization secondary contact", readOnly="true"),
 * @OA\Property(property="is_active", type="integer", format="int", description="Organization status", readOnly="true"),
 * @OA\Property(property="currency_id", type="integer", format="int", description="Organization currency id", readOnly="true"),
 * @OA\Property(property="rate_per_trip", type="number", format="double", description="Organization rate per trip", readOnly="true"),
 * )
 * Class Organization
 *
 * @package App\Models
 */

class Organization extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'mobile_no', 'email', 'address1', 'address2', 'currency_id', 'is_active', 'rate_per_trip', 'created_at', 'created_by', 'updated_at', 'updated_by'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function countries()
    {
        return $this->belongsTo('App\Models\Country');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function currencies()
    {
        return $this->hasOne('App\Models\Currency');
    }
    
    public function users()
    {
        return $this->hasMany('App\Models\User');
    }
    
}
