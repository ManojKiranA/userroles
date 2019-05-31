<?php
namespace App\Models\Aclsync;

use App\Models\Role;

/**
 * Used to Sync Roles for User
 */
trait RolePermissionSync
{
    /**
     * Sync the Permisisons to role
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param array $permission Array of permission
     * @return void
     **/
    public function syncPermission(array $permission): void
    {
        $this->permissions()->sync( array_filter($permission));
    }
}
