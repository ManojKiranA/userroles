<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Relations\BaseRelation;
use App\Models\Accessors\BaseAccessor;
use App\Models\Finders\BaseFinder;

class BaseModel extends Model
{
    use BaseRelation,BaseAccessor, BaseFinder;
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
}
