<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Relations\BaseRelation;
use App\Models\Accessors\BaseAccessor;
use App\Models\Finders\BaseFinder;
use Illuminate\Support\Str;

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

    /**
     * Scope a query to order by `created_at` ASC"
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param string $fieldName The filed Name of the Model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOldest($query,string $fieldName = 'created_at')
    {
        return $query->orderBy( $fieldName, 'ASC');
    }

    /**
     * Scope a query to get the sql Query with value
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMysql($query)
    {
        return Str::replaceArray('?', $query->getBindings(), $query->toSql());
    }
}
