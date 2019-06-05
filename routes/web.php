<?php

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
            Route::prefix('/users/')->name('users.')->group(static function () {
                Route::get('/index/')
                    ->uses('UserController@index')
                    ->name('index');
                Route::get('/create/')
                    ->uses('UserController@create')
                    ->name('create');
                Route::post('/store/')
                    ->uses('UserController@store')
                    ->name('store');
                Route::get('/{user}/show/')
                    ->uses('UserController@show')
                    ->name('show');
                Route::get('/{user}/edit/')
                    ->uses('UserController@edit')
                    ->name('edit');
                Route::put('/{user}/update/')
                    ->uses('UserController@update')
                    ->name('update');
                Route::delete('/{user}/delete/')
                    ->uses('UserController@destroy')
                    ->name('destroy');
                Route::group(['prefix' => '/deleted/'], static function () {
                    Route::get('/index/')
                        ->uses('UserDeletedController@deleted')
                        ->name('deleted');
                    Route::delete('/{user}/delete/')
                        ->uses('UserDeletedController@forceDelete')
                        ->name('forcedelete');
                    Route::patch('/{user}/restore/')
                        ->uses('UserDeletedController@restore')
                        ->name('restore');
                });
            });
            /*
            *End  Routes For User
            */

            /*
            *Start Routes For Role
            */
            Route::prefix('/roles/')
                ->name('roles.')
                ->group(static function () {
                    Route::get('/index/')
                        ->uses('RoleController@index')
                        ->name('index');
                    Route::get('/create/')
                        ->uses('RoleController@create')
                        ->name('create');
                    Route::post('/store/')
                        ->uses('RoleController@store')
                        ->name('store');
                    Route::get('/{role}/show/')
                        ->uses('RoleController@show')
                        ->name('show');
                    Route::get('/{role}/edit/')
                        ->uses('RoleController@edit')
                        ->name('edit');
                    Route::put('/{role}/update/')
                        ->uses('RoleController@update')
                        ->name('update');
                    Route::delete('/{role}/delete/')
                        ->uses('RoleController@destroy')
                        ->name('destroy');
                    Route::group(['prefix' => '/deleted/'], static function () {
                        Route::get('/index/')
                            ->uses('RoleDeletedController@deleted')
                            ->name('deleted');
                        Route::delete('/{role}/delete/')
                            ->uses('RoleDeletedController@forceDelete')
                            ->name('forcedelete');
                        Route::patch('/{role}/restore/')
                            ->uses('RoleDeletedController@restore')
                            ->name('restore');
                    });
            });
            /*
            *End Routes For Role
            */

            /*
            *Start Routes For Permission
            */
            Route::prefix('/permissions/')
                ->name('permissions.')
                ->group(static function () {
                    Route::get('/index/')
                        ->uses('PermissionController@index')
                        ->name('index');
                    Route::get('/create/')
                        ->uses('PermissionController@create')
                        ->name('create');
                    Route::post('/store/')
                        ->uses('PermissionController@store')
                        ->name('store');
                    Route::get('/{permission}/show/')
                        ->uses('PermissionController@show')
                        ->name('show');
                    Route::get('/{permission}/edit/')
                        ->uses('PermissionController@edit')
                        ->name('edit');
                    Route::put('/{permission}/update/')
                        ->uses('PermissionController@update')
                        ->name('update');
                    Route::delete('/{permission}/delete/')
                        ->uses('PermissionController@destroy')
                        ->name('destroy');
                    Route::group(['prefix' => '/deleted/'], static function () {
                        Route::get('/index/')
                            ->uses('PermisisonDeletedController@deleted')
                            ->name('deleted');
                        Route::delete('/{permission}/delete/')
                            ->uses('PermisisonDeletedController@forceDelete')
                            ->name('forcedelete');
                        Route::patch('/{permission}/restore/')
                            ->uses('PermisisonDeletedController@restore')
                            ->name('restore');
                    });
            });
            /*
            *End Routes For Permission
            */
        });
});
