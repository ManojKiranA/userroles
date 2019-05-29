<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View as IlluminateView;
use App\Http\Requests\PermissionStoreRequest;
use Illuminate\Http\Request as HttpRequest;
use App\Http\Requests\PermissionUpdateRequest;
use Illuminate\Support\Facades\View as ViewFacade;


class PermissionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the Permissions.
     *
     * @param HttpRequest $request Current Request Instance
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return IlluminateView
     */
    public function index( HttpRequest $request): IlluminateView
    {
        //if the user dont have access abort with unauthorized
        $this->authorize( 'permission_access');
        //getting the list of user by latest and passing to length aware paginator instance
        $permissionList = Permission::latest()
                            ->paginate(null, ['*'], 'permissionPage')
                            ->onEachSide(2);
        //now we are collecting the list of variables that need to passes to view
        $viewShare = [ 'permissionList' => $permissionList];
        //now we are returning the view
        return ViewFacade::make('admin.access.permissions.index', $viewShare);
    }

    /**
     * Show the form for creating a new Permission.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return IlluminateView
     */
    public function create(): IlluminateView
    {
        //if the user dont have access abort with unauthorized
        $this->authorize( 'permission_create');
        //plucking the role name and id with place holder
        $roleList = Role::excludeRootRole()->pluckWithPlaceHolder('name','id','Choose Role');
        //now we are collecting the list of variables that need to passes to view
        $viewShare = [ 'roleList' => $roleList];
        //now we are returning the view
        return ViewFacade::make('admin.access.permissions.create', $viewShare);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionStoreRequest $request)
    {
        //create the new permission for the form request
        $permission = Permission::create($request->all());
        //syncing the roles associated with the permisisons
        $permission->roles()->sync(array_filter($request->input('roles', [])));
        //now we are redirecting to the index page with message
        return Redirect::route('admin.access.permissions.index')
            ->with('success', 'Permissions Created Successfully');
    }

    /**
     * Display the specified Permission.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //if the user dont have access abort with unauthorized
        $this->authorize( 'permission_show');
        return $permission->load('roles');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission): IlluminateView
    {
        //if the user dont have access abort with unauthorized
        $this->authorize( 'permission_edit');
        $roleList = Role::excludeRootRole()->pluckWithPlaceHolder('name', 'id', 'Choose Role');
        //now we are collecting the list of variables that need to passes to view
        $viewShare = [ 'permission' => $permission, 'roleList' => $roleList];
        //now we are returning the view
        return ViewFacade::make('admin.access.permissions.edit', $viewShare);
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
        //if the user dont have access abort with unauthorized
        $this->authorize('permission_delete');
        if( $permission-> isDeletable())
        {
            $permission->delete();
            return Redirect::route('admin.access.permissions.index')
                ->with('success', 'Permission Deleted Successfully');
        }
        else 
        {
            return Redirect::route('admin.access.permissions.index')
                ->with('error', 'Permission is Assigned to Role or User');
        }        
        
    }


    /**
     * Show all the softdeleted Model
     *
     * @param HttpRequest $request Current Request Instance
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return \Illuminate\Http\Response
     **/
    public function deleted(HttpRequest $request)
    {
        //if the user dont have access abort with unauthorized
        $this->authorize( 'permission_deleted_access');
        //getting the list of user by latest and passing to length aware paginator instance
        $permissionList = Permission::onlyTrashed()
                            ->latest()
                            ->paginate(null, ['*'], 'permissionDeletedPage')
                            ->onEachSide(2);
        //now we are collecting the list of variables that need to passes to view
        $viewShare = [ 'permissionList' => $permissionList];
        //now we are returning the view
        return ViewFacade::make( 'admin.access.permissions.deleted', $viewShare);
    }

    /**
     * Force Deleted the softdeleted model
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param HttpRequest $request Current Request Instance
     * @param string $permissionId The id that need to be force deleted
     * @return Redirect
     **/
    public function forceDelete(HttpRequest $request, $permissionId)
    {
        //if the user dont have access abort with unauthorized
        $this->authorize( 'permission_force_delete');
        Permission::withTrashed()->findOrFail( $permissionId)->forceDelete();
        return Redirect::route( 'admin.access.permissions.deleted')
                        ->with('success', 'Permissions Permanently Deleted Successfully');
    }

    /**
     * Restore the softdeleted model
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param HttpRequest $request Current Request Instance
     * @param string $permissionId The id that need to be restored
     * @return Redirect
     **/
    public function restore(HttpRequest $request, $permissionId)
    {
        //if the user dont have access abort with unauthorized
        $this->authorize( 'permission_restore');
        Permission::withTrashed()->findOrFail( $permissionId)->restore();
        return Redirect::route( 'admin.access.permissions.deleted')
            ->with('success', 'Permission Restored Successfully');
    }
}
