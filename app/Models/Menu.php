<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    public function subMenus()
    {
        return $this->hasMany('App\Models\SubMenu','menu_id');
    }
}
