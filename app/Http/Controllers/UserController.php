<?php

namespace App\Http\Controllers;

use App\Models\{User,Role,Permission};
use Illuminate\Http\{Request as HttpRequest};
use Illuminate\Support\Facades\View;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    /**
     * Display a listing of the Users.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return \Illuminate\Http\Response
     */
    public function index( HttpRequest $request)
    {
        //getting the list of user by latest and passing to length aware paginator instance
        $usersList = User::latest()->paginate(null, ['*'], 'userPage')->onEachSide(2);       
        //now we are collecting the list of variables that need to passes to view
        $viewShare = ['usersList' => $usersList];
        //now we are returning the view
        return View::make('admin.access.users.index', $viewShare);
    }

    /**
     * Show all the softdeleted model
     *
     *
     * @param HttpRequest $request The Request Variable
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return \Illuminate\Http\Response
     **/
    public function trashed( HttpRequest $request)
    {
        //getting the list of user by latest and passing to length aware paginator instance
        $usersList = User:: onlyTrashed()->latest()->paginate(null, ['*'], 'userTrashedPage')->onEachSide(2);
        //now we are collecting the list of variables that need to passes to view
        $viewShare = ['usersList' => $usersList];
        //now we are returning the view
        return View::make('admin.access.users.index', $viewShare);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //now we are collecting the list of variables that need to passes to view
        $viewShare = [''];
        //now we are returning the view
        return View::make('admin.access.users.create', $viewShare);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @return Illuminate\Support\Facades\Redirect
     */
    public function store( UserStoreRequest $request)
    {
        User::create($request->all());
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
        return $user;
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
        //now we are collecting the list of variables that need to passes to view
        $viewShare = ['user' => $user];

        //now we are returning the view

        return View::make('admin.access.users.edit', $viewShare);
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
        $user->update($request->all());
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
        $user->delete();
        return Redirect::route('admin.access.users.index')
                        ->with('success', 'User Deleted Successfully');
    }
}
