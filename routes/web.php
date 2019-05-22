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
        Route::get('/users/create',  'UserController@create')->name('users.create');
        Route::post('/users/store',  'UserController@store')->name('users.store');
        Route::get('/users/{user}/show',  'UserController@show')->name('users.show');
        Route::get('/users/{user}/edit',  'UserController@edit')->name('users.edit');
        Route::put('/users/{user}/update',  'UserController@update')->name('users.update');
        Route::delete('/users/{user}/delete',  'UserController@destroy')->name('users.destroy');
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

        Route::resource('permissions', 'PermissionController');
    });
});
