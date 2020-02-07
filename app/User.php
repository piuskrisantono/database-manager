<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */




    // protected $fillable = [
    //     'name', 'email', 'password',
    // ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasRole($role)
    {
        return null !== $this->roles()->where('rolname', $role)->first();
    }

    public function roles()
    {
        return $this->belongsTo('App\Role', 'role_id');
    }


    public function dbrequests()
    {
        return $this->hasMany('App\Dbrequest');
    }

    public function histories()
    {
        return $this->hasMany('App\History', 'username', 'actor');
    }
}
