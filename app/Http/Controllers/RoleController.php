<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\{Request as HttpRequest};
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;
use Illuminate\Support\Facades\{View,Config};
use Illuminate\Support\Facades\Redirect;
use App\Models\Permission;

class RoleController extends Controller
{
    protected $rootRoleName;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->rootRoleName = Config::get('useraccess.rootUserRoleName');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( HttpRequest $request)
    {
        $request = $request;
        //getting the list of roles by latest and passing to length aware paginator instance
        $rolesList = Role::excludeRootRole()
                        ->latest()
                        ->paginate(null,['*'],'rolePage')
                        ->onEachSide(2);
        //now we are collecting the list of variables that need to passes to view
        $viewShare = compact('rolesList');
        //now we are returning the view
        return View::make('admin.access.roles.index', $viewShare);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissionList = Permission::pluckWithPlaceHolder('name','id','Choose Permissions');
        //now we are collecting the list of variables that need to passes to view
        $viewShare = [ 'permissionList' => $permissionList];
        //now we are returning the view
        return View::make('admin.access.roles.create', $viewShare);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RoleStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store( RoleStoreRequest $request)
    {
        $role = Role::create($request->all());
        $role->givePermissionById($request->input( 'permissions'));
        return Redirect::route('admin.access.roles.index')
            ->with('success', 'Role Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //if the user is trying to view the root role we need to deny that
        abort_if( $this->rootRoleName === $role->name,403,"Whoops You Can't Show that");
        return $role;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //if the user is trying to edit the root role we need to deny that
        abort_if( $this->rootRoleName === $role->name, 403, "Whoops You Can't Edit that");

        $permissionList = Permission::pluckWithPlaceHolder('name', 'id', 'Choose Permissions');
        //now we are collecting the list of variables that need to passes to view
        $viewShare = [ 'role' => $role, 'permissionList' => $permissionList];
        //now we are returning the view
        return View::make('admin.access.roles.edit', $viewShare);
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
        //if the user is trying to update the root role we need to deny that
        abort_if($this->rootRoleName === $role->name, 403, "Whoops You Can't Edit that");
        $role->update($request->all());
        $role-> modifyPermissionById($request->input('permissions'));
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
        //if the user is trying to delete the root role we need to deny that
        abort_if($this->rootRoleName === $role->name, 403, "Whoops You Can't Delete that");
        $role->delete();
        return Redirect::route('admin.access.roles.index')
            ->with('success', 'Role Deleted Successfully');
    }
}
