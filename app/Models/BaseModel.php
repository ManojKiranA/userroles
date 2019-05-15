<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use App\Models\Relations\BaseRelation;
use App\Models\Accessors\BaseAccessor;

class BaseModel extends Model
{
    use BaseRelation,BaseAccessor;
    /**
     * Shows All the columns of the Corresponding Table of Model
     *
     * If You need to get all the Columns of the Model Table.
     * Useful while including the columns in search
     *
     * @return array
     **/
    public function getTableColumns()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
    

    /**
     * Scope a query to Disable EagerLoading
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithoutRelations($query)
    {
        return $query->setEagerLoads([]);
    }   

    /**
     * The relations to eager load on every query of Model.
     * Works For all the model that extending the class.
     * If You need the Custom relation add in the respective model.
     *
     * @var array
     */
    protected $with = ['creator','updater'];

    /**
     * The number of models to return for pagination.
     * Works For all the model that extending the class.
     * If You need the Custom pagination add in the respective model.
     *
     * @var int
     */
    protected $perPage = 20;
    
    /**
     * The attributes that should be mutated to dates.
     * Works For all the model that extending the class.
     * If You need the Custom date mutators add in the respective model.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    
}
