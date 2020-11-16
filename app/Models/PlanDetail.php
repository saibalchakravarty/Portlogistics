<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * @OA\Property(property="plan_id", type="integer", format="int", description="Plan Id"),
 * @OA\Property(property="consignee_id", type="integer", format="int", description="Consignee Id"),
 * @OA\Property(property="destination_id", type="integer", format="int", description="Destination location Id"),
 * @OA\Property(property="created_at", type="string", format="date-time", description="Initial creation timestamp", readOnly="true"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp", readOnly="true"),
 * @OA\Property(property="created_by", type="integer", format="int", description="Shift created by user_id", readOnly="true"),
 * @OA\Property(property="updated_by", type="integer", format="int", description="Shift updated by user_id", readOnly="true"),
 * )
 * Class PlanDetail
 *
 * @package App\Models
 */
class PlanDetail extends Model
{
    protected $fillable = ['plan_id', 'consignee_id', 'destination_id'];
    public $timestamps  = false;
    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
