<?php

namespace App\Models\Gatedefiner;

use Illuminate\Support\Facades\Gate;

/**
 * Define the Permission
 */
trait DefineGate
{
    /**
     * Defines the Array of the Gates
     *
     *
     * @param array $gatArray Array of Permisisons
     * @return void
     **/
    public function defineGate(array $allPermissions): void
    {
        foreach ($allPermissions as $allPermission) {
            Gate::define($allPermission, static function () {
                return true;
            });
        }
    }
}
