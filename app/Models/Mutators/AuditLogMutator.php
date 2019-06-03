<?php

namespace App\Models\Mutators;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

/**
 * 
 */
trait AuditLogMutator
{
    /**
     * Set Accessor for the user_id Attribute
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return void
     **/
    public function setUserIdAttribute()
    {
        $this->attributes['user_id'] = Auth::user()->id ?? null;
    }

    /**
     * Set Accessor for the host Attribute
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return void
     **/
    public function setHostAttribute()
    {
        $this->attributes['host'] = Request::ip() ?? null;
    }

}
