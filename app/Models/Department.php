<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * @OA\Property(property="created_at", type="string", format="date-time", description="Initial creation timestamp", readOnly="true"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp", readOnly="true"),
 * @OA\Property(property="created_by", type="integer", format="int", description="Department created by user_id", readOnly="true"),
 * @OA\Property(property="updated_by", type="integer", format="int", description="Department updated by user_id", readOnly="true"),
 * @OA\Property(property="name", type="string", format="text", description="Department name", readOnly="true"),
 * @OA\Property(property="description", type="string", format="text", description="Department description", readOnly="true"),
 * @OA\Property(property="is_active", type="integer", format="int", description="Department status", readOnly="true"),
 * )
 * Class Department
 *
 * @package App\Models
 */
class Department extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'description', 'is_active', 'created_at', 'created_by', 'updated_at', 'updated_by'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\Models\User');
    }
}
