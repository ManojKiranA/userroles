<?php
namespace App\Services\Route;


use Illuminate\Support\Facades\Route;

class SoftRoute extends CrudRoute
{
    /**
     * Create a new CrudRoute Instance.
     *
     * @author Manojkiran.A <manojkrian10031998@gmail.com>
     * @param  string   $routePath
     * @param string $modelBinder
     */

    public function __construct($routePath,$modelBinder,$controllerName)
    {
        $this->routePath = $routePath;
        $this->modelBinder = $modelBinder;
        $this->controllerName = $controllerName;
        $this->buildRoute();
    }

    /**
     * Generates the Crud Routes
     *
     * Generate the Routes for the Crud operation
     * of the Model
     *
     * @author Manojkiran.A <manojkrian10031998@gmail.com>
     * @return void
     **/
    public function buildRoute()
    {
       Route::name($this->routePath.'.')
                    ->prefix($this->routePath.'/deleted/')
                    ->group(function () {
                        
                        Route::get('/index/')
                            ->uses($this->controllerName.'@deleted')
                            ->name('deleted');
                        Route::delete('/{'.$this->modelBinder.'}/delete/')
                            ->uses($this->controllerName.'@forceDelete')
                            ->name('forcedelete');
                        Route::patch('/{'.$this->modelBinder.'}/restore/')
                            ->uses($this->controllerName.'@restore')
                            ->name('restore');
                    });
    }

    
}
