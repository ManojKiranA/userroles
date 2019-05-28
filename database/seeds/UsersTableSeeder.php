<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@app.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$6EwDwpk7u94MNYHFyVp6L.iF/qWdX1kWK9SJoqDrMYaRhBntrnl42',
                'remember_token' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2019-05-22 11:24:13',
                'updated_at' => '2019-05-22 11:24:13',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}