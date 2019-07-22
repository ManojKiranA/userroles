<?php

namespace App\Models\Relations;

use App\Models\User;
use App\Models\Role;

trait PermissionRelation

{
    /**
     * The roles that belongs to the permissions.
     *
     * Belongs-to-Many relations with Role.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role', 'permission_id', 'role_id')->withTimestamps();
    }
    /**
     * The users that belongs to the permissions.
     *
     * Belongs-to-Many relations with Permission.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'permission_user', 'permission_id', 'user_id')->withTimestamps();
    }
}
