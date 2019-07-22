<?php

namespace App\Models;

use Illuminate\Support\Facades\{Config,Schema};
use App\Models\Aclsync\UserPermissionSync;
use App\Models\Aclsync\UserRoleSync;
use App\Models\Finders\UserFinder;
use App\Models\Relations\UserRelation;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Mutators\UserMutator;
use App\Models\Scopes\UserScope;
use App\Services\Model\CascadeSoftDeletes;
use App\Observers\UserObserver;

/**
 * Class App\Models\User
 *
 * @package     App\Models
 * @property    int     $id
 * @property    string  $name
 * @property    string  $email
 * @property    string  $email_verified_at
 * @property    string  $password
 * @property    string  $remember_token
 * @property    int     $created_by
 * @property    int     $updated_by
 * @property    string  $created_at
 * @property    string  $updated_at
 * @property    string  $deleted_at
 */
class User extends UserExtender
{
    use SoftDeletes, CascadeSoftDeletes;
    use UserFinder, UserRelation,UserMutator;
    use UserPermissionSync, UserRoleSync;
    use UserScope;

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    // protected static function boot()
    // {
    //     parent::boot();

    //     // static::observe(UserObserver::class);
    // }

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';
    
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['name', 'email', 'password',];

    /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
    protected $hidden = [ 'password', 'remember_token',];

    /**
    * The attributes that should be cast to native types.
    *
    * @var array
    */
    protected $casts = ['email_verified_at' => 'datetime','created_at' => 'datetime',];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 20;

    /**
     * Check if the Current Model is Root Role
     *
     * @return bool
     **/
    public function isRoot()
    {
        return $this->email === Config::get('useraccess.seeders.usersTable.superUserData.email');
    }

    // protected $cascadeDeletes = ['roles','permissions'];

}
