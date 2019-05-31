<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class AuthorizationPolicyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this-> assignPermissionToUser();
        return $next($request);
    }
    /**
     * Set the Permission to user via role
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     **/
    public function assignPermissionToUser()
    {
        $rootUserRoleName = Config::get('useraccess.rootUserRoleName');

        if ($this->checkApplicationState()) 
        {
            $rolesOfUser = $this->assignedRolesToUser();

            if ($rolesOfUser->pluck('name')->contains($rootUserRoleName)) 
            {
                $allPermissions = $this->allPermission();

                $this->defineGate($allPermissions);

            } else 
            {
                $permissionsOfUser = $this->permissionOfUser();

                $permissionsRole = $this->permissionViaRole($rolesOfUser);

                $uniquePermission = $this->uniQuePermission($permissionsOfUser, $permissionsRole);

                if (isset($uniquePermission)) 
                {
                    $this->defineGate($uniquePermission);
                }
            }
        }
    }

    /**
     * Gets all the permisison names that is assigned via
     * role
     *
     * @return array
     **/
    public function permissionViaRole($rolesOfUser): array
    {

        $permissionsRole = [];

        if ($rolesOfUser->isNotEmpty()) {
            foreach ($rolesOfUser as  $userRole) {
                $permisisonOnRole = $userRole->permissions->pluck('name')->toArray();
                if ($permisisonOnRole !== []) {
                    $permissionsRole[] =  $permisisonOnRole;
                }
            }
            return $permissionsRole;
        }
    }

    /**
     * Returns all the direct Permisison to
     * the current User as a Collection
     *
     * @return array
     **/
    public function permissionOfUser(): array
    {
        $authorizedUser = Auth::user();
        return Permission::with('users')
                                ->whereIn('id', $authorizedUser->permissions->pluck('id'))
                                ->pluck('name')
                                ->toArray();
    }

    /**
     * Returns the root role name of the application
     *
     * @return string
     **/
    public function rootRole()
    {
        return Config::get('useraccess.rootUserRoleName');
    }

    /**
     * Returns all the Permission Name in array
     *
     *
     * @param Type $var Description
     * @return array
     **/
    public function allPermission(): array
    {
        return Permission::pluck('name')->toArray();
    }



    /**
     * Get All the Roles Of the User
     * 
     * It Gets All the Roles of User
     * and plucks id and Name 
     *
     * @param string $selectFiled The Filed Need to Sele
     * @return Illuminate\Database\Eloquent\Collection
     **/
    public function assignedRolesToUser()
    {
        $authorizedUser = Auth::user();

        $rolesOfUser = Role::with('permissions')
                        ->whereIn('id', $authorizedUser->roles->pluck('id'))
                        ->get();

        return $rolesOfUser;

    }

    /**
     * Defines the Array of the Gates
     *
     *
     * @param array $gatArray Array of Permisisons
     * @return void
     **/
    public function defineGate(array $allPermissions): void
    {
        foreach ($allPermissions as $allPermission) {
            Gate::define($allPermission, static function () {
                return true;
            });
        }
    }

    /**
     * Return only the unique permisison on the
     * role and permisison
     *
     *
     * @param array $dirPer Direct Permisison to user
     * @param array $permViaRole Permisison Via Role
     * @return array
     **/
    public function uniQuePermission(array $dirPer = [] ,array $permViaRole = []): array
    {
        $singleLevelArray = array_unique(array_reduce($permViaRole, 'array_merge', []));
        $uniquePermission = array_unique(array_merge($dirPer, $singleLevelArray));
        return $uniquePermission;
    }

    /**
     * Check the Current State to map the Permission
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return bool
     **/
    public function checkApplicationState()
    {
        $authorizedUser = Auth::user();
        return ! App::runningInConsole() && ! is_null($authorizedUser);
    }
}
