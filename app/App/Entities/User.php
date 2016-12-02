<?php

namespace App\App\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password','perfil_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function perfil()
    {
        return $this->belongsTo('App\App\Entities\Perfil');
    }

    public function colaborador()
    {
        return $this->belongsTo('App\App\Entities\Colaborador');
    }

    protected function setPasswordAttribute($value)
    {
        if( ! empty($value) )
        {
            $this->attributes['password'] = bcrypt($value);
        }
    }
}

