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
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function BankAccounts()
    {
        return $this->hasMany('App\BankAccount');
    }

    public function contacts()
    {
        return $this->hasManyThrough('App\User', '\App\User');
    }

    public function groups()
    {
        return $this->hasMany('App\Group');
    }
}
