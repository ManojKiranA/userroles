<?php

namespace App\Models\Gatedefiner;

use Illuminate\Support\Facades\Config;

/**
 * Defines the Permission Via User
 */
trait AssignPermission
{
    use DefineGate , RolePermissionDefiner;
    use ApplicationState,DirectPermissionDefiner;

    /**
     * Set the Permission to user via role
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     **/
    public function assignPermissionToUser()
    {
        $rootUserRoleName = Config::get('useraccess.rootUserRoleName');

        if ($this->checkApplicationState()) {
            $rolesOfUser = $this->assignedRolesToUser();

            if ($rolesOfUser->pluck('name')->contains($rootUserRoleName)) {
                $allPermissions = $this->allPermission();

                $this->defineGate($allPermissions);
            } else {
                $permissionsOfUser = $this->permissionOfUser();

                $permissionsRole = $this->permissionViaRole($rolesOfUser);

                $uniquePermission = $this->uniQuePermission($permissionsOfUser, $permissionsRole);

                if (isset($uniquePermission)) {
                    $this->defineGate($uniquePermission);
                }
            }
        }
    }
}
