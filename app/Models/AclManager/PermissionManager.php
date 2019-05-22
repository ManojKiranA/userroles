<?php

namespace App\Models\AclManager;

/**
 *  Handle all the Permission Management inside the application
 */

trait PermissionManager
{
    use ManagePermissionByName;
    use ManagePermissionById;
}
