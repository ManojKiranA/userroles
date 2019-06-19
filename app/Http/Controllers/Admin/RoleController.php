<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Http\Controllers\Controller;
use App\Repositories\RoleRepository;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View as IlluminateView;
use Illuminate\Support\Facades\View as ViewFacade;

class RoleController extends Controller
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
     * Display a listing of the Users.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @return  IlluminateView
     */
    public function index(): IlluminateView
    {
        return ViewFacade::make('admin.access.roles.index', $this->roleRepo->showRecords());
    }

    /**
     * Show the form for creating a new User.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @return  IlluminateView
     */
    public function create(): IlluminateView
    {    
        return ViewFacade::make('admin.access.roles.create', $this->roleRepo->createRecord());
    }

    /**
     * Store a newly created User in storage.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   RoleStoreRequest  $request
     * @return  RedirectResponse
     */
    public function store( RoleStoreRequest $request): RedirectResponse
    {
        $this->roleRepo->storeRecord($request);

        return Redirect::route('admin.access.roles.index')
                    ->with('success', 'Role Created Successfully');
    }

    /**
     * Display the specified Role.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   Role  $role
     * @return  IlluminateView
     */
    public function show(Role $role): IlluminateView
    {
        return ViewFacade::make('admin.access.roles.show', $this->roleRepo->showRecord($role));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role): IlluminateView
    {
        return ViewFacade::make('admin.access.roles.edit', $this->roleRepo->editRecord($role));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RoleUpdateRequest  $request
     * @param  Role  $role
     * @return RedirectResponse
     */
    public function update( RoleUpdateRequest $request, Role $role): RedirectResponse
    {
        $this->roleRepo->updateRecord($request,$role);

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
        abort_if(Gate::denies('role_delete') || $role->isRoot(), 403);
     
        if ( $role->isDeletable()) {
     
            $role->delete();
     
            return Redirect::route( 'admin.access.roles.index')
                ->with('success', 'Role Deleted Successfully');
        }

        return Redirect::route( 'admin.access.roles.index')
            ->with('error', 'Role is Assigned to Permission or User');
    }

}
