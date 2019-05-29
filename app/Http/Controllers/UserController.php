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
     * @param   Illuminate\Http\Request $request Current Request Instance
     * @return  Illuminate\View\View
     */
    public function index( HttpRequest $request): IlluminateView
    {
        //if the user dont have access abort with unauthorized
        $this->authorize('user_access');
        //getting the list of user by latest and passing to length aware paginator instance
        $usersList = User::latest()
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
     * @param   HttpRequest $request Current Request Instance
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @return  Illuminate\View\View
     */
    public function create( HttpRequest $request): IlluminateView
    {
        //if the user dont have access abort with unauthorized
        $this->authorize( 'user_create');
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
     * Store a newly created resource in storage.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \App\Http\Requests\UserStoreRequest  $request Current Request Instance
     * @return  Illuminate\Http\RedirectResponse
     */
    public function store( UserStoreRequest $request): RedirectResponse
    {
        //now we are creating the user from the form parameters
        $user = User::create($request->all());
        //after that we need to sync the user roles in the relation table
        $user->syncRoles($request->input('roles',[]));
        //after that we need to sync the user permissions in the relation table
        //but it may leads to data duplication
        //so we need tosync only the permsions that roles doesn't have 
        $user->syncUniquePermissions($request->input('permissions', []), $request->input('roles', []), 'STORE');
        //now we are redirecting to the index page with message
        return Redirect::route('admin.access.users.index')
                        ->with( 'success','User Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \App\Models\User  $user Current User Object
     * @return  Illuminate\View\View
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
     * Show the form for editing the specified resource.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \App\Models\User  $user Current User Object
     * @return  Illuminate\View\View
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
     * Update the specified resource in storage.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \App\Http\Requests\UserUpdateRequest  $request Current Request Instance
     * @param   \App\Models\User  $user Current User Object
     * @return  Illuminate\Http\RedirectResponse
     */
    public function update( UserUpdateRequest $request, User $user): RedirectResponse
    {
        $user->update($request->all());
        //after that we need to sync the user roles in the relation table
        $user->syncRoles($request->input('roles',[]));
        //after that we need to sync the user permissions in the relation table
        $user->syncUniquePermissions($request->input('permissions', []), $request->input('roles', []), 'UPDATE');
        //now we are redirecting to the index page with message
        return Redirect::route('admin.access.users.index')
                        ->with('success', 'User Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \App\Models\User  $user Current User Object
     * @return  Illuminate\Http\RedirectResponse
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

    /**
     * Show all the softdeleted Model
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   Illuminate\Http\Request $request Current Request Instance
     * @return  @return Illuminate\View\View
     **/
    public function deleted(HttpRequest $request): IlluminateView
    {
        //if the user dont have access abort with unauthorized
        $this->authorize( 'user_deleted_access');
        //getting the list of user by latest and passing to length aware paginator instance
        $usersList = User::onlyTrashed()
                        ->latest()
                        ->paginate(null, ['*'], 'userDeletedPage')
                        ->onEachSide(2);
        //now we are collecting the list of variables that need to passes to view
        $viewShare = ['usersList' => $usersList];
        //now we are returning the view
        return ViewFacade::make('admin.access.users.deleted', $viewShare);
    }

    /**
     * Force Deleted the softdeleted model
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   Illuminate\Http\Request $request Current Request Instance
     * @param   string $userId The id that need to be force deleted
     * @return  Illuminate\Http\RedirectResponse
     **/
    public function forceDelete( HttpRequest $request,$userId): RedirectResponse
    {
        //if the user dont have access abort with unauthorized
        $this->authorize( 'user_force_delete');
        //finding the user of the id 
        //we can't use method injection because it don't
        //include softdeleted model
        $user = User::withTrashed()
                ->findOrFail($userId);
        //delete the current model object by finding it with trashed
        $user->forceDelete();
        return Redirect::route( 'admin.access.users.deleted')
            ->with('success', 'User Permanently Deleted Successfully');
    }

    /**
     * Restore the softdeleted model
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   Illuminate\Http\Request $request Current Request Instance
     * @param   string $userId The id that need to be restored
     * @return  Illuminate\Http\RedirectResponse
     **/
    public function restore(HttpRequest $request, $userId): RedirectResponse
    {
        //if the user dont have access abort with unauthorized
        $this->authorize( 'user_restore');
        User::withTrashed()->findOrFail($userId)-> restore();
        return Redirect::route('admin.access.users.deleted')
            ->with('success', 'User Restored Successfully');
    }
}
