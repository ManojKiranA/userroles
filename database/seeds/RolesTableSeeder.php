<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Admin',
                'description' => 'Adminstrator of the Application',
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 11:28:48',
                'updated_at' => '2019-05-22 11:28:48',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'User',
                'description' => 'Application User',
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 11:29:28',
                'updated_at' => '2019-05-22 11:29:28',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}