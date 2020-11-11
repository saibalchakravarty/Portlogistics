<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * @OA\Property(property="created_at", type="string", format="date-time", description="Initial creation timestamp", readOnly="true"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp", readOnly="true"),
 * @OA\Property(property="created_by", type="integer", format="int", description="Shift created by user_id", readOnly="true"),
 * @OA\Property(property="updated_by", type="integer", format="int", description="Shift updated by user_id", readOnly="true"),
 * @OA\Property(property="type", type="string", format="varchar", description="Shift Type", readOnly="true"),
 * @OA\Property(property="name", type="string", format="varchar", description="Shift Name", readOnly="true"),
 * @OA\Property(property="start_time", type="string", format="date-time", description="Shift start time", readOnly="true"),
 * @OA\Property(property="end_time", type="string", format="date-time", description="Shift end time", readOnly="true"),
 * )
 * Class Shift
 *
 * @package App\Models
 */
class Shift extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name'];
    public $timestamps  = false;
    protected $dates = [
        'created_at',
        'updated_at'];
    public function challan() {
        return $this->hasMany('App\Models\Challan');
    }
}
