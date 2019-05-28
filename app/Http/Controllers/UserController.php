<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\{Request as HttpRequest};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\View as IlluminateView;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
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
     * Display a listing of the Users.
     *
     * @param HttpRequest $request Current Request Instance
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return IlluminateView
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
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return IlluminateView
     */
    public function create(): IlluminateView
    {
        //if the user dont have access abort with unauthorized
        $this->authorize('user_access');
        //now we are plucking the roles with place holder
        $roleList = Role:: excludeRootRole()->pluckWithPlaceHolder('name', 'id', 'Choose Role');
        //now we are plucking the permissions with place holder
        $permissionList = Permission::PluckWithPlaceHolder('name', 'id', 'Choose Permissions');
        //now we are collecting the list of variables that need to passes to view
        $viewShare = [ 'roleList' => $roleList, 'permissionList' => $permissionList];
        //now we are returning the view
        return ViewFacade::make('admin.access.users.create', $viewShare);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param  App\Http\Requests\UserStoreRequest  $request
     * @return Illuminate\Support\Facades\Redirect
     */
    public function store( UserStoreRequest $request)
    {
        //if the user dont have access abort with unauthorized
        $this->authorize('user_access');
        //now we are creating the user from the form parameters
        $user = User::create($request->all());
        //after that we need to sync the user roles in the relation table
        $user->roles()->sync(array_filter($request->input('roles', [])));
        //after that we need to sync the user permissions in the relation table
        $user->permissions()->sync( $this->setUniquePermisison($request->input('roles') ?? [], $request->input('permissions') ?? [], 'STORE'));
        //now we are redirecting to the index page with message
        return Redirect::route('admin.access.users.index')
                        ->with( 'success','User Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //if the user dont have access abort with unauthorized
        $this->authorize('user_access');
        //now we are collecting the list of variables that need to passes to view
        $viewShare = ['user' => $user];
        return ViewFacade::make('admin.access.users.show', $viewShare);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //if the user dont have access abort with unauthorized
        $this->authorize('user_access');
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
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param  App\Http\Requests\UserUpdateRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update( UserUpdateRequest $request, User $user)
    {
        //if the user dont have access abort with unauthorized
        $this->authorize( 'user_edit');
        $user->update($request->all());
        //after that we need to sync the user roles in the relation table
        $user->roles()->sync(array_filter($request->input('roles', [])));
        //after that we need to sync the user permissions in the relation table
        $user->permissions()->sync($this->setUniquePermisison($request->input('roles') ?? [], $request->input('permissions') ?? [], 'UPDATE'));
        //now we are redirecting to the index page with message
        return Redirect::route('admin.access.users.index')
                        ->with('success', 'User Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //if the user dont have access abort with unauthorized
        $this->authorize( 'user_delete', Auth::user());
        $user->delete();
        return Redirect::route('admin.access.users.index')
                        ->with('success', 'User Deleted Successfully');
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
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param HttpRequest $request Current Request Instance
     * @param string $userId The id that need to be force deleted
     * @return Redirect
     **/
    public function forceDelete( HttpRequest $request,$userId)
    {
        //if the user dont have access abort with unauthorized
        $this->authorize( 'user_force_delete');
        User::withTrashed()->findOrFail($userId)->forceDelete();
        return Redirect::route( 'admin.access.users.deleted')
            ->with('success', 'User Permanently Deleted Successfully');
    }

    /**
     * Restore the softdeleted model
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param HttpRequest $request Current Request Instance
     * @param string $userId The id that need to be restored
     * @return Redirect
     **/
    public function restore(HttpRequest $request, $userId)
    {
        //if the user dont have access abort with unauthorized
        $this->authorize( 'user_restore');
        User::withTrashed()->findOrFail($userId)-> restore();
        return Redirect::route('admin.access.users.deleted')
            ->with('success', 'User Restored Successfully');
    }
    
    /**
     * Set the Unique Permission Based on the role 
     *
     * If the User selects the multiple roles and permissions
     * and if the if the user seleted permisisons exits in the
     *  selected role then we are removing it
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param array $roles Array of Roles
     * @param array $permissions Array of Permissions
     * @param string $method The Method
     * @return array
     **/
    private function setUniquePermisison($roles = [],$permissions = [],$method)
    {
        $roles = array_filter($roles);
        $permissions = array_filter( $permissions);

        if( $roles === [] && $permissions === [] || $roles !== [] && $permissions === []){
            return [];
        }elseif ( $roles === [] && $permissions !== []){
            return $permissions;
        }
        if (is_array($roles)) {
            foreach ($roles as $roleV) {
                $perToEachRole = Role::findOrFail($roleV);
                $perArrToRoles = $perToEachRole->permissions->toArray();
                foreach ($perArrToRoles as $perArrToRoleVal) {
                    $totPermList[] = $perArrToRoleVal['id'];
                }
            }
            $dirPermToRole = array_unique($totPermList);
        }
        if ($method == 'STORE') {
            $difference = array_merge(array_diff($dirPermToRole, $permissions), array_diff($permissions, $dirPermToRole));
        } elseif ($method == 'UPDATE') {
            $difference = array_merge(array_diff($permissions, $dirPermToRole));
        }
        return $difference;
    }
}
