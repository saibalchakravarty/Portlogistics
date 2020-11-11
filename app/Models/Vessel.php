<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * @OA\Property(property="created_at", type="string", format="date-time", description="Initial creation timestamp", readOnly="true"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp", readOnly="true"),
 * @OA\Property(property="created_by", type="integer", format="int", description="Vessel created by user_id", readOnly="true"),
 * @OA\Property(property="updated_by", type="integer", format="int", description="Vessel updated by user_id", readOnly="true"),
 * @OA\Property(property="name", type="string", format="varchar", description="Vessel name", readOnly="true"),
 * @OA\Property(property="description", type="string", format="varchar", description="Vessel Description", readOnly="true"),
 * @OA\Property(property="loa", type="number", format="double", description="Vessel Loa", readOnly="true"),
 * @OA\Property(property="beam", type="number", format="double", description="Vessel beam", readOnly="true"),
 * @OA\Property(property="draft", type="number", format="double", description="Vessel draft", readOnly="true"),
 * )
 * Class Vessel
 *
 * @package App\Models
 */
class Vessel extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'loa', 'beam', 'draft', 'description', 'created_by',  'updated_by'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function challans()
    {
        return $this->hasMany('App\Challan');
    }
}
