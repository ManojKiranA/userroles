<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return void
     */
    public function run()
    {
        //now we are getting the List of Config Form the useraccess file
        $roleTableArray = Config::get( 'useraccess.seeders.rolesTable');
        //iterating throgh each array and creating the new role
        foreach ( $roleTableArray as $roleName => $roleDescription) 
        {
            $newRecordArray = [ 'name' => $roleName, 'description' => $roleDescription , 'created_at' => now(), 'updated_at' => null];
            Role::create( $newRecordArray);
        }      
        
    }
}