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
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * If You need to get all the Columns of the Model Table.
     * Useful while including the columns in search
     * @return array
     **/
    public function getTableColumns()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    /**
     * Scope a query to Disable EagerLoading
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
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
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
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
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMysql($query)
    {
        return Str::replaceArray('?', $query->getBindings(), $query->toSql());
    }

    /**
     * Scope a query to Pluck The Multiple Columns
     *
     * This is Used to Pluck the multiple Columns in the table based
     * on the existing query builder instance
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @version 0.0.2
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param string $keyColumn the columns Which is used to set the key of array
     * @param array $extraFileds the list of columns that need to plucked in the table
     * @return \Illuminate\Support\Collection
     * @throws Illuminate\Database\QueryException
     **/
    public function scopePluckMultiple($query, string $keyColumn, array $extraFileds): \Illuminate\Support\Collection
    {
        //pluck all the id based on the query builder instance class
        $keyColumnPluck = $query->pluck($keyColumn)->toArray();

        //iterating Through All Other Fileds and Plucking it each Time
        foreach ((array) $extraFileds as  $eachFiled) {
                $extraFields[$eachFiled] =   $query->pluck($eachFiled)->toArray();
            }

        //now we are done with plucking the Required Columns
        //we need to map all the values to each key

        //get all the keys of extra fileds and sets as array key or index
        $arrayKeys = array_keys($extraFields);
        //get all the extra fileds array and mapping it to eack key
        $arrayValues = array_map(
            static function ($value) use ($arrayKeys) {
                return array_combine($arrayKeys, $value);
            },
            call_user_func_array('array_map', array_merge(
                array( static function () {
                    return func_get_args();
                }),
                $extraFields
            ))
        );
        //now we are done with the array now Convert it to Collection
        return collect(array_combine($keyColumnPluck, $arrayValues));
    }

    /**
     * Scope a query to pluck the Column Value with placeHolder
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePluckWithPlaceHolder($query,string $filedOne,string $filedTwo,string $defaultNullText = null)
    {
        //if the default placehoder text is not passes write our own
        if ($this->isNotPassed($defaultNullText))
        {
            $classNameSpace = explode('\\', get_class());
            $className = end($classNameSpace);
            $defaultNullText = 'Choose Your ' . $className;
        }
        $pluckedCollection = $query->pluck($filedOne, $filedTwo);
        $arrayWithNull = [null => $defaultNullText] + $pluckedCollection->toArray();
        return $arrayWithNull;
    }

    /**
     * Check if the Value is passes in function parameter
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param string $variable The Varibale that needs to be checked
     * @return bool
     **/
    public function isNotPassed(string $variable = null)
    {
        if (! isset($variable) || is_null($variable) || $variable === "") {
            return true;
        }
        return false;
    }

    /**
     * Scope a query for Wild Card Search
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param  \Illuminate\Database\Eloquent\Builder $builderQuery
     * @param string|array $tableFields
     * @param string|array $searchValues
     * @param array|null $splitOn
     * @see https://freek.dev/1182-searching-models-using-a-where-like-query-in-laravel
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($builderQuery, $tableFields, $searchValues, $splitOn = null, $addOwnWildCard = true)
    {
        $tableFields = (array) $tableFields;
        $searchValues = (array) $searchValues;

        if ($splitOn !== null && array_filter($splitOn) !== []) {
            foreach ($searchValues as  $searchTerm) {
                $splitOnSpaceArray[] = explode(chr(1), str_replace($splitOn, chr(1), $searchTerm));
            }
            $searchValues = \Illuminate\Support\Arr::collapse($splitOnSpaceArray);
        }
        if ($addOwnWildCard) {
            foreach ($searchValues as  $searchTerm) {
                $addWildOnEach[] = "%{$searchTerm}%";
            }
            $searchValues = $addWildOnEach;
        }
        $builderQuery->where(function ($query) use ($tableFields, $searchValues) {
            foreach ($tableFields as $attribute) {
                $query->orWhere(function ($query) use ($attribute, $searchValues) {
                    foreach ($searchValues as $searchTerm) {
                        $query->orWhere($attribute, 'LIKE', $searchTerm);
                    }
                });
            }
        });

        return $builderQuery;
    }
}
