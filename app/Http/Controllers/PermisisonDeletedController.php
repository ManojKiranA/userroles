<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\View as IlluminateView;

class PermisisonDeletedController extends Controller
{
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
        $this->authorize( 'permission_restore',$request);
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
