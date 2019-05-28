<?php

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

            'superUserData' => [
                'name' => 'ROOT_USER',
            ],
            
        ],
        'permissionsTable' => [
            'user_access' => 'Show a user list',
            'user_create' => 'Create New User',
            'user_edit' => 'Edit a user',
            'user_show' => 'Show a user',
            'user_delete' => 'Show a user',            
        ],
    ],

];