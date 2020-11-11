<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * @OA\Property(property="created_at", type="string", format="date-time", description="Initial creation timestamp", readOnly="true"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp", readOnly="true"),
 * @OA\Property(property="user_id", type="integer", format="int64", description="User id", readOnly="true"),
 * @OA\Property(property="token", type="string", format="varchar", description="Token", readOnly="true"),
 * @OA\Property(property="email_template", type="string", format="varchar", description="Email template type", readOnly="true"),
 * )
 * Class Cargo
 *
 * @package App\Models
 */
class UserSendEmail extends Model
{
    protected $table = 'user_send_emails';
    public $fillable = ['token','user_id','email_template'];
    public $timestamps  = false;
    protected $dates = [
        'created_at',
        'updated_at'];
}
