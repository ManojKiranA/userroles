<?php

namespace App\Models;
use App\Models\BaseModel;
use Illuminate\Auth\{MustVerifyEmail as MustVerifyEmailTrait, Authenticatable};
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Models\Relations\{UserRelation,BaseRelation};
use Illuminate\Database\Eloquent\Model;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    // use UserRelation;

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

     /**
     * Accessor for formatting the created_at field
     *
     * Formats the created_at attribute with carbon
     *
     * @author Manojkiran.A <manojkiran1003199@gmail.com>
     * @return string
     **/
    public function getCreatedByAttribute()
    {
        
    }

    /**
     * The user that Created the model.
     * 
     * Belongs-to relations with User.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    

}