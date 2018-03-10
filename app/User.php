<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'ci'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function feeds()
    {
        return $this->hasMany(Feed::class);
    }

    public function friends()
    {
        return $this->belongsToMany(User::class,'friendship','user_id','user2_id')->withTimestamps();
        //return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');
    }

    public function imbox()
    {
        return $this->hasMany(Imbox::class);
    }
}
