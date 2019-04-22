<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guard= 'admin';
    protected $fillable = [
        'username','name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

//    public function roles()
//    {
//        return $this->belongsToMany(Role::class);
//    }
//    public function categories()
//    {
//        return $this->belongsToMany(\App\Category::class);
//    }
//    public function hasRole($role)
//    {
//        if(is_string($role))
//        {
//            return $this->roles->contains('name',$role);
//        }
//        return !! $role->intersect($this->roles)->count();
//    }


}
