<?php

namespace App\Models\Gatedefiner;

use App\Models\Permission;
use Illuminate\Support\Facades\Auth;

/**
 * Defines the Permission Via User
 */
trait DirectPermissionDefiner
{
    /**
     * Returns all the direct Permisison to
     * the current User as a Collection
     *
     * @return array
     **/
    public function permissionOfUser(): array
    {
        $authorizedUser = Auth::user();
        $permissionOfUser = Permission::with('users')
                                ->whereIn('id', $authorizedUser->permissions->pluck('id'))
                                ->pluck('name')
                                ->toArray();
        return $permissionOfUser;
    }

    /**
     * Returns all the Permission Name in array
     *
     *
     * @return array
     **/
    public function allPermission(): array
    {
        return Permission::pluck('name')->toArray();
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
    public function uniQuePermission(array $dirPer = [], array $permViaRole = []): array
    {
        $singleLevelArray = array_unique(array_reduce($permViaRole, 'array_merge', []));
        $uniquePermission = array_unique(array_merge($dirPer, $singleLevelArray));
        return $uniquePermission;
    }
}
