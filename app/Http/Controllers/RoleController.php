<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\View as IlluminateView;
class RoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the Users.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \Illuminate\Http\Request $request Current Request Instance
     * @return  \Illuminate\View\View
     */
    public function index( HttpRequest $request): IlluminateView
    {
        //if the user dont have access abort with unauthorized
        $this->authorize( 'role_access');
        //getting the list of roles by latest and passing to length aware paginator instance
        $rolesList = Role::excludeRootRole()
                        ->latest()
                        ->paginate(null,['*'],'rolePage')
                        ->onEachSide(2);
        //now we are collecting the list of variables that need to passes to view
        $viewShare =[ 'rolesList' => $rolesList];
        //now we are returning the view
        return ViewFacade::make('admin.access.roles.index', $viewShare);
    }

    /**
     * Show the form for creating a new User.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \Illuminate\Http\Request $request Current Request Instance
     * @return  \Illuminate\View\View
     */
    public function create( HttpRequest $request): IlluminateView
    {
        //if the user dont have access abort with unauthorized
        $this->authorize( 'role_create');
        //plucking the permisisons
        $permissionList = Permission::pluckWithPlaceHolder('name','id','Choose Permissions');
        //now we are collecting the list of variables that need to passes to view
        $viewShare = [ 'permissionList' => $permissionList];
        //now we are returning the view
        return ViewFacade::make('admin.access.roles.create', $viewShare);
    }

    /**
     * Store a newly created User in storage.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \App\Http\Requests\RoleStoreRequest  $request Current Request Instance
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function store( RoleStoreRequest $request): RedirectResponse
    {
        //creating new role
        $role = Role::create($request->all());
        //sync permission to roles
        $role->syncPermission($request->input('permissions',[]));
        //now we are redirecting to the index page with message
        return Redirect::route('admin.access.roles.index')
                    ->with('success', 'Role Created Successfully');
    }

    /**
     * Display the specified Role.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \App\Models\Role  $role Current Role Object
     * @return  \Illuminate\View\View
     */
    public function show(Role $role): IlluminateView
    {
        //if the user is trying to show the root role we need to deny that
        abort_if($role->isRoot(), 403, "Whoops You Can't ".ucfirst(__FUNCTION__)." that");
        //if the user dont have access abort with unauthorized
        $this->authorize( 'role_show');
        //now we are collecting the list of variables that need to passes to view
        $viewShare = [ 'role' => $role];
        //now we are returning the view
        return ViewFacade::make('admin.access.roles.show', $viewShare);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role): IlluminateView
    {
        //if the user is trying to edit the root role we need to deny that
        abort_if($role->isRoot(), 403, "Whoops You Can't " . ucfirst(__FUNCTION__) . " that");
        //if the user dont have access abort with unauthorized
        $this->authorize( 'role_edit');
        $permissionList = Permission::pluckWithPlaceHolder('name', 'id', 'Choose Permissions');
        //now we are collecting the list of variables that need to passes to view
        $viewShare = [ 'role' => $role, 'permissionList' => $permissionList];
        //now we are returning the view
        return ViewFacade::make('admin.access.roles.edit', $viewShare);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update( RoleUpdateRequest $request, Role $role)
    {
        //if the user is trying to delete the root role we need to deny that
        abort_if($role->isRoot(), 403, "Whoops You Can't Delete that");
        $role->update($request->all());
        $role->syncPermission($request->input('permissions', []));
        return Redirect::route('admin.access.roles.index')
                        ->with('success', 'Role Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //if the user is trying to edit the root role we need to deny that
        abort_if($role->isRoot(), 403, "Whoops You Can't " . ucfirst(__FUNCTION__) . " that");
        //if the user dont have access abort with unauthorized
        $this->authorize( 'role_delete');
        //check if the permisison is deletable
        if ( $role->isDeletable()) {
            //delete the role object
            $role->delete();
            //now we are redirecting to the index page with message
            return Redirect::route( 'admin.access.roles.index')
                ->with('success', 'Role Deleted Successfully');
        }
        //now we are redirecting to the index page with message
        return Redirect::route( 'admin.access.roles.index')
            ->with('error', 'Role is Assigned to Permission or User');        
    }

    /**
     * Show all the softdeleted Roles
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \Illuminate\Http\Request $request Current Request Instance
     * @return  \Illuminate\View\View
     **/
    public function deleted(HttpRequest $request): IlluminateView
    {
        //if the user dont have access abort with unauthorized
        $this->authorize( 'role_deleted_access');
        //getting the list of user by latest and passing to length aware paginator instance

        //getting the list of roles by latest and passing to length aware paginator instance
        $rolesList = Role::excludeRootRole()
                        -> onlyTrashed()
                        ->latest()
                        ->paginate(null, ['*'], 'roleDeletedPage')
                        ->onEachSide(2);
        //now we are collecting the list of variables that need to passes to view
        $viewShare = [ 'rolesList' => $rolesList];
        //now we are returning the view
        return ViewFacade::make('admin.access.roles.deleted', $viewShare);
    }

    /**
     * Force Deleted the softdeleted Permission
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \Illuminate\Http\Request $request Current Request Instance
     * @param   string $roleID The id that need to be force deleted
     * @return  \Illuminate\Http\RedirectResponse
     **/
    public function forceDelete(HttpRequest $request, $roleID): RedirectResponse
    {
        //if the user dont have access abort with unauthorized
        $this->authorize('role_force_delete');
        //finding the role of the id 
        //we can't use method injection because it don't
        //include softdeleted model
        $role = Role::withTrashed()->findOrFail( $roleID);
        //delete the current model object by finding it with trashed
        $role->forceDelete();
        //now we are redirecting to the deleted page with message
        return Redirect::route('admin.access.roles.deleted')
            ->with('success', 'Role Permanently Deleted Successfully');
    }

    /**
     * Restore the softdeleted model
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param HttpRequest $request Current Request Instance
     * @param string $roleID The id that need to be restored
     * @return \Illuminate\Http\RedirectResponse
     **/
    public function restore(HttpRequest $request, $roleID): RedirectResponse
    {
        //if the user dont have access abort with unauthorized
        $this->authorize( 'role_restore');
        //finding the permission of the id 
        //we can't use method injection because it don't
        //include softdeleted model
        $role = Role::withTrashed()->findOrFail( $roleID);
        //restore the current model object by finding it with trashed
        $role->restore();
        //now we are redirecting to the deleted page with message
        return Redirect::route('admin.access.roles.deleted')
            ->with('success', 'Role Restored Successfully');
    }
}
