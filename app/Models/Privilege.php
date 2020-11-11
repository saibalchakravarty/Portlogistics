<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    /**
     * @var array
     */
    protected $table = 'privileges';
    protected $fillable = ['menu_id', 'submenu_id', 'privilage', 'is_active',  'created_by',  'updated_by'];
    public function menuPrivilege()
    {
        return $this->belongsTo('App\Models\SubMenu');
    }

}
