<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * @OA\Property(property="created_at", type="string", format="date-time", description="Initial creation timestamp", readOnly="true"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp", readOnly="true"),
 * @OA\Property(property="created_by", type="integer", format="int", description="Consignee created by user_id", readOnly="true"),
 * @OA\Property(property="updated_by", type="integer", format="int", description="Consignee updated by user_id", readOnly="true"),
 * @OA\Property(property="name", type="string", format="text", description="Consignee name", readOnly="true"),
 * @OA\Property(property="description", type="string", format="text", description="Consignee description", readOnly="true"),
 * @OA\Property(property="is_active", type="integer", format="int", description="Consignee status", readOnly="true"),
 * )
 * Class Consignee
 *
 * @package App\Models
 */
class Consignee extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'description', 'created_at', 'created_by', 'updated_at', 'updated_by'];
    protected $hidden = ['pivot'];
}
