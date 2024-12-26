<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\RecipeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->whereNot('id',3)->get();
        return view('dashboard.roles.list', compact('roles'));
    }

    public function show($id)
    {
        $role = Role::with('permissions')->findOrFail($id);

        return view('dashboard.roles.show', compact('role','id'));
    }
    public function create()
    {
        $permissions = Permission::where('guard_name', 'admin')->where('is_active',0)->get();
        $groupedPermissions = [];
        foreach ($permissions as $permission) {
            $parts = explode(' ', $permission->name);
            $group = $parts[1] ?? 'Others';
            $groupedPermissions[$group][] = $permission;
        }
        return view('dashboard.roles.add', compact('groupedPermissions'));
    }
    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'الاسم  مطلوب ولا يمكن تركه فارغاً.',
            'permissions_ids.required' => 'الصلاحية   مطلوب ولا يمكن تركه فارغاً.',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions_ids' => 'required|array',
            'permissions_ids.*' => 'string|exists:permissions,name',
        ]);

        // Handle validation failure
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $validatedData = $validator->validated();

        // Create the new role for the 'admin' guard
        $role = Role::create([
            'name' => $validatedData['name'],
            'guard_name' => 'admin', // Specify the guard
        ]);

        // Fetch the permissions from the database
        $permissions = Permission::whereIn('name', $validatedData['permissions_ids'])->get();

        // Assign permissions to the role
        $role->syncPermissions($permissions);
        return redirect()->route('roles.list');
    }
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::where('guard_name', 'admin')->where('is_active',0)->get();
        $groupedPermissions = [];
        foreach ($permissions as $permission) {
            $parts = explode(' ', $permission->name);
            $group = $parts[1] ?? 'Others';
            $groupedPermissions[$group][] = $permission;
        }
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('dashboard.roles.edit', compact('role', 'groupedPermissions', 'rolePermissions'));
    }
    public function update(Request $request, $id)
    {
        $messages = [
            'name.required' => 'الاسم  مطلوب ولا يمكن تركه فارغاً.',
            'permissions_ids.required' => 'الصلاحية   مطلوب ولا يمكن تركه فارغاً.',
        ];

        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->ignore($id), // Ignore the current role when checking for uniqueness
            ],
            'permissions_ids' => 'required|array',
            'permissions_ids.*' => 'string|exists:permissions,name',
        ], $messages);

        // Handle validation failure
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $validatedData = $validator->validated();

        // Fetch the role to be updated
        $role = Role::findOrFail($id);

        // Update the role's name
        $role->update([
            'name' => $validatedData['name'],
        ]);

        // Fetch the permissions from the database
        $permissions = Permission::whereIn('name', $validatedData['permissions_ids'])->get();

        // Sync the updated permissions with the role
        $role->syncPermissions($permissions);

        return redirect()->route('roles.list')->with('success', 'Role updated successfully.');
    }
        public function destroy($id) {
            $role = Role::findOrFail($id);

            // Ensure no users are assigned to this role before deletion
            if ($role->users()->count() > 0) {
                return redirect()->back()->with('error', 'Cannot delete role assigned to users.');
            }

            // Delete the role
            $role->delete();

            // Redirect with success message
            return redirect()->route('roles.list')->with('success', 'Role deleted successfully.');

        }
}
