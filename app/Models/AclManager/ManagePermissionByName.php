<?php

namespace App\Models\AclManager;

use App\Models\Permission;

/**
 *  Handle all the Role Management by id inside the application
 */
trait ManagePermissionByName
{
    /**
     * Give the permission By name of the table
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param mixed $permission Permission name Array
     * @return $this
     **/
    public function givePermissionByName(...$permission)
    {
        $permissions = $this->getPermissionsByName(array_flatten($permission));

        if ($permissions === null) {
            return $this;
        }
        $this->permissions()->saveMany($permissions);

        return $this;
    }
    /**
     * Get all the permission By name of the table
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param array $permission Permission name Array
     * @return array
     **/
    public function getPermissionsByName(array $permissions)
    {
        return Permission::whereIn('name', $permissions)->get();
    }
    /**
     * Remove all the permission By name of the table
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param array $permission Permission name Array
     * @return $this
     **/
    public function removePermissionByName(...$permission)
    {
        $permissions = $this->getPermissionsByName(array_flatten($permission));

        $this->permissions()->detach($permissions);

        return $this;
    }
    /**
     * Modify the permission By name of the table
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param array $permission Permission name Array
     * @return $this
     **/
    public function modifyPermissionByName(...$permissions)
    {
        $this->permissions()->detach();

        return $this->givePermissionByName($permissions);
    }
}
