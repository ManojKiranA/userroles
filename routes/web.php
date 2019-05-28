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
Route::prefix('admin/')->middleware(['auth'])->name('admin.')->group(static function(){
    Route::prefix('access/')->name('access.')->group( static function () {
    /*
    *Start Web Routes For UserController
    */
    Route::get('/users/index',  'UserController@index')->name('users.index');
    Route::get('/users/deleted/index',  'UserController@deleted')->name('users.deleted');
    Route::get('/users/create',  'UserController@create')->name('users.create');
    Route::post('/users/store',  'UserController@store')->name('users.store');
    Route::get('/users/{user}/show',  'UserController@show')->name('users.show');
    Route::get('/users/{user}/edit',  'UserController@edit')->name('users.edit');
    Route::put('/users/{user}/update',  'UserController@update')->name('users.update');
    Route::delete('/users/{user}/delete',  'UserController@destroy')->name('users.destroy');
    Route::delete( '/users/deleted/{user}/delete',  'UserController@forceDelete')->name( 'users.forcedelete');
    Route::any('/users/deleted/{user}/restore',  'UserController@restore')->name( 'users.restore');
        

    /*
    *End Web Routes For UserController
    */

    /*
    *Start Web Routes For RoleController  
    */
    Route::get( '/roles/index',  'RoleController@index')->name( 'roles.index');
    Route::get('/roles/create',  'RoleController@create')->name( 'roles.create');
    Route::post( '/roles/store',  'RoleController@store')->name( 'roles.store');
    Route::get('/roles/{role}/show',  'RoleController@show')->name( 'roles.show');
    Route::get( '/roles/{role}/edit',  'RoleController@edit')->name( 'roles.edit');
    Route::put( '/roles/{role}/update',  'RoleController@update')->name( 'roles.update');
    Route::delete( '/roles/{role}/delete',  'RoleController@destroy')->name( 'roles.destroy');
    /*
    *End Web Routes For RoleController
    */
    
    /*
    *Start Web Routes For PermissionController  
    */
    Route::get( '/permissions/index',   'PermissionController@index')->name( 'permissions.index');
    Route::get('/permissions/create',  'PermissionController@create')->name( 'permissions.create');
    Route::post( '/permissions/store',  'PermissionController@store')->name( 'permissions.store');
    Route::get('/permissions/{permission}/show',  'PermissionController@show')->name( 'permissions.show');
    Route::get( '/permissions/{permission}/edit',  'PermissionController@edit')->name( 'permissions.edit');
    Route::put( '/permissions/{permission}/update',  'PermissionController@update')->name( 'permissions.update');
    Route::delete( '/permissions/{permission}/delete',  'PermissionController@destroy')->name( 'permissions.destroy');
    /*
    *End Web Routes For RoleController
    */
    });
});
