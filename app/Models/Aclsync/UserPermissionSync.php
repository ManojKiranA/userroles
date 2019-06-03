<?php
namespace App\Models\Aclsync;/**
 * Used to Sync Roles for User
 */
trait UserPermissionSync
{
    use UserPermissionUniqueSync;
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
}
