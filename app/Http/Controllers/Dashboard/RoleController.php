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
        $roles = Role::with('permissions')->whereNot('id',2)->get();
        return view('dashboard.roles.list', compact('roles'));
    }

    public function show($id)
{
    // Retrieve the role along with its permissions
    $role = Role::with('permissions')->findOrFail($id);

    // Fetch and group permissions as in the `create` method
    $groupedPermissions = $this->getGroupedPermissions();

    return view('dashboard.roles.show', compact('role', 'id', 'groupedPermissions'));
}

public function create()
{
    // Fetch and group permissions
    $groupedPermissions = $this->getGroupedPermissions();

    return view('dashboard.roles.add', compact('groupedPermissions'));
}

/**
 * Common function to fetch and group permissions.
 */
private function getGroupedPermissions()
{
    $permissions = Permission::where('guard_name', 'admin')->where('is_active', 0)->get();
    $groupedPermissions = [];
    foreach ($permissions as $permission) {
        $parts = explode(' ', $permission->name);
        $group = $parts[1] ?? 'Others'; // Default group name if no second part exists
        $groupedPermissions[$group][] = $permission;
    }
    return $groupedPermissions;
}
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name') // Ignore the current role when checking for uniqueness
            ],
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
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->ignore($id), // Ignore the current role when checking for uniqueness
            ],
            'permissions_ids' => 'required|array',
            'permissions_ids.*' => 'string|exists:permissions,name',
        ]);

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
