<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
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
