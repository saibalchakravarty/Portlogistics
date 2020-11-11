<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * @OA\Property(property="created_at", type="string", format="date-time", description="Initial creation timestamp", readOnly="true"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp", readOnly="true"),
 * @OA\Property(property="created_by", type="integer", format="int", description="Trucking company created by user_id", readOnly="true"),
 * @OA\Property(property="updated_by", type="integer", format="int", description="Trucking company updated by user_id", readOnly="true"),
 * @OA\Property(property="name", type="string", format="text", description="Trucking company name", readOnly="true"),
 * @OA\Property(property="email", type="string", format="email", description="Trucking company email", readOnly="true"),
 * @OA\Property(property="mobile_no", type="string", format="number", description="Trucking company mobile number", readOnly="true"),
 * @OA\Property(property="contact_name", type="string", format="text", description="Trucking company contact name", readOnly="true"),
 * @OA\Property(property="contact_mobile_no", type="string", format="number", description="Trucking company contact number", readOnly="true"),
 * )
 * Class TruckCompany
 *
 * @package App\Models
 */
class TruckCompany extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'email', 'mobile_no', 'contact_name', 'contact_mobile_no', 'is_active', 'created_at', 'created_by', 'updated_at', 'updated_by'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trucks()
    {
        return $this->hasMany('App\Models\Truck');
    }
}
