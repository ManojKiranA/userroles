<?php

namespace App\Models\AclManager;

use App\Models\Role;

/**
 *  Handle all the Role Management by id inside the application
 */
trait ManageRoleByName
{
    /**
     * Give the Role By name of the table
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param mixed $role Role name Array
     * @return $this
     **/
    public function giveRoleByName(...$role)
    {
        $roles = $this->getRolesByName(array_flatten($role));

        if ($roles === null) {
            return $this;
        }
        $this->roles()->saveMany($roles);

        return $this;
    }

    /**
     * Get all the role By name of the table
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param array $roles Role name Array
     * @return array
     **/
    public function getRolesByName(array $roles)
    {
        return Role::whereIn('name', $roles)->get();
    }
    /**
     * Remove all the role By name of the table
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param array $role Role name Array
     * @return $this
     **/
    public function removeRoleByName(...$role)
    {
        $roles = $this->getRolesByName(array_flatten($role));

        $this->roles()->detach($roles);

        return $this;
    }
    /**
     * Modify the role By name of the table
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param array $roles Permission name Array
     * @return $this
     **/
    public function modifyRoleByName(...$roles)
    {

        $this->roles()->detach();

        return $this->giveRoleByName($roles);
    }
}
