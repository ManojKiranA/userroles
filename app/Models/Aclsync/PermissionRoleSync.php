<?php
namespace App\Models\Aclsync;

use App\Models\Role;

/**
 * Used to Sync Roles for User
 */
trait PermissionRoleSync
{
    /**
     * Sync the Roles to Permission
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param array $roles Array of Role id's
     * @return void
     **/
    public function syncRoles(array $roles): void
    {
        $this->roles()->sync(array_filter($roles));
    }
}
