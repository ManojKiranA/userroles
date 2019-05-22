<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'user_create',
                'description' => 'Create User',
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 11:26:47',
                'updated_at' => '2019-05-22 11:26:47',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'user_edit',
                'description' => 'Edit User',
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 11:26:56',
                'updated_at' => '2019-05-22 11:26:56',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'user_show',
                'description' => 'Show User',
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 11:27:11',
                'updated_at' => '2019-05-22 11:27:11',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'user_delete',
                'description' => 'Delete User',
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 11:27:53',
                'updated_at' => '2019-05-22 11:27:53',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'user_access',
                'description' => 'Access User List',
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 11:28:08',
                'updated_at' => '2019-05-22 11:28:08',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}