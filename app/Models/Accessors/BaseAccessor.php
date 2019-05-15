<?php

namespace App\Models\Accessors;

use Illuminate\Support\Carbon;

/**
 *  Handle all the Comman Accessor across the application
 */
trait BaseAccessor
{
    /**
     * Accessor for formatting the created_at field
     *
     * Formats the created_at attribute with carbon
     *
     * @author Manojkiran.A <manojkiran1003199@gmail.com>
     * @return string
     **/
    public function getCreatedAtAttribute()
    {
        return Carbon::createFromDate($this->attributes['created_at'])->toFormattedDateString();
    }

    /**
     * Accessor for formatting the created_by field
     *
     * Formats the created_by attribute with the user model 
     *
     * @author Manojkiran.A <manojkiran1003199@gmail.com>
     * @return string
     **/
    public function getCreatedByNameAttribute()
    {
        return $this->creator->name ?? null;
    }

    /**
     * Accessor for formatting the created_at field
     *
     * Formats the created_by attribute with the user model 
     *
     * @author Manojkiran.A <manojkiran1003199@gmail.com>
     * @return string
     **/
    public function getCreatedByEmailAttribute()
    {
        return $this->creator->email ?? null;
    }

    /**
     * Accessor for formatting the updated_by field
     *
     * Formats the updated_by attribute with the user model 
     *
     * @author Manojkiran.A <manojkiran1003199@gmail.com>
     * @return string
     **/
    public function getUpdatedByNameAttribute()
    {
        return $this->updater->name ?? null;
    }

    /**
     * Accessor for formatting the updated_by field
     *
     * Formats the updated_by attribute with the user model 
     *
     * @author Manojkiran.A <manojkiran1003199@gmail.com>
     * @return string
     **/
    public function getUpdatedByEmailAttribute()
    {
        return $this->updater->email ?? null;
    }
}
