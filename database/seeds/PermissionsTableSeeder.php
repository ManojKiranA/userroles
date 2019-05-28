<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $permissionTableArray = Config::get('useraccess.seeders.permissionsTable');

        foreach ( $permissionTableArray as $permissionName => $permissionDescription) 
        {
            $newRecordArray = [ 'name' => $permissionName, 'description' => $permissionDescription ];
            Permission::create( $newRecordArray);
        }       
        
    }
}