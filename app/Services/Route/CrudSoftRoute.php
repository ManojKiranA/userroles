<?php
namespace App\Services\Route;


use Illuminate\Support\Facades\Route;

class CrudSoftRoute extends SoftRoute
{
    /**
     * Create a new CrudSoftRouteNew Instance.
     *
     * @author Manojkiran.A <manojkrian10031998@gmail.com>
     */

    public function __construct($routePath, $modelBinder,$controllerName)
    {
        $this->routePath = $routePath;
        $this->modelBinder = $modelBinder;
        $this->controllerName = $controllerName;
        $this->buildRoute();
    }

    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function buildRoute()
    {
        new CrudRoute($this->isArrayExists($this->routePath,0),
            $this->isArrayExists($this->modelBinder,0),
            $this->isArrayExists($this->controllerName,0));
            

        new SoftRoute($this->isArrayExists($this->routePath,1),
        
            $this->isArrayExists($this->modelBinder,1),
            $this->isArrayExists($this->controllerName,1));
    }
    /**
     * Check If Array Key Exists
     *
     * @author Manojkiran.A <manojkrian10031998@gmail.com>
     * @return string|array|null
     **/
    public function isArrayExists($array ,  $arrayKey , $returnValue = null)
    {
        if(is_array($array)){
            return array_key_exists($arrayKey,$array) ? $array[$arrayKey] : $returnValue;
        };
        return $array;
        
    }

}
