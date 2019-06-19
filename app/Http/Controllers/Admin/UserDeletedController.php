<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\View as IlluminateView;

class UserDeletedController extends Controller
{
    /**
     * User Repository Property.
     *
     * @var string
     */
    protected $userRepo;

    /**
     * Create a new UserDeletedController instance.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param  UserRepository $userRepo
     * @return void
     */
    public function __construct(UserRepository $userRepo)
    {
        $this->middleware('auth');
        $this->userRepo = $userRepo;
    }

    /**
     * Show all the softdeleted Model
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @return  \Illuminate\View\View
     **/
    public function deleted(): IlluminateView
    {
        return ViewFacade::make('admin.access.users.deleted', $this->userRepo->showDeletedRecords());
    }

    /**
     * Force Deleted the softdeleted model
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   string $userId The id that need to be force deleted
     * @return  Illuminate\Http\RedirectResponse
     **/
    public function forceDelete(User $user): RedirectResponse
    {
        $this->userRepo->deleteRecord($user);
        
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
    public function restore(User $user): RedirectResponse
    {
        $this->userRepo->restoreRecord($user);

        return Redirect::route('admin.access.users.deleted')
                ->with('success', 'User Restored Successfully');
    }
}
