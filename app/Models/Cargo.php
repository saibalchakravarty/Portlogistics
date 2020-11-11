<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * @OA\Property(property="created_at", type="string", format="date-time", description="Initial creation timestamp", readOnly="true"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp", readOnly="true"),
 * @OA\Property(property="created_by", type="integer", format="int", description="Cargo created by user_id", readOnly="true"),
 * @OA\Property(property="updated_by", type="integer", format="int", description="Cargo updated by user_id", readOnly="true"),
 * @OA\Property(property="name", type="string", format="varchar", description="Cargo name", readOnly="true"),
 * @OA\Property(property="instruction", type="string", format="varchar", description="Cargo instruction", readOnly="true"),
 * )
 * Class Cargo
 *
 * @package App\Models
 */
class Cargo extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'instruction', 'created_at', 'created_by', 'updated_at', 'updated_by'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function challan()
    {
        return $this->hasMany('App\Models\Challan');
    }
}
