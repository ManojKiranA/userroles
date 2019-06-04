<?php

namespace App\Models;

use App\Models\Aclsync\UserPermissionSync;
use App\Models\Aclsync\UserRoleSync;
use App\Models\Comman\Html\Buttons\Actionbutton\TableActionButtons;
use App\Models\Finders\UserFinder;
use App\Models\Relations\UserRelation;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Models\Traits\Auditable;
use App\Models\Mutators\UserMutator;
use App\Models\Scopes\UserScope;

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
class User extends BaseModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;
    use SoftDeletes, UserFinder, UserRelation, TableActionButtons, UserMutator;
    use UserPermissionSync, UserRoleSync;
    use Auditable ,UserScope;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The edit route that is used for the Model.
     *
     * @var string
     */
    protected $editRoute = 'admin.access.users.edit';

    /**
     * The delete route that is used for the Model.
     *
     * @var string
     */
    protected $deleteRoute = 'admin.access.users.destroy';

    /**
     * The show route that is used for the Model.
     *
     * @var string
     */
    protected $showRoute = 'admin.access.users.show';

    /**
     * The force delete route that is used for the Model.
     *
     * @var string
     */
    protected $forceDeleteRoute = 'admin.access.users.forcedelete';

    /**
     * The restore route that is used for the Model.
     *
     * @var string
     */
    protected $restoreRoute = 'admin.access.users.restore';

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
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 20;
}
