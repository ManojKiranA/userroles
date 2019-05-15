<?php

namespace App\Models\Relations;

use App\Models\{User};

/**
 *  Handles all the base relation of the application
 */
trait BaseRelation
{
    /**
     * The user that Created the model.
     * 
     * Belongs-to relations with User.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * The user that Updated the model.
     * 
     * Belongs-to relations with User.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    
}
