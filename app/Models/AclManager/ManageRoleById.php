<?php

namespace App\Models\AclManager;

use App\Models\Role;

/**
 *  Handle all the Role Management by id inside the application
 */
trait ManageRoleById
{
    /**
     * Give the Role By id of the table
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param mixed $role Role Id Array
     * @return $this
     **/
    public function giveRoleById(...$role)
    {
        $roles = $this->getRolesById(array_flatten($role));

        if ($roles === null) {
            return $this;
        }
        $this->roles()->saveMany($roles);

        return $this;
    }

    /**
     * Get all the role By id of the table
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param array $roles Role Id Array
     * @return array
     **/
    public function getRolesById(array $roles)
    {
        return Role::whereIn('id', $roles)->get();
    }

    /**
     * Remove all the role By id of the table
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param array $role Role Id Array
     * @return $this
     **/
    public function removeRoleById(...$role)
    {
        $roles = $this->getRolesById(array_flatten($role));

        $this->roles()->detach($roles);

        return $this;
    }

    /**
     * Modify the role By id of the table
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param array $roles Permission Id Array
     * @return $this
     **/
    public function modifyRoleById(...$roles)
    {

        $this->roles()->detach();

        return $this->giveRoleById($roles);
    }
}