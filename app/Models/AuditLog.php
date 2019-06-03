<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Mutators\AuditLogMutator;

class AuditLog extends Model
{
    use AuditLogMutator;
    /**
     * Sets the constant for created event
     **/
    public const CREATED = 'created';

    /**
     * Sets the constant for updated event
     **/
    public const UPDATED = 'updated';

    /**
     * Sets the constant for deleted event
     **/

    public const DELETED = 'deleted';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['description','subject_id','subject_type','user_id','properties','host'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['properties' => 'collection'];
}
