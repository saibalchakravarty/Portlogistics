<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * @OA\Property(property="btop_planning_id", type="integer", format="int", description="Plan Id"),
 * @OA\Property(property="consignee_id", type="integer", format="int", description="Consignee Id"),
 * @OA\Property(property="plot_location_id", type="integer", format="int", description="Plot Id"),
 * @OA\Property(property="created_at", type="string", format="date-time", description="Initial creation timestamp", readOnly="true"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp", readOnly="true"),
 * @OA\Property(property="created_by", type="integer", format="int", description="Shift created by user_id", readOnly="true"),
 * @OA\Property(property="updated_by", type="integer", format="int", description="Shift updated by user_id", readOnly="true"),
 * )
 * Class BtopPlanningDetail
 *
 * @package App\Models
 */
class BtopPlanningDetail extends Model
{
    protected $fillable = ['btop_planning_id', 'consignee_id', 'plot_location_id'];
    public $timestamps  = false;
    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
