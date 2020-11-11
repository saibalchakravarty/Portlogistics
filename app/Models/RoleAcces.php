<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleAcces extends Model
{
    protected $table = 'role_access';
     /**
     * @var array
     */
    protected $fillable = ['access_id', 'user_role_id','created_by','updated_by'];
    public $timestamps  = false;
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    public function accesslist()
    {
        return $this->belongsto('App\Models\AccessList');
    }
}
