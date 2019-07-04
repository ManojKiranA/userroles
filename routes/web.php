<?php

use App\Services\Route\CrudSoftRoute;
use Illuminate\Database\Query\Builder;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', static function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('/admin/')
    ->middleware(['auth'])
    ->name('admin.')
    ->namespace('Admin')
    ->group(static function () {

        Route::prefix('/access/')
            ->name('access.')
            ->group(static function () {
            /*
            *Start  Routes For User
            */
           new CrudSoftRoute('users', ['user','deletedUser'], ['UserController','UserDeletedController']);
            /*
            *End  Routes For User
            */
            /*
            *Start Routes For Role
            */
            new CrudSoftRoute('roles',[ 'role','deletedRole'], ['RoleController','RoleDeletedController']);
            /*
            *End Routes For Role
            */

            /*
            *Start Routes For Permission
            */
            new CrudSoftRoute('permissions', 'permission', ['PermissionController','PermisisonDeletedController']);
            /*
            *End Routes For Permission
            */
        });
});
