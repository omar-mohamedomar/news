<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:access management index,admin'])->only('index');
        $this->middleware(['permission:access management create,admin'])->only(['create', 'store']);
        $this->middleware(['permission:access management update,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:access management delete,admin'])->only('destroy');
    }

    public function index(): View
    {
        $roles = Role::all();
        return view('admin.role.index', compact('roles'));
    }

    public function create(): View
    {
        $permissions = Permission::all()->groupBy('group_name');

        return view('admin.role.create', compact('permissions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'role' => ['required', 'max:50', 'unique:permissions,name']
        ]);

        /** Create The Role */
        $role = Role::create(['guard_name' => 'admin', 'name' => $request->role]);

        /** Assign Permissions To The Role */
        $role->syncPermissions($request->permissions);

        toast(__('admin.Created Successfully!'), 'success');

        return redirect()->route('admin.role.index');
    }

    public function edit(string $id): View
    {
        $permissions = Permission::all()->groupBy('group_name');
        $role = Role::findOrFail($id);
        $rolesPermissions = $role->permissions;
        $rolesPermissions = $rolesPermissions->pluck('name')->toArray();

        return view('admin.role.edit', compact('permissions', 'role', 'rolesPermissions'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'role' => ['required', 'max:50', 'unique:permissions,name']
        ]);

        /** Update The Role */
        $role = Role::findOrFail($id);
        $role->update(['guard_name' => 'admin', 'name' => $request->role]);

        /** Assign Permissions To The Role */
        $role->syncPermissions($request->permissions);

        toast(__('admin.Updated Successfully!'), 'success');

        return redirect()->route('admin.role.index');
    }

    public function destroy(string $id): Response
    {
        $role = Role::findOrFail($id);

        if ($role->name === 'Super Admin') {
            return response(['status' => 'error', 'message' => __('admin.Can\'t Delete The Super Admin!')]);
        }
        $role->delete();

        return response(['status' => 'success', 'message' => __('admin.Deleted Successfully!')]);
    }
}
