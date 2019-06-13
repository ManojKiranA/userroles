<?php

namespace App\Models;

use App\Models\Scopes\RoleScope;
use App\Models\Traits\Auditable;
use App\Models\Finders\RoleFinder;
use App\Models\Relations\RoleRelation;
use Illuminate\Support\Facades\Config;
use App\Models\Aclsync\RolePermissionSync;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Comman\Html\Buttons\Actionbutton\TableActionButtons;

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
    use SoftDeletes, RoleRelation, TableActionButtons;
    use RoleFinder, RoleScope, RolePermissionSync;
    use Auditable;

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
     * The force delete route that is used for the Model.
     *
     * @var string
     */
    protected $forceDeleteRoute = 'admin.access.roles.forcedelete';

    /**
     * The restore route that is used for the Model.
     *
     * @var string
     */
    protected $restoreRoute = 'admin.access.roles.restore';

    /**
     * Check if the Current Model is Root Role
     *
     * @return bool
     **/
    public function isRoot()
    {
        return $this->name === Config::get('useraccess.rootUserRoleName');
    }
    /**
     * Check if the permisison object can be deleted
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return bool
     **/
    public function isDeletable(): bool
    {
        return $this->permissions->isEmpty() && $this->users->isEmpty();
    }

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 15;
}
