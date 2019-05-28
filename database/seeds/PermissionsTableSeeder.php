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
                'name' => 'user_access',
                'description' => 'Show User Lits',
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 11:26:47',
                'updated_at' => '2019-05-22 11:26:47',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'user_create',
                'description' => 'Create New User',
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
                'description' => 'Show a user',
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 11:27:11',
                'updated_at' => '2019-05-22 11:27:11',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'user_edit',
                'description' => 'Edit a user',
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 11:27:53',
                'updated_at' => '2019-05-22 11:27:53',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'user_delete',
                'description' => 'Delete a user',
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 11:28:08',
                'updated_at' => '2019-05-22 11:28:08',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'user_deleted_access',
                'description' => 'Show Deleted User Lits',
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-28 10:54:15',
                'updated_at' => '2019-05-28 10:54:15',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'user_force_delete',
                'description' => 'Permanently Deltes the Deleted User',
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-28 10:55:21',
                'updated_at' => '2019-05-28 10:55:21',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'user_restore',
                'description' => 'Restores the Deleted User',
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-28 10:55:49',
                'updated_at' => '2019-05-28 10:55:49',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}