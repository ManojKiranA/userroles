<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BaseModel;
use App\Models\Relations\PermissionRelation;

class Permission extends BaseModel
{
    use SoftDeletes,PermissionRelation;
}
