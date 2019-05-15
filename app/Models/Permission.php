<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BaseModel;
use App\Models\Relations\PermissionRelation;

class Permission extends BaseModel
{
    use SoftDeletes,PermissionRelation;

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
}
