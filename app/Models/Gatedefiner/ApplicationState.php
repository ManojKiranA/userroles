<?php

namespace App\Models\Gatedefiner;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

/**
 * Check the Current Application State
 */
trait ApplicationState
{
    /**
     * Check the Current State to map the Permission
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return bool
     **/
    public function checkApplicationState()
    {
        $authorizedUser = Auth::user();
        return ! App::runningInConsole() && ! is_null($authorizedUser);
    }
}
