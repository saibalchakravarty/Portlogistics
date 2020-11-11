<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePrivilege extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_role_id', 'privilege_id',  'is_active',  'created_by',  'updated_by'];

}
