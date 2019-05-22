<?php

namespace App\Models\AclManager;

/**
 *  Handle all the Role Management inside the application
 */
trait RoleManager
{
    use ManageRoleById;
    use ManageRoleByName;

}
