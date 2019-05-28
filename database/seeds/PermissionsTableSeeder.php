<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
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
        $permissionTableArray = Config::get('useraccess.seeders.permissionsTable');
        //iterating throgh each array and creating the new permission
        foreach ( $permissionTableArray as $permissionName => $permissionDescription) 
        {
            $newRecordArray = [ 'name' => $permissionName, 'description' => $permissionDescription , 'created_at' => now(), 'updated_at' => null];
            Permission::create( $newRecordArray);
        }
        
    }
}