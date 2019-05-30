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
    ->group(static function () {

        Route::prefix('/access/')
            ->name('access.')
            ->group(static function () {

            /*
            *Start Web Routes For UserController
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
                        ->uses('UserController@deleted')
                        ->name('deleted');
                    Route::delete('/{user}/delete/')
                        ->uses('UserController@forceDelete')
                        ->name('forcedelete');
                    Route::patch('/{user}/restore/')
                        ->uses('UserController@restore')
                        ->name('restore');
                });
            });
            /*
            *End Web Routes For UserController
            */

            /*
            *Start Web Routes For RoleController
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
                            ->uses('RoleController@deleted')
                            ->name('deleted');
                        Route::delete('/{role}/delete/')
                            ->uses('RoleController@forceDelete')
                            ->name('forcedelete');
                        Route::patch('/{role}/restore/')
                            ->uses('RoleController@restore')
                            ->name('restore');
                    });
            });
            /*
            *End Web Routes For RoleController
            */

            /*
            *Start Web Routes For PermissionController
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
                            ->uses('PermissionController@deleted')
                            ->name('deleted');
                        Route::delete('/{permission}/delete/')
                            ->uses('PermissionController@forceDelete')
                            ->name('forcedelete');
                        Route::patch('/{permission}/restore/')
                            ->uses('PermissionController@restore')
                            ->name('restore');
                    });
            });
            /*
            *End Web Routes For PermissionController
            */
        });
});
