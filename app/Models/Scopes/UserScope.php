<?php

namespace App\Models\Scopes;

use Illuminate\Support\Facades\Config;

/**
 * Contains all the Scopes of the User Model
 */
trait UserScope
{
    /**
     * Scope a query to only exclude the root user role in list
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExcludeRootUser($query)
    {
        return $query->where('email', '!=', Config::get('useraccess.seeders.usersTable.superUserData.email'));
    }
}
