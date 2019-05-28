<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Relations\RoleRelation;
use App\Models\Comman\Html\Buttons\Actionbutton\TableActionButtons;
use App\Models\AclManager\AclManagement;
use Illuminate\Support\Facades\Config;

/**
 * Class App\Models\Role
 *
 * @package     App\Models
 * @property    int     $id
 * @property    string  $name
 * @property    string  $description
 * @property    int     $created_by
 * @property    int     $updated_by
 * @property    string  $created_at
 * @property    string  $updated_at
 * @property    string  $deleted_at
 */

class Role extends BaseModel
{
    use SoftDeletes, RoleRelation, TableActionButtons, AclManagement;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'roles';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'name', 'description'];

    /**
     * The edit route that is used for the Model.
     *
     * @var string
     */
    protected $editRoute = 'admin.access.roles.edit';

    /**
     * The delete route that is used for the Model.
     *
     * @var string
     */
    protected $deleteRoute = 'admin.access.roles.destroy';

    /**
     * The show route that is used for the Model.
     *
     * @var string
     */
    protected $showRoute = 'admin.access.roles.show';

    /**
     * Scope a query to only exclude the root user role in list
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExcludeRootRole($query)
    {
        return $query->where('name','!=',Config::get('useraccess.rootUserRoleName'));
    }
}
