<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Optimus\Optimus;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model
{

    public static $PERM_ADMIN = 1;
    public static $PERM_NORMAL = 0;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'email', 'password' ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];


    public function getApiSecret()
    {
        return hash_hmac('sha1', $this->id . $this->api_key, env('APP_KEY', 'app_key'));
    }


    public function obfuscateId()
    {
        $optimus = new Optimus(1109591831, 1913168039, 1504045762);

        return $optimus->encode($this->id);
    }

    public static function getIdFromObfuscation($id) {
        $optimus = new Optimus(1109591831, 1913168039, 1504045762);

        return $optimus->decode($id);
    }


    public function setApiKey()
    {
        $this->api_key = Hash::make(uniqid());
    }


    public function accessTokens()
    {
        return $this->hasMany('App\AccessToken');
    }
}
