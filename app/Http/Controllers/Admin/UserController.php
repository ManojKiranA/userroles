<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\View as IlluminateView;
use App\Repositories\UserRepository;


class UserController extends Controller
{
    /**
     * User Repository Property.
     *
     * @var string
     */
    protected $userRepo;

    /**
     * Create a new UserController instance.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param App\Repositories\UserRepository $userRepo
     * @return void
     */
    public function __construct(UserRepository $userRepo)
    {
        $this->middleware('auth');
        $this->userRepo = $userRepo;
    }

    /**
     * Display a listing of the Users.
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   \Illuminate\Http\Request $request Current Request Instance
     * @return  \Illuminate\View\View
     */
    public function index(): IlluminateView
    {
        return ViewFacade::make('admin.access.users.index',$this->userRepo->showRecords());
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
        return ViewFacade::make('admin.access.users.create',$this->userRepo->createRecord());
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
        $this->userRepo->storeRecord($request);       
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
        return ViewFacade::make('admin.access.users.show', $this->userRepo->showRecord($user));
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
        return ViewFacade::make('admin.access.users.edit', $this->userRepo->editRecord($user));
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
        $this->userRepo->updateRecord($request,$user);

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
        $this->userRepo->removeRecord($user);

        return Redirect::route('admin.access.users.index')
                        ->with('success', 'User Deleted Successfully');
    }
}
