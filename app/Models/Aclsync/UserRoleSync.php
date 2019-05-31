<?php
namespace App\Models\Aclsync;

/**
 * Used to Sync Roles for User
 */
trait UserRoleSync
{
    /**
     * Sync The Roles to User
     *
     * While Creating the new User We need to assign
     * the role for them so the relation table needs
     * to be filled
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param array $roles The roles array form the form
     * @return $this
     **/
    public function syncRoles(array $roles): void
    {
        $this->roles()
            ->sync( array_filter($roles));
    }
}
