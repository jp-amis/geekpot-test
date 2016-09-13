<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Optimus\Optimus;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class AccessToken extends Model
{
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
    protected $fillable = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public static function generate($user, $instance=false) {
        $accessToken = new Accesstoken;
        $accessToken->user_id = $user->id;
        $accessToken->token = Hash::make(uniqid());
        $accessToken->save();

        return $instance ? $accessToken : $accessToken->token;
    }

    public function refresh() {
        if($this->updated_at->diffInMinutes(Carbon::now()) >= 5) {
            $this->deleted_at = Carbon::now();
            $this->save();

            return AccessToken::generate($this->user);
        } else {
            $this->updated_at = Carbon::now();
            $this->save();

            return $this->token;
        }
    }

    public function isValid() {
        if($this->updated_at->diffInMinutes(Carbon::now()) > 15) {
            $this->deleted_at = Carbon::now();
            $this->save();
            return false;
        }

        return true;
    }
}
