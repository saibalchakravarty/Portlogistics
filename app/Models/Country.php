<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $countries
 * @property string $states
 * @property User[] $users
 */
class Country extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['countries'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function states()
    {
        return $this->hasMany('App\Models\State');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\Models\User');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function currencies()
    {
        return $this->hasOne('App\Models\Currency');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function organizations()
    {
        return $this->hasMany('App\Models\Organization');
    }
}
