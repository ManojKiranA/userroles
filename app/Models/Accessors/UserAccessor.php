<?php

namespace App\Models\Accessors;

use Illuminate\Support\Facades\Hash;

/**
 *  Handle all the User Accessor across the application
 */
trait UserAccessor
{
    /**
     * Set Accessor for the password Attribute
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param string $password The Password Filed Value
     * @return void
     **/
    public function setPasswordAttribute(string $password = null):void
    {
        if (!is_null($password)) 
        {
            $this->attributes['password'] = Hash::make($password);
        }
    }
}