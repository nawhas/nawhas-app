<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_CONTRIBUTOR = 'contributor';

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

    /**
     * @param $role
     *
     * @return string
     */
    protected function getRoleAttribute($role) : string
    {
        return $role ?: self::ROLE_CONTRIBUTOR;
    }

    /**
     * @return bool
     */
    public function isAdmin() : bool
    {
        return $this->role === self::ROLE_ADMIN;
    }
}
