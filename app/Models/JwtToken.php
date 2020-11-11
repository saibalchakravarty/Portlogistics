<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;

/**
 * @OA\Schema(
 * @OA\Property(property="token", type="string", format="text", description="Jwt token", readOnly="true"),
 * @OA\Property(property="user_id", type="integer", format="int", description="user id", readOnly="true"),
 * @OA\Property(property="expiry_time", type="integer", format="int", description="token expiry time", readOnly="true"),
 * )
 * Class JwtToken
 *
 * @package App\Models
 */
class JwtToken extends Model
{
    protected $table='jwt_token';
    public $fillable = ['token','user_id','expiry_time'];    
}

