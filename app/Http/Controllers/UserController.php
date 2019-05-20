<?php

namespace App\Http\Controllers;

use App\Models\{User,Role,Permission};
use Illuminate\Http\{Request as HttpRequest};
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Request;
use Collective\Html\FormFacade as Form;

use Illuminate\Database\Eloquent\Collection;


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
        // dump($request->all());
        //getting the list of user by latest and passing to length aware paginator instance
        $usersList = User::latest()->paginate(null,['*'],'userPage');       

        //now we are collecting the list of variables that need to passes to view
        $viewShare = ['usersList' => $usersList];

        //now we are returning the view

        return View::make('admin.access.users.index', $viewShare);
    }

    /**
     * Show the form for creating a new resource.
     *
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return compact($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return compact($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //now we are collecting the list of variables that need to passes to view
        $viewShare = ['user' => $user, 'request' => $request];

        //now we are returning the view

        return View::make('admin.access.users.edit', $viewShare);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        return $user;
    }
}
