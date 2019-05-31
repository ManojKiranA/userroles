<?php
namespace App\Models\Aclsync;

use App\Models\Role;

/**
 * Used to Sync Roles for User
 */
trait UserPermissionSync
{
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
     * @param string $type The Method
     * @return array
     **/
    private function assignUniquePermisison($roles = [], $permissions = [], $type): array
    {
        $roles = array_filter($roles);
        $permissions = array_filter($permissions);

        if ($roles === [] && $permissions === [] || $roles !== [] && $permissions === []) {
            return [];
        } elseif ($roles === [] && $permissions !== []) {
            return $permissions;
        }
        if (is_array($roles)) 
        {
            foreach ($roles as $roleV) {
                $perToEachRole = Role::findOrFail($roleV);
                $perArrToRoles = $perToEachRole->permissions->toArray();
                foreach ($perArrToRoles as $perArrToRoleVal) {
                    $totPermList[] = $perArrToRoleVal['id'];
                }
            }
            $dirPermToRole = array_unique($totPermList);
        }
        if ($type === 'STORE') {
            $difference = array_merge(array_diff($dirPermToRole, $permissions), array_diff($permissions, $dirPermToRole));
        } elseif ($type === 'UPDATE') {
            $difference = array_merge(array_diff($permissions, $dirPermToRole));
        }
        return $difference;
    }
}
