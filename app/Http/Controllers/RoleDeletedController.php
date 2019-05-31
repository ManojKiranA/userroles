<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\View as IlluminateView;


class RoleDeletedController extends Controller
{
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
