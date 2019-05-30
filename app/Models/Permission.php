<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Relations\PermissionRelation;
use App\Models\Comman\Html\Buttons\Actionbutton\TableActionButtons;

/**
 * Class App\Models\Permission
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

class Permission extends BaseModel
{
    use SoftDeletes, PermissionRelation, TableActionButtons;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permissions';
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
    protected $editRoute = 'admin.access.permissions.edit';

    /**
     * The delete route that is used for the Model.
     *
     * @var string
     */
    protected $deleteRoute = 'admin.access.permissions.destroy';

    /**
     * The show route that is used for the Model.
     *
     * @var string
     */
    protected $showRoute = 'admin.access.permissions.show';

    /**
     * The force delete route that is used for the Model.
     *
     * @var string
     */
    protected $forceDeleteRoute = 'admin.access.permissions.forcedelete';

    /**
     * The restore route that is used for the Model.
     *
     * @var string
     */
    protected $restoreRoute = 'admin.access.permissions.restore';

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 20;

    /**
     * Check if the permisison object can be deleted
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return bool
     **/
    public function isDeletable(): bool
    {
        return $this->roles->isEmpty() && $this->users->isEmpty();
    }
    /**
     * Sync the Roles to Permission
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param array $roles Array of Role id's
     * @return void
     **/
    public function syncRoles(array $roles): void
    {
        $this->roles()->sync(array_filter($roles));
    }
}
