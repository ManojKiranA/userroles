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
}
