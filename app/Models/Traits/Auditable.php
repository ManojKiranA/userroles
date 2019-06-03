<?php

namespace App\Models\Traits;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;


trait Auditable
{
    /**
     * Boot the function on the Model Events
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return void
     **/
    public static function bootAuditable()
    {
        static::created(function (Model $model) {
            self::storeAudit(AuditLog::CREATED, $model);
        });

        static::updated(function (Model $model) {
            self::storeAudit(AuditLog::UPDATED, $model);
        });

        static::deleted(function (Model $model) {
            self::storeAudit(AuditLog::DELETED, $model);
        });
    }

    /**
     * Creates the new audit Log on Model Booting
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param string $description
     * @param Illuminate\Database\Eloquent\Model $model
     * @return void
     **/
    
    protected static function storeAudit(string $description, Model $model)
    {
        if (self::checkApplicationState()) 
        {
            $audiLogArray =  [
            'description'  => $description,
            'subject_id'   => $model->id ?? null,
            'subject_type' => get_class($model) ?? null,
            'user_id'      => '',
            'properties'   => $model ?? null,
            'host'         => '',
            ];

            AuditLog::create($audiLogArray);
        }
        
    }
    /**
     * Check the Current State to map the Permission
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return bool
     **/
    public static function checkApplicationState()
    {
        $authorizedUser = Auth::user();
        return ! App::runningInConsole() && ! is_null($authorizedUser);
    }
}
