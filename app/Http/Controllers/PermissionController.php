<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Support\Facades\View;
use Illuminate\Http\{Request as HttpRequest};

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( HttpRequest $request)
    {
        $request = $request;
        //getting the list of user by latest and passing to length aware paginator instance
        $permissionList = Permission::latest()->paginate();

        //now we are collecting the list of variables that need to passes to view
        $viewShare = compact( 'permissionList');

        //now we are returning the view
        return View::make('admin.access.permissions.index', $viewShare);
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\Permission  $permission
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(Permission $permission)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Models\Permission  $permission
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit(Permission $permission)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\Permission  $permission
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, Permission $permission)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\Permission  $permission
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(Permission $permission)
    // {
    //     //
    // }
}
