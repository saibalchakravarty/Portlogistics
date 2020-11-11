<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * @OA\Property(property="btop_planning_id", type="integer", format="int", description="Plan Id"),
 * @OA\Property(property="truck_id", type="integer", format="int", description="Truck Id"),
 * @OA\Property(property="status", type="integer", format="int", description="Loaded/Unloaded Status"),
 * @OA\Property(property="created_at", type="string", format="date-time", description="Initial creation timestamp", readOnly="true"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp", readOnly="true"),
 * @OA\Property(property="created_by", type="integer", format="int", description="Shift created by user_id", readOnly="true"),
 * @OA\Property(property="updated_by", type="integer", format="int", description="Shift updated by user_id", readOnly="true"),
 * )
 * Class BtopPlannedTruck
 *
 * @package App\Models
 */
class BtopPlannedTruck extends Model
{
    protected $table = 'btop_planned_trucks';
     /**
     * @var array
     */
    protected $fillable = ['btop_planning_id', 'truck_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'];
    protected $hidden = ['pivot'];
    /**
     * Get the challans.
     */
    public function challan() {
        return $this->hasMany('App\Models\Challan');
    }

    /**
     * Get the trucks that owns the planning.
     */
    public function truck()
    {
        return $this->belongsTo('App\Models\Truck');
    }

    /**
     * Get the plannings.
     */
    public function planning()
    {
        return $this->belongsTo('App\Models\BtopPlanning');
    }

}

