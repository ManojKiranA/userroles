<?php


//kindly Change this configuration

//determines the root user  name
$rootUserName = 'Root';

//determines the root user email
$rootUserEmail = 'superuser@application.com';

//determines the root user password
$rootUserPassword = 'superuser@welcome123';


//if You are not developer don't change this
//determines the root user role name
$rootUserRoleName = 'ROOT_USER';

return [

    /*
    |--------------------------------------------------------------------------
    | Table Names
    |--------------------------------------------------------------------------
    |
    | Here You can find the list of table name that is used for the user Acl
    | of the  application.
    |
    */

    /*
    * When using the Roles we need to know which 
    * table should be used to retrieve your roles. We have chosen a basic
    * default value but you may easily change it to any table you like.
    */

    
    'rolesTable' => 'roles',

    /*
    * When using the Permissions we need to know which 
    * table should be used to retrieve your roles. We have chosen a basic
    * default value but you may easily change it to any table you like.
    */

    'permissionsTable' => 'permissions',

    /*
    * When using the users has permissions , we need to know which
    * table should be used to retrieve users permissions. We have chosen a
    * basic default value but you may easily change it to any table you like.
    */

    'userPermissionsTable' => 'permission_user',

    /*
    * When using the users has roles, we need to know which
    * table should be used to retrieve your user roles. We have chosen a
    * basic default value but you may easily change it to any table you like.
    */

    'userRolesTable' => 'role_user',

    /*
    * When using the permission has roles, we need to know which
    * table should be used to retrieve your role permissions. We have chosen a
    * basic default value but you may easily change it to any table you like.
    */

    'rolePermissionsTable' => 'permission_role',

    //if You are not developer don't change after this part

    'rootUserRoleName' => $rootUserRoleName,

    //here we are defining the superadminstrator of the application
    'seeders' => [
        
        'usersTable' => [
            'superUserData' => [
                'name' => 'Super Administrator',
                'email' => 'superuser@application.com',
                'email_verified_at' => now(),
            ],
        ],

        'rolesTable' => [
                $rootUserRoleName => 'Root User of the Application',
                'ADMIN' => 'Adminstrator of the Application',
        ],
        'permissionsTable' => [

            'user_access' => 'Show a User List',
            'user_create' => 'Create New User',
            'user_show' => 'Show a user',
            'user_edit' => 'Edit a user',
            'user_delete' => 'Delete a user',
            'user_deleted_access' => 'Show Deleted User List',
            'user_force_delete' => 'Permanently Deltes the Deleted User',
            'user_restore' => 'Restores the Deleted User',

            'role_access' => 'Show a Role List',
            'role_create' => 'Create New Role',
            'role_show' => 'Show a role',
            'role_edit' => 'Edit a role',
            'role_delete' => 'Edit a role',
            'role_deleted_access' => 'Show Deleted Role List',
            'role_force_delete' => 'Permanently Deltes the Deleted Role',
            'role_restore' => 'Restores the Deleted Role',

            'permission_access' => 'Show a Permission List',
            'permission_create' => 'Create New Permission',
            'permission_show' => 'Show a permission',
            'permission_edit' => 'Edit a permission',
            'permission_delete' => 'Edit a permission',
            'permission_deleted_access' => 'Show Deleted Permission List',
            'permission_force_delete' => 'Permanently Deltes the Deleted Permission',
            'permission_restore' => 'Restores the Deleted Permission',
        ],
    ],

];