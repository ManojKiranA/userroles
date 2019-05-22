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
}
