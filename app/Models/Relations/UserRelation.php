<?php

namespace App\Models\Relations;

use App\Models\{Role,Permission};

/**
 *  Handles all the relations of the User Model
 */
trait UserRelation
{
    /**
     * The roles that belongs to the user.
     *
     * Belongs-to-Many relations with Role.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }
    /**
     * The permissions that belongs to the user.
     *
     * Belongs-to-Many relations with Permission.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_user', 'user_id', 'permission_id');
    }
}
