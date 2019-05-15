<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\{MustVerifyEmail as MustVerifyEmailTrait};
use App\Models\BaseModel;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends BaseModel implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{

    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmailTrait;

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
    * The attributes that should be cast to native types.
    *
    * @var array
    */
    protected $casts = [
    'email_verified_at' => 'datetime',
    'created_at' => 'datetime',
    ];

    /**
    * The number of models to return for pagination.
    *
    * @var int
    */
    protected $perPage = 20;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
    * @param $column
    * @param $value
    *
    * @return mixed
    */
    public function scopeFindByColumn($query,$column, $value)
    {
    return $query->where($column, $value)->first();
    }

}