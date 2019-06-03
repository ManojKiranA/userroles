<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\View as IlluminateView;

class UserController extends Controller
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
        $this->authorize('user_access',$request->user());
        //getting the list of user by latest and passing to length aware paginator instance
        $usersList = User::latest()
                        ->with(['roles','permissions'])
                        ->paginate(null, ['*'], 'userPage')
                        ->onEachSide(2);
        //now we are collecting the list of variables that need to passes to view
        $viewShare = ['usersList' => $usersList];
        //now we are returning the view
        return ViewFacade::make('admin.access.users.index', $viewShare);
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
        $this->authorize( 'user_create',$request->user());
        //now we are plucking the roles with place holder
        $roleList = Role::excludeRootRole()
                        ->pluckWithPlaceHolder('name', 'id', 'Choose Role');
        //now we are plucking the permissions with place holder
        $permissionList = Permission::pluckWithPlaceHolder('name', 'id', 'Choose Permissions');
        //now we are collecting the list of variables that need to passes to view
        $viewShare = [ 'roleList' => $roleList, 'permissionList' => $permissionList];
        //now we are returning the view
        return ViewFacade::make('admin.access.users.create', $viewShare);
    }

    /**
     * Store a newly created User in storage.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \App\Http\Requests\UserStoreRequest  $request Current Request Instance
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function store( UserStoreRequest $request): RedirectResponse
    {
        //now we are creating the user from the form parameters
        $user = User::create($request->all());
        //after that we need to sync the user roles in the relation table
        $user->syncRoles($request->input('roles', []));
        //after that we need to sync the user permissions in the relation table
        //but it may leads to data duplication
        //so we need tosync only the permsions that roles doesn't have
        $user->syncPermissions($request->input('permissions', []));
        //now we are redirecting to the index page with message
        return Redirect::route('admin.access.users.index')
                        ->with( 'success', 'User Created Successfully');
    }

    /**
     * Display the specified User.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \App\Models\User  $user Current User Object
     * @return  \Illuminate\View\View
     */
    public function show(User $user): IlluminateView
    {
        //if the user dont have access abort with unauthorized
        $this->authorize( 'user_show');
        //now we are collecting the list of variables that need to passes to view
        $viewShare = ['user' => $user];
        return ViewFacade::make('admin.access.users.show', $viewShare);
    }

    /**
     * Show the form for editing the specified User.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \App\Models\User  $user Current User Object
     * @return  \Illuminate\View\View
     */
    public function edit(User $user): IlluminateView
    {
        //if the user dont have access abort with unauthorized
        $this->authorize( 'user_edit');
        $roleList = Role::excludeRootRole()
                        ->pluckWithPlaceHolder('name', 'id', 'Choose Role');
        $permissionList = Permission::pluckWithPlaceHolder('name', 'id', 'Choose Permissions');
        //now we are collecting the list of variables that need to passes to view
        $viewShare = ['user' => $user, 'roleList' => $roleList, 'permissionList' => $permissionList];
        //now we are returning the view
        return ViewFacade::make('admin.access.users.edit', $viewShare);
    }

    /**
     * Update the specified User in Database.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \App\Http\Requests\UserUpdateRequest  $request Current Request Instance
     * @param   \App\Models\User  $user Current User Object
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function update( UserUpdateRequest $request, User $user): RedirectResponse
    {
        $user->update($request->all());
        //after that we need to sync the user roles in the relation table
        $user->syncRoles($request->input('roles', []));
        //after that we need to sync the user permissions in the relation table
        $user->syncPermissions($request->input('permissions', []));
        //now we are redirecting to the index page with message
        return Redirect::route('admin.access.users.index')
                        ->with('success', 'User Updated Successfully');
    }

    /**
     * Remove the specified User from Database.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \App\Models\User  $user Current User Object
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        //if the user dont have access abort with unauthorized
        $this->authorize( 'user_delete');
        //delete the current model object
        $user->delete();
        //now we are redirecting to the index page with message
        return Redirect::route('admin.access.users.index')
                        ->with('success', 'User Deleted Successfully');
    }
}
