<?php
namespace App\Services\Route;

use Illuminate\Support\Facades\Route;

class CrudRoute
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
            ->prefix($this->routePath)
            ->group(function () {
                Route::get('/index/')
                    ->uses($this->controllerName.'@index')
                    ->name('index');
                Route::get('/create/')
                    ->uses($this->controllerName.'@create')
                    ->name('create');
                Route::post('/store/')
                    ->uses($this->controllerName.'@store')
                    ->name('store');
                Route::get('/{'.$this->modelBinder.'}/show/')
                    ->uses($this->controllerName.'@show')
                    ->name('show');
                Route::get('/{'.$this->modelBinder.'}/edit/')
                    ->uses($this->controllerName.'@edit')
                    ->name('edit');
                Route::put('/{'.$this->modelBinder.'}/update/')
                    ->uses($this->controllerName.'@update')
                    ->name('update');
                Route::delete('/{'.$this->modelBinder.'}/delete/')
                    ->uses($this->controllerName.'@destroy')
                    ->name('destroy');
            });
    }
}
