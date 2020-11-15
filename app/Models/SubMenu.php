<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    protected $table = 'submenus';
    public function privileges()
    {
        return $this->hasMany('App\Models\Privilege','submenu_id');
    }
	
}
