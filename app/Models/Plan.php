<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * @OA\Property(property="origin_id", type="integer", format="int", description="Origin location Id"),
 * @OA\Property(property="cargo_id", type="integer", format="int", description="Cargo Id"),
 * @OA\Property(property="vessel_id", type="integer", format="int", description="Vessel Id"),
 * @OA\Property(property="date_from", type="string", format="date-time", description="Plan starting datetime"),
 * @OA\Property(property="date_to", type="string", format="date-time", description="Plan ending datetime"),
 * @OA\Property(property="status", type="integer", format="int", description="Plan Open/Close"),
 * @OA\Property(property="is_active", type="integer", format="int", description="Plan Active/Inactive"),
 * @OA\Property(property="type", type="integer", format="int", description="Plan type 1-BTOP 2-PTOP", readOnly="true"),
 * @OA\Property(property="created_at", type="string", format="date-time", description="Initial creation timestamp", readOnly="true"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp", readOnly="true"),
 * @OA\Property(property="created_by", type="integer", format="int", description="Shift created by user_id", readOnly="true"),
 * @OA\Property(property="updated_by", type="integer", format="int", description="Shift updated by user_id", readOnly="true"),
 * )
 * Class Plan
 *
 * @package App\Models
 */

class Plan extends Model
{
    protected $table = 'plans';
     /**
     * @var array
     */
    protected $fillable = ['origin_id', 'cargo_id', 'vessel_id', 'status','type'];
    public $timestamps  = false;
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    protected $hidden = ['pivot'];
    /**
     * Get the cargo that owns the planning.
     */
    public function cargo()
    {
        return $this->belongsTo('App\Models\Cargo');
    }

    /**
     * Get the vessel that owns the planning.
     */
    public function vessel()
    {
        return $this->belongsTo('App\Models\Vessel');
    }

    /**
     * Get the location that owns the planning.
     */
    public function location()
    {
        return $this->belongsTo('App\Models\Location', 'origin_id');
    }

    public function challan() {
        return $this->hasMany('App\Models\Challan');
    }

    /**
     * Get the consignees that owns the planning.
     */
    public function consignees()
    {
        return $this->belongsToMany('App\Models\Consignee', 'plan_details', 'plan_id');
    }

    /**
     * Get the plots that owns the planning.
     */
    public function plots()
    {
        return $this->belongsToMany('App\Models\Location', 'plan_details', 'plan_id', 'destination_id');
    }

    /**
     * Get the trucks that owns the planning.
     */
    public function trucks()
    {
        return $this->belongsToMany('App\Models\Truck', 'plan_trucks', 'plan_id');
    }
}

