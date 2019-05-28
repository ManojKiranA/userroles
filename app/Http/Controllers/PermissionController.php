<?php

namespace App\Http\Controllers;

use App\Models\{Permission, Role};
use Illuminate\Support\Facades\View;
use Illuminate\Http\{Request as HttpRequest};
use App\Http\Requests\PermissionUpdateRequest;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\PermissionStoreRequest;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( HttpRequest $request)
    {
        $request = $request;
        //getting the list of user by latest and passing to length aware paginator instance
        $permissionList = Permission::latest()->paginate();

        //now we are collecting the list of variables that need to passes to view
        $viewShare = compact( 'permissionList');

        //now we are returning the view
        return View::make('admin.access.permissions.index', $viewShare);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roleList = Role::excludeRootRole()->pluckWithPlaceHolder('name','id','Choose Role');
        //now we are collecting the list of variables that need to passes to view
        $viewShare = [ 'roleList' => $roleList];
        //now we are returning the view
        return View::make('admin.access.permissions.create', $viewShare);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionStoreRequest $request)
    {
        $permission = Permission::create($request->all());
        $permission->roles()->sync(array_filter($request->input('roles', [])));
        return Redirect::route('admin.access.permissions.index')
            ->with('success', 'Permissions Created Successfully');
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\Permission  $permission
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(Permission $permission)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        $roleList = Role::excludeRootRole()->pluckWithPlaceHolder('name', 'id', 'Choose Role');
        //now we are collecting the list of variables that need to passes to view
        $viewShare = [ 'permission' => $permission, 'roleList' => $roleList];
        //now we are returning the view
        return View::make('admin.access.permissions.edit', $viewShare);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update( PermissionUpdateRequest $request, Permission $permission)
    {
        $permission->update($request->all());
        $permission->roles()->sync(array_filter($request->input('roles', [])));
        return Redirect::route('admin.access.permissions.index')
            ->with('success', 'Permission Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return Redirect::route('admin.access.permissions.index')
            ->with('success', 'Permission Deleted Successfully');
    }
}
