<?php

namespace App\Models\Relations;

use App\Models\{Permission, User};

/**
 *  Handles all the relations of the User Model
 */
trait RoleRelation
{

    /**
     * The permissions that belongs to the role.
     *
     * Belongs-to-Many relations with Permission.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id');
    }
    /**
     * The users that belongs to the role.
     *
     * Belongs-to-Many relations with Role.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id');
    }

}
