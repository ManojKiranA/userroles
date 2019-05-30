<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionStoreRequest;
use App\Http\Requests\PermissionUpdateRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\View as IlluminateView;

class PermissionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @return  void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the Permissions.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \Illuminate\Http\Request $request Current Request Instance
     * @return  \Illuminate\View\View
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
     * Show the form for creating a new Permisission.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \Illuminate\Http\Request $request Current Request Instance
     * @return  \Illuminate\View\View
     */
    public function create( HttpRequest $request): IlluminateView
    {
        //if the user dont have access abort with unauthorized
        $this->authorize( 'permission_create');
        //plucking the role name and id with place holder
        $roleList = Role::excludeRootRole()
                        ->pluckWithPlaceHolder('name', 'id', 'Choose Role');
        //now we are collecting the list of variables that need to passes to view
        $viewShare = [ 'roleList' => $roleList];
        //now we are returning the view
        return ViewFacade::make('admin.access.permissions.create', $viewShare);
    }

    /**
     * Store a newly created Permisison in Database.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \App\Http\Requests\PermissionStoreRequest  $request Current Request Instance
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function store(PermissionStoreRequest $request): RedirectResponse
    {
        //create the new permission for the form request
        $permission = Permission::create($request->all());
        //syncing the roles associated with the permisisons
        $permission->syncRoles( $request->input('roles', []));
        //now we are redirecting to the index page with message
        return Redirect::route('admin.access.permissions.index')
                    ->with('success', 'Permissions Created Successfully');
    }

    /**
     * Display the specified Permission.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \App\Models\Permission  $permission Current Permisison Object
     * @return  \Illuminate\View\View
     */
    public function show(Permission $permission): IlluminateView
    {
        //if the user dont have access abort with unauthorized
        $this->authorize( 'permission_show');
        //now we are collecting the list of variables that need to passes to view
        $viewShare = [ 'permission' => $permission];
        //now we are returning the view
        return ViewFacade::make('admin.access.roles.show', $viewShare);
    }

    /**
     * Show the form for editing the Permisison.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \App\Models\Permission  $permission Current Permission Object
     * @return  Illuminate\View\View
     */
    public function edit(Permission $permission): IlluminateView
    {
        //if the user dont have access abort with unauthorized
        $this->authorize( 'permission_edit');
        $roleList = Role::excludeRootRole()
                        ->pluckWithPlaceHolder('name', 'id', 'Choose Role');
        //now we are collecting the list of variables that need to passes to view
        $viewShare = [ 'permission' => $permission, 'roleList' => $roleList];
        //now we are returning the view
        return ViewFacade::make('admin.access.permissions.edit', $viewShare);
    }

    /**
     * Update the specified Permission in Database.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \App\Http\Requests\PermissionUpdateRequest  $request Current Request Instance
     * @param   \App\Models\Permission  $permission Current Permission Object
     * @return  Illuminate\Http\RedirectResponse
     */
    public function update( PermissionUpdateRequest $request, Permission $permission): RedirectResponse
    {
        //updating the current $permission Object
        $permission->update($request->all());
        //syncing it roles
        $permission->syncRoles($request->input('roles', []));
        //now we are redirecting to the index page with message
        return Redirect::route('admin.access.permissions.index')
                    ->with('success', 'Permission Updated Successfully');
    }

    /**
     * Remove the specified Permission from Database.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Permission $permission): RedirectResponse
    {
        //if the user dont have access abort with unauthorized
        $this->authorize('permission_delete');
        //check if the permisison is deletable
        if( $permission-> isDeletable())
        {
            //delete the permission object
            $permission->delete();
            //now we are redirecting to the index page with message
            return Redirect::route('admin.access.permissions.index')
                ->with('success', 'Permission Deleted Successfully');
        }
        //now we are redirecting to the index page with message
        return Redirect::route('admin.access.permissions.index')
                    ->with('error', 'Permission is Assigned to Role or User');

    }


    /**
     * Show all the softdeleted Permisisons
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \Illuminate\Http\Request $request Current Request Instance
     * @return  \Illuminate\View\View
     **/
    public function deleted(HttpRequest $request): IlluminateView
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
     * Force Deleted the softdeleted Permission
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \Illuminate\Http\Request $request Current Request Instance
     * @param   string $permissionId The id that need to be force deleted
     * @return  \Illuminate\Http\RedirectResponse
     **/
    public function forceDelete(HttpRequest $request, $permissionId): RedirectResponse
    {
        //if the user dont have access abort with unauthorized
        $this->authorize( 'permission_force_delete');
        //finding the permission of the id
        //we can't use method injection because it don't
        //include softdeleted model
        $permission = Permission::withTrashed()->findOrFail($permissionId);
        //delete the current model object by finding it with trashed
        $permission->forceDelete();
        //now we are redirecting to the deleted page with message
        return Redirect::route( 'admin.access.permissions.deleted')
                    ->with('success', 'Permissions Permanently Deleted Successfully');
    }

    /**
     * Restore the softdeleted model
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param HttpRequest $request Current Request Instance
     * @param string $permissionId The id that need to be restored
     * @return \Illuminate\Http\RedirectResponse
     **/
    public function restore(HttpRequest $request, $permissionId): RedirectResponse
    {
        //if the user dont have access abort with unauthorized
        $this->authorize( 'permission_restore');
        //finding the permission of the id
        //we can't use method injection because it don't
        //include softdeleted model
        $permission = Permission::withTrashed()->findOrFail($permissionId);
        //restore the current model object by finding it with trashed
        $permission-> restore();
        //now we are redirecting to the deleted page with message
        return Redirect::route( 'admin.access.permissions.deleted')
                ->with('success', 'Permission Restored Successfully');
    }
}
