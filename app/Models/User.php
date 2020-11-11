<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// JWT contract
use Tymon\JWTAuth\Contracts\JWTSubject;
use Request;

/**
 * @OA\Schema(
 * @OA\Property(property="created_at", type="string", format="date-time", description="Initial creation timestamp", readOnly="true"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp", readOnly="true"),
 * @OA\Property(property="created_by", type="integer", format="int", description="User created by user_id", readOnly="true"),
 * @OA\Property(property="updated_by", type="integer", format="int", description="User updated by user_id", readOnly="true"),
 * @OA\Property(property="department_id", type="integer", format="int", description="User department id", readOnly="true"),
 * @OA\Property(property="role_id", type="integer", format="int", description="User role id", readOnly="true"),
 * @OA\Property(property="city_id", type="integer", format="int", description="User city id", readOnly="true"),
 * @OA\Property(property="state_id", type="integer", format="int", description="User state id", readOnly="true"),
 * @OA\Property(property="first_name", type="string", format="text", description="User first name", readOnly="true"),
 * @OA\Property(property="last_name", type="string", format="text", description="User last name", readOnly="true"),
 * @OA\Property(property="email", type="string", format="email", description="User email", readOnly="true"),
 * @OA\Property(property="mobile_no", type="string", format="number", description="User mobile number", readOnly="true"),
 * @OA\Property(property="address1", type="string", format="text", description="User address1", readOnly="true"),
 * @OA\Property(property="address2", type="string", format="text", description="User address2", readOnly="true"),
 * @OA\Property(property="image_path", type="string", format="text", description="User image path", readOnly="true"),
 * @OA\Property(property="gender", type="string", format="text", description="User gender", readOnly="true"),
 * @OA\Property(property="pin_code", type="integer", format="number", description="User pin code", readOnly="true"),
 * @OA\Property(property="country_id", type="integer", format="int", description="User country id", readOnly="true"),
 * @OA\Property(property="activated_at", type="string", format="date-time", description="User activation at datetime", readOnly="true"),
 * @OA\Property(property="is_active", type="integer", format="int", description="User status", readOnly="true"),
 * @OA\Property(property="password", type="string", format="password", description="User Password", readOnly="true"),
 * @OA\Property(property="alt_mobile_no", type="string", format="number", description="User alternate number", readOnly="true"),
 * @OA\Property(property="hash_passcode", type="string", format="text", description="User hash passcode", readOnly="true"),
 * )
 * Class User
 *
 * @package App\Models
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    /**
     * @var array
     */
    protected $fillable = ['department_id', 'role_id', 'city_id', 'state_id', 'first_name', 'last_name', 'email', 'mobile_no', 'address1', 'address2', 'image_path', 'gender', 'pin_code', 'country', 'activated_at', 'is_active', 'password', 'alt_mobile_no', 'created_by', 'created_at', 'updated_at', 'updated_by'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
    
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userRole()
    {
        return $this->belongsTo('App\Models\UserRole', 'role_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo('App\Models\Department');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state()
    {
        return $this->belongsTo('App\Models\State');
    }
    
    public function organization()
    {
        return $this->belongsTo('App\Models\Organization');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jwtTokens()
    {
        return $this->hasMany('App\Models\JwtToken');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function loginHistories()
    {
        return $this->hasMany('App\Models\LoginHistory');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userSendEmails()
    {
        return $this->hasMany('App\Models\UserSendEmail');
    }
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }


   /* public function getAuthBrowserAttribute()
   {
      $browser = 1;
       if (Request::is('api*')) {
            $browser = 0;
       }
       return $browser;
   }*/

    public function getAuthBrowserAttribute()
   {
    
       if (Request::wantsJson()) {
        $param=1;
        } else {
        $param=0;
        }
        return $param;
   }
    
}
