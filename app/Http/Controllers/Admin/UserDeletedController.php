<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\View as IlluminateView;


class UserDeletedController extends Controller
{
    /**
     * Show all the softdeleted Model
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \Illuminate\Http\Request $request Current Request Instance
     * @return  \Illuminate\View\View
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
     * @param   \Illuminate\Http\Request $request Current Request Instance
     * @param   string $userId The id that need to be force deleted
     * @return  Illuminate\Http\RedirectResponse
     **/
    public function forceDelete( HttpRequest $request,User $user): RedirectResponse
    {

        $this->authorize( 'user_force_delete');

        $user-> forceDelete();
        
        return Redirect::route( 'admin.access.users.deleted')
            ->with('success', 'User Permanently Deleted Successfully');
    }

    /**
     * Restore the softdeleted model
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \Illuminate\Http\Request $request Current Request Instance
     * @param   string $userId The id that need to be restored
     * @return  \Illuminate\Http\RedirectResponse
     **/
    public function restore(HttpRequest $request, User $user): RedirectResponse
    {

        $this->authorize( 'user_restore');

        $user-> restore();

        return Redirect::route('admin.access.users.deleted')
                ->with('success', 'User Restored Successfully');
    }
}
