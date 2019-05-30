<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Finders\UserFinder;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use App\Models\Accessors\UserAccessor;
use App\Models\Relations\UserRelation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use App\Models\Comman\Html\Buttons\Actionbutton\TableActionButtons;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

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
    use SoftDeletes, UserFinder, UserRelation, TableActionButtons, UserAccessor;

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

    /**
     * Sync The Roles to User
     *
     * While Creating the new User We need to assign
     * the role for them so the relation table needs
     * to be filled
     *
     * @param array $roles The roles array form the form
     * @return $this
     * @throws conditon
     **/
    public function syncRoles(array $roles): void
    {
        $this->roles()
            ->sync( array_filter($roles));
    }

    /**
     * Sync The Permisions to User
     *
     * While Creating the new User We may need to assign
     * the permissions for them so the relation table needs
     * to be filled
     *
     * @param array $var Description
     * @return void
     **/
    public function syncPermissions(array $permisions): void
    {
        $this->permissions()
            ->sync(array_filter($permisions));
    }

    /**
     * Sync The Permisions to User
     *
     * While Creating the new User We may need to assign
     * the permissions for them so the relation table needs
     * to be filled.
     * But While You are selecting the roles and permissions
     * the roles will have the direct permission.
     * But you will give them direct permissions.
     * It may leads to duplications in which the role
     * may have the permisison but you may give the direct
     * permisison to the user but we don't need that
     *
     * @param array $permisions Array of permisison id
     * @return void
     **/
    public function syncUniquePermissions(array $permisions,array $roles,string $method): void
    {
        $this->permissions()
            ->sync($this->assignUniquePermisison($roles, $permisions, $method));
    }

    /**
     * Set the Unique Permission Based on the role
     *
     * If the User selects the multiple roles and permissions
     * and if the if the user seleted permisisons exits in the
     *  selected role then we are removing it
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param array $roles Array of Roles
     * @param array $permissions Array of Permissions
     * @param string $method The Method
     * @return array
     **/
    private function assignUniquePermisison($roles = [], $permissions = [], $method): array
    {
        $roles = array_filter($roles);
        $permissions = array_filter($permissions);

        if ($roles === [] && $permissions === [] || $roles !== [] && $permissions === []) {
            return [];
        } elseif ($roles === [] && $permissions !== []) {
            return $permissions;
        }
        if (is_array($roles)) {
            foreach ($roles as $roleV) {
                $perToEachRole = Role::findOrFail($roleV);
                $perArrToRoles = $perToEachRole->permissions->toArray();
                foreach ($perArrToRoles as $perArrToRoleVal) {
                    $totPermList[] = $perArrToRoleVal['id'];
                }
            }
            $dirPermToRole = array_unique($totPermList);
        }
        if ($method === 'STORE') {
            $difference = array_merge(array_diff($dirPermToRole, $permissions), array_diff($permissions, $dirPermToRole));
        } elseif ($method === 'UPDATE') {
            $difference = array_merge(array_diff($permissions, $dirPermToRole));
        }
        return $difference;
    }

}
