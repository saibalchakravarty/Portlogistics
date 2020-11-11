<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessList extends Model
{
    protected $table = 'access_lists';
     /**
     * @var array
     */
    protected $fillable = ['parent_id', 'operation', 'display_name', 'display_name'];
    public $timestamps  = false;
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    public function children()
    {
        return $this->hasMany('App\Models\AccessList', 'parent_id');
    }
    public function subChild()
    {
        return $this->hasMany('App\Models\AccessList', 'parent_id');
    }
    public function roleaccess()
    {
        return $this->hasMany('App\Models\RoleAcces','access_id');
    }
}
