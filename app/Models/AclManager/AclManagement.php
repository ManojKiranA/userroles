<?php

namespace App\Models\AclManager;

/**
 *  Handle all the Role and Permission Management inside the application
 */
trait AclManagement
{
    use RoleManager;
    use PermissionManager;
}
