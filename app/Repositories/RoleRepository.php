<?php
namespace App\Repositories;

use \Exception;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;

class RoleRepository
{
    /**
     * Returns the roles list with Loading Relation
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @return  array
     **/
    public function showRecords(): array
    {
        abort_if(Gate::denies('role_access'), 403);

        $rolesList = Role::excludeRootRole()
                        ->with(['permissions','users'])
                        ->latest()
                        ->paginate(null, ['*'], 'rolePage')
                        ->onEachSide(2);
        
        $returnables =[ 'rolesList' => $rolesList];

        return $returnables;
    }

    /**
     * Return the required data that needs to be
     * Displayed While Creating the new Record
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @return  array
     **/
    public function createRecord(): array
    {
        abort_if(Gate::denies('role_create'), 403);
        
        $permissionList = Permission::pluckWithPlaceHolder('name', 'id', 'Choose Permissions');

        $returnables = [ 'permissionList' => $permissionList];

        return $returnables;
    }

    /**
     * Store the New Role into Database
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   RoleStoreRequest $request
     * @return  Role
     **/
    public function storeRecord($request): Role
    {
       //creating new role
        $role = Role::create($request->all());
        //sync permission to roles
        $role->syncPermission($request->input('permissions', []));
        //now we are redirecting to the index page with message
        return $role;
    }

    /**
     * Shows the Specific Record
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   Role $role
     * @return  array
     **/
    public function showRecord($role): array
    {
        abort_if(Gate::denies('role_show') || $role->isRoot(), 403);

         $relationCallBack = function ($query) {
                $query->select('id', 'name');
            };

        $role = $role->load(['permissions' => $relationCallBack]);

        $returnables = [ 'role' => $role];

        return $returnables;
    }

    /**
     * Return the Required Data that is required
     * for editing the role
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   Role $role
     * @return  array
     **/
    public function editRecord($role): array
    {
        abort_if(Gate::denies('role_edit') || $role->isRoot(), 403);

        $permissionList = Permission::pluckWithPlaceHolder('name', 'id', 'Choose Permissions');

        $returnables = [ 'role' => $role, 'permissionList' => $permissionList];

        return $returnables;
    }

    /**
     * Update the User With Current Request
     *
     * @author  Manojkiran.A <manojkiran10031998@gmail.com>
     * @param   RoleUpdateRequest $request
     * @param   Role $user
     * @return  Role
     **/
    public function updateRecord($request, $role): Role
    {
        abort_if($role->isRoot(), 403);

        $role->update($request->all());

        $role->syncPermission($request->input('permissions', []));

        return $role;
    }
    
    /**
     * Gets all the SoftDeleted Model
     * from Database
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return array
     **/
    public function showDeletedRecords(): array
    {
        abort_if(Gate::denies('role_deleted_access'), 403);

        $rolesList = Role::excludeRootRole()
                        -> onlyTrashed()
                        ->latest()
                        ->paginate(null, ['*'], 'roleDeletedPage')
                        ->onEachSide(2);

        $returnables = [ 'rolesList' => $rolesList];

        return $returnables;
    }

    /**
     * Deletes the Soft Deleted Model
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param User $user
     * @return void
     **/
    public function deleteRecord($role): void
    {
        abort_if(Gate::denies('role_force_delete'), 403);

        $role->forceDelete();
    }

    /**
     * Deletes the Soft Deleted Model
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param User $user
     * @return void
     **/
    public function restoreRecord($role): void
    {
        $this->authorize('role_restore');

        $role-> restore();
    }
}
