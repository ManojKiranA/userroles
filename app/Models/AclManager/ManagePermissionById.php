<?php

namespace App\Models\AclManager;

use App\Models\Permission;

/**
 *  Handle all the Permission Management by id inside the application
 */

trait ManagePermissionById
{
    /**
     * Give the permission By id of the table
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param mixed $permission Permission Id Array
     * @return $this
     **/
    public function givePermissionById(...$permission)
    {
        $permissions = $this->getPermissionsById(array_flatten($permission));

        if ($permissions === null) {
            return $this;
        }
        $this->permissions()->saveMany($permissions);

        return $this;
    }

    /**
     * Get all the permission By id of the table
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param array $permission Permission Id Array
     * @return array
     **/
    public function getPermissionsById(array $permissions)
    {
        return Permission::whereIn('id', $permissions)->get();
    }
    /**
     * Remove all the permission By id of the table
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param array $permission Permission Id Array
     * @return $this
     **/
    public function removePermissionById(...$permission)
    {
        $permissions = $this->getPermissionsById(array_flatten($permission));

        $this->permissions()->detach($permissions);

        return $this;
    }
    /**
     * Modify the permission By id of the table
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param array $permission Permission Id Array
     * @return $this
     **/
    public function modifyPermissionById(...$permissions)
    {
        $this->permissions()->detach();

        return $this->givePermissionById($permissions);
    }
}