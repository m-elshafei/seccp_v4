<?php

namespace App\Http\Controllers;

use App\DataTables\RoleDataTable;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\SystemComponent;
use App\Overrides\Spatie\Permission;
use App\Overrides\Spatie\Role;
use App\Utils\PermissionsUtil;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use Response;

class RoleController extends AppBaseController
{
    /**
     * Display a listing of the Role.
     *
     * @return Response
     */
    public function index(RoleDataTable $roleDataTable)
    {
        return $roleDataTable->render('roles.index');
    }

    /**
     * Show the form for creating a new Role.
     *
     * @return Response
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created Role in storage.
     *
     *
     * @return Response
     */
    public function store(CreateRoleRequest $request)
    {
        $input = $request->all();

        /** @var Role $role */
        $role = Role::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/roles.singular')]));

        return redirect(route('roles.index'));
    }

    /**
     * Display the specified Role.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        /** @var Role $role */
        $role = Role::find($id);

        if (empty($role)) {
            Flash::error(__('models/roles.singular').' '.__('messages.not_found'));

            return redirect(route('roles.index'));
        }

        return view('roles.show')->with('role', $role);
    }

    /**
     * Show the form for editing the specified Role.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        /** @var Role $role */
        $role = Role::find($id);

        if (empty($role)) {
            Flash::error(__('messages.not_found', ['model' => __('models/roles.singular')]));

            return redirect(route('roles.index'));
        }

        $sysScreens = SystemComponent::where('comp_type', 1)->get();

        $permissions = Permission::get();

        $rolePermissions = $role->permissions();

        return view('roles.edit')
            ->with('role', $role)
            ->with('sysScreens', $sysScreens);
    }

    /**
     * Update the specified Role in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, UpdateRoleRequest $request)
    {
        /** @var Role $role */
        $role = Role::find($id);

        if (empty($role)) {
            Flash::error(__('messages.not_found', ['model' => __('models/roles.singular')]));

            return redirect(route('roles.index'));
        }

        $role->fill($request->all());
        $role->save();

        if ($request->has('objectId')) {
            $parentNode = SystemComponent::find($request->objectId);
            $childNodes = SystemComponent::whereDescendantOf($parentNode)
                ->get()
                                            // ->where('comp_type', '=', 3)
                ->whereIn('comp_type', [3, 4])
                ->pluck('id');

            $objectsPermIds = Permission::whereIn('system_component_id', $childNodes)->get()->pluck('id');

            $role->revokePermissionTo($objectsPermIds);
            $role->givePermissionTo($request->input('permission'));
        }

        PermissionsUtil::clearPermissionCash();

        Flash::success(__('messages.updated', ['model' => __('models/roles.singular')]));

        return redirect(route('roles.index'));
    }

    /**
     * Remove the specified Role from storage.
     *
     * @param  int  $id
     * @return Response
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Role $role */
        $role = Role::find($id);

        if (empty($role)) {
            Flash::error(__('messages.not_found', ['model' => __('models/roles.singular')]));

            return redirect(route('roles.index'));
        }

        $role->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/roles.singular')]));

        return redirect(route('roles.index'));
    }

    public function getPermissionsView($id, $objectId = null)
    {
        $role = Role::find($id);
        $node = SystemComponent::find($objectId);

        // $models= PermissionsUtil::getObjectsByParent($objectId);

        $nodes = SystemComponent::whereDescendantOf($node)
            ->get()
                                // ->where('comp_type', '=', 3)
            ->whereIn('comp_type', [3, 4]);
        // $filtered = $parents->where('comp_type', '=', 1)->pluck('route_name')->first();

        $permission = Permission::get();

        // $rolePermissions[] = $role->permissions();

        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_has_permissions.role_id', $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('roles._permissions', compact('permission', 'nodes', 'role', 'rolePermissions', 'objectId'));
    }
}
