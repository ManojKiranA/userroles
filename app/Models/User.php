<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Relations\UserRelation;

class User extends Authenticatable
{
    use Notifiable, UserRelation;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 20;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

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
     * @param $column
     * @param $value
     *
     * @return mixed
     */
    public  function scopeFindByColumn($query,$column, $value)
    {
        return $query->where($column, $value)->first();
    }

    /**
     * @function     generateAlphaNumericSeries
     * @author       Manojkiran <manojkiran10031998@gmail.com>
     * @param        string  $queryMethod
     * @param        string  $modelTableName
     * @param        string or array  $nameSpace
     * @param        string  $autoGenerateFiledName
     * @param        string  $autogenerateStart
     * @param        string  $autoGeneratePrefix
     * @param        string  $autoIncrementType
     * @param        string  $versionCount
     * @param        boolean  $includeSoftDeleted
     * @param        array  $whereArray
     * @usage        Generate the Squence Numbers Based on the Database Existing Values
     * @version      1.4
     **/

    /*
    |--------------------------------------------------------------------------
    | Generate the Squence Numbers Based on the Database Existing Values VERSION AND SERIES CAN BE GENERATED
    |--------------------------------------------------------------------------
    |
    |Usage:
    |Option 1 :
    |generateAlphaNumericSeries('MODEL','Post','App','post_auto_inc',100,'POS','SERIES',null,false,null)
    |Option 2 :
    |generateAlphaNumericSeries('MODEL','Post','App','post_auto_inc',100,'POS','SERIES',null,false,[whereCondition])
    |Option 3 :
    |generateAlphaNumericSeries('MODEL','Post','App','post_auto_inc',100,null,'SERIES',null,false,[whereCondition])
    |Option 4 :
    |generateAlphaNumericSeries('TABLE','posts',null,'post_auto_inc',100,'POS','SERIES',null,false,[whereCondition])
    |
    |Help:
    |   First Argument($modelQuery) = 'Query for Model';
    |
    */
    public static function generateAlphaNumericSeries(
            $queryMethod='MODEL',$modelTableName='',$nameSpace= '',$autoGenerateFiledName='',$autogenerateStart = '',
            $autoGeneratePrefix='',$autoIncrementType='SERIES',$versionCount='',$includeSoftDeleted = false, $whereArray = [])
        {

            $generatedAutogen = '';

            if ($queryMethod == 'MODEL') 
            {
                $currentModelWithNameSpace = static::strToModel($modelTableName,$nameSpace);

                if ($includeSoftDeleted == true) 
                {
                    $listFiledValues = $currentModelWithNameSpace::select($autoGenerateFiledName)
                                                    ->withTrashed()
                                                    ->where($whereArray)
                                                    ->get();
                }
                //creating the query to select the $autoGenerateFiledName form current model
                $listFiledValues = $currentModelWithNameSpace::select($autoGenerateFiledName)->where($whereArray)->get();
            }elseif ($queryMethod == 'TABLE') 
            {
                //if the current database has the table
                if(Schema::hasTable($modelTableName)) 
                {
                    if ($includeSoftDeleted == true) 
                    {
                        $listFiledValues = DB::table($modelTableName)
                                                ->select($autoGenerateFiledName)
                                                ->where($whereArray)
                                                ->get();
                    }

                    $listFiledValues = DB::table($modelTableName)
                                            ->select($autoGenerateFiledName)
                                            ->where($whereArray)
                                            ->whereNull('deleted_at')
                                            ->get();
                }else
                {//else throw the table not found exception
                    throw new \Exception("Table With Name : $modelTableName ", E_USER_ERROR);
                }
            }
            

            //if the current model collection is not empty
            if ($listFiledValues->isNotEmpty()) 
            {
                    foreach($listFiledValues as $listFiledValue)
                    {
                        //stroring the all list of fileds into the array
                        $totalListArrays[] = $listFiledValue->$autoGenerateFiledName;
                    }
                    //if the $autoGeneratePrefix is  passed to function
                    if (isset($autoGeneratePrefix) || !is_null($autoGeneratePrefix) || $autoGeneratePrefix != "") 
                    {
                        foreach($totalListArrays as $totalListArray)
                        {
                            $stringRemovedTotalListArray[] = substr($totalListArray,strlen($autoGeneratePrefix));
                        }
                    }                    
            }
            //setting the default to SERIES 
            if (!isset($autoIncrementType) || is_null($autoIncrementType) || $autoIncrementType === "") 
            {
                $autoIncrementType = 'SERIES';
            } 

                switch ($autoIncrementType) 
                {
                    
                    case 'SERIES':
                            //if the autoincrement series does not have prefix the condition is satisfied and the function will enter into it
                                if (!isset($autoGeneratePrefix) || is_null($autoGeneratePrefix) || $autoGeneratePrefix === "") 
                                {
                    
                                    // Except for  the first time the result will be $maximumValue increment by one
                                    if ($listFiledValues->isNotEmpty()) 
                                    {
                                        //get the max value from the array
                                        $maximumValue = max($totalListArrays);
                                        //incremet one value from max array
                                        $generatedAutogen = ++$maximumValue;
                                    }
                                    //for  the first time the columns will be empty so result will be $autogenerateStart
                                    elseif ($listFiledValues->isEmpty()) 
                                    {
                                        $generatedAutogen = $autogenerateStart;
                                    }
                                }
                                //if the autoincrement series does  have prefix the condition is satisfied and the function will enter into it
                                elseif (isset($autoGeneratePrefix) || !is_null($autoGeneratePrefix) || $autoGeneratePrefix != "") 
                                {
                                    
                                    // Except for  the first time the result will be $maximumValue increment by one
                                    if ($listFiledValues->isNotEmpty())
                                    {
                                        //get the max value from the array
                                        $maximumValue = max($stringRemovedTotalListArray);
                                        //incremet one value from max array
                                        $generatedAutogen = $autoGeneratePrefix.++$maximumValue;
                                    }
                                    //for  the first time the columns will be empty so result will be $autogenerateStart
                                    elseif ($listFiledValues->isEmpty())
                                    {
                                        $generatedAutogen = $autoGeneratePrefix.$autogenerateStart;
                                    }
                                }
                        break;

                    case 'VERSION':

                            if (!isset($versionCount) || is_null($versionCount) || $versionCount === "" && $versionCount < 1 || $versionCount > 3) 
                            {
                                return 'Version Can Generated between count 1 or 3';
                            }

                            //starting number for main version 
                            $mainVersionStart = 1;
                            //ending number for main version
                            $mainVersionEnd = 10;
                            //starting number for cluster version 
                            $clusterVersionStart = 1;
                            //ending number for cluster version
                            $clusterVersionEnd = 10;
                            //starting number for min version 
                            $minVersionStart = 1;
                            //ending number for min version
                            $minVersionEnd = 10;

                            for ($mainVersion = $mainVersionStart; $mainVersion  <= $mainVersionEnd ; $mainVersion++) 
                            { 
                              $mainVersionArray[] = $mainVersion;

                              for ($clusterVersion = $clusterVersionStart; $clusterVersion <= $clusterVersionEnd; $clusterVersion++) 
                              { 
                                  $mainVersionClusterArray[] = $mainVersion.'.'.$clusterVersion;

                                  for ($minVersion = $minVersionStart; $minVersion <= $minVersionEnd ; $minVersion++) 
                                  { 
                                      $mainVersionClusterMinArray[] = $mainVersion.'.'.$clusterVersion.'.'.$minVersion; 
                                  }
                              }
                            }


                            //if the autoincrement series does not have prefix the condition is satisfied and the function will enter into it
                                if (!isset($autoGeneratePrefix) || is_null($autoGeneratePrefix) || $autoGeneratePrefix === "") 
                                {
                                    // Except for  the first time the result will be $maximumValue increment by one
                                    if ($listFiledValues->isNotEmpty()) 
                                    {
                                        //get the max value from the array
                                        $currentVersionMax = max($totalListArrays);

                                        if ($versionCount == 1) 
                                        {
                                            $currentVersionKey = array_search($currentVersionMax, $mainVersionArray,true);

                                            $nextVersion = $currentVersionKey + 1;
                
                                            $generatedAutogen =  $mainVersionArray[$nextVersion];

                                        }

                                        if ($versionCount == 2) 
                                        {
                                            $currentVersionKey = array_search($currentVersionMax, $mainVersionClusterArray,true);

                                            $nextVersion = $currentVersionKey + 1;
                
                                            $generatedAutogen =  $mainVersionClusterArray[$nextVersion];

                                        }

                                        if ($versionCount == 3) 
                                        {
                                            $currentVersionKey = array_search($currentVersionMax, $mainVersionClusterMinArray,true);

                                            $nextVersion = $currentVersionKey + 1;
                
                                            $generatedAutogen =  $mainVersionClusterMinArray[$nextVersion];

                                        }                                  
                                        
                                    }
                                    //for  the first time the columns will be empty so result will be $autogenerateStart
                                    elseif ($listFiledValues->isEmpty()) 
                                    {
                                        if ($versionCount == 1 ) 
                                        {
                                            $generatedAutogen =  $mainVersionStart;
                                        }

                                        if ($versionCount == 2 ) 
                                        {
                                            $generatedAutogen =  $mainVersionStart.'.'.$clusterVersionStart;
                                        }

                                        if ($versionCount == 3 ) 
                                        {
                                            $generatedAutogen =  $mainVersionStart.'.'.$clusterVersionStart.'.'.$minVersionStart;
                                        }

                                    }
                                }

                                elseif (isset($autoGeneratePrefix) || !is_null($autoGeneratePrefix) || $autoGeneratePrefix != "") 
                                {
                                    // Except for  the first time the result will be $maximumValue increment by one
                                    if ($listFiledValues->isNotEmpty())
                                    {
                                        
                                        //get the max value from the array
                                        $currentVersionMax = max($stringRemovedTotalListArray);

                                        //incremet one value from max array
                                        if ($versionCount == 1) 
                                        {
                                            $currentVersionKey = array_search($currentVersionMax, $mainVersionArray,true);

                                            $nextVersion = $currentVersionKey + 1;
                
                                            $generatedAutogen =  $autoGeneratePrefix.$mainVersionArray[$nextVersion];

                                        }

                                        if ($versionCount == 2) 
                                        {
                                            $currentVersionKey = array_search($currentVersionMax, $mainVersionClusterArray,true);

                                            $nextVersion = $currentVersionKey + 1;
                
                                            $generatedAutogen =  $autoGeneratePrefix.$mainVersionClusterArray[$nextVersion];

                                        }

                                        if ($versionCount == 3) 
                                        {
                                            $currentVersionKey = array_search($currentVersionMax, $mainVersionClusterMinArray,true);

                                            $nextVersion = $currentVersionKey + 1;
                
                                            $generatedAutogen =  $autoGeneratePrefix.$mainVersionClusterMinArray[$nextVersion];

                                        } 
                                    }
                                    //for  the first time the columns will be empty so result will be $autogenerateStart
                                    elseif ($listFiledValues->isEmpty())
                                    {
                                        
                                        if ($versionCount == 1 ) 
                                        {
                                            $generatedAutogen =  $autoGeneratePrefix.$mainVersionStart;
                                        }

                                        if ($versionCount == 2 ) 
                                        {
                                            $generatedAutogen =  $autoGeneratePrefix.$mainVersionStart.'.'.$clusterVersionStart;
                                        }

                                        if ($versionCount == 3 ) 
                                        {
                                            $generatedAutogen =  $autoGeneratePrefix.$mainVersionStart.'.'.$clusterVersionStart.'.'.$minVersionStart;
                                        }
                                    }
                                }
                        break;

                    default:

                    throw new Exception("Only SERIES and VERSION can be Generated", E_USER_ERROR);

                    break;
                }
                
            return $generatedAutogen;            
        }

    /**
     * @function     strToModel
     * @author       Manojkiran <manojkiran10031998@gmail.com>
     * @param        string  $modelTableName
     * @param        string  $nameSpace
     * @usage        Convert String To Model
     * @version      1.3
     **/

    /*
    |--------------------------------------------------------------------------
    | Convert String To Model
    |--------------------------------------------------------------------------
    |
    |Usage:
    |strToModel('Post',null);
    |strToModel('Post',App);
    |strToModel('Post',[App,'Models','Base','Test']);
    |Help:
    |   First Argument($modelTableName) = 'Model Name';
    |   Second Argument($nameSpace) = 'Name Space of Current Model';
    |
    */

    public static function strToModel($modelTableName = '', $nameSpace = '')
    {
        //if the given name space iin array the implode to string with \\
        if (is_array($nameSpace)) {
            $nameSpace =  implode('\\', $nameSpace);
        }
        //by default laravel ships with name space App so while is $nameSpace is not passed considering the
        // model namespace as App
        if (empty($nameSpace) || is_null($nameSpace) || $nameSpace === "") {
            $modelTableNameWithNameSpace = "App" . '\\' . $modelTableName;
        }
        //if you are using custom name space such as App\Models\Base\Country.php
        //$namespce must be ['App','Models','Base']
        if (is_array($nameSpace)) {
            $modelTableNameWithNameSpace = $nameSpace . '\\' . $modelTableName;
        }
        //if you are passing Such as App in name space
        elseif (!is_array($nameSpace) && !empty($nameSpace) && !is_null($nameSpace) && $nameSpace !== "") {
            $modelTableNameWithNameSpace = $nameSpace . '\\' . $modelTableName;
        }
        //if the class exist with current namespace convert to container instance.
        if (class_exists($modelTableNameWithNameSpace)) {
            // $currentModelWithNameSpace = Container::getInstance()->make($modelTableNameWithNameSpace);
            // use Illuminate\Container\Container;
            $currentModelWithNameSpace = app($modelTableNameWithNameSpace);
        }
        //else throw the class not found exception
        else {
            throw new \Exception("Unable to find Model : $modelTableName With NameSpace $nameSpace", E_USER_ERROR);
        }

        return $currentModelWithNameSpace;
    }



}
