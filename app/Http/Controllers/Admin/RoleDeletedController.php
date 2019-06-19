<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Http\Controllers\Controller;
use App\Repositories\RoleRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\View\View as IlluminateView;
use Illuminate\Support\Facades\View as ViewFacade;


class RoleDeletedController extends Controller
{
    /**
     * Role Repository Property.
     *
     * @var string
     */
    protected $roleRepo;

    /**
     * Create a new RoleController instance.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param  RoleRepository $roleRepo
     * @return void
     */
    public function __construct(RoleRepository $roleRepo)
    {
        $this->middleware('auth');
        $this->roleRepo = $roleRepo;
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
        return ViewFacade::make('admin.access.roles.deleted', $this->roleRepo->showDeletedRecords());
    }

    /**
     * Force Deleted the softdeleted Permission
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \Illuminate\Http\Request $request Current Request Instance
     * @param   string $roleID The id that need to be force deleted
     * @return  \Illuminate\Http\RedirectResponse
     **/
    public function forceDelete(Role $role): RedirectResponse
    {        
        $this->roleRepo->deleteRecord($role);

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
    public function restore(HttpRequest $request, $role): RedirectResponse
    {
        $this->roleRepo->restoreRecord($role);

        return Redirect::route('admin.access.roles.deleted')
            ->with('success', 'Role Restored Successfully');
    }
}
