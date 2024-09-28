<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
      
        return Inertia::render('Roles/Index', ['roles' => $roles]);
    }

    public function create()
    {
        $permissions = Permission::all();
        return Inertia::render('Roles/Create', ['permissions' => $permissions]);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string']);
        Role::create(['name' => $request->name]);
        $p = Permission::create(['name' => $request->description]);
        dd($p);
        $findRole = Role::where('name', 'user')->first();
        //$userRole = Role::first(['name' => 'user']);
        $findRole->givePermissionTo([$request->description]);


        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return Inertia::render('Roles/Edit', ['role' => $role->load('permissions'), 'permissions' => $permissions]);

    }

    public function update(Request $request, string $id)
    { 
        $expenseCaroletegory = Role::findOrFail($id);
       
        if ($expenseCaroletegory->name === 'admin') {
            return response()->json(['message' => 'Cannot update the Administrator role.'], 403);
        }
        else{
            $request->validate(['name' => 'required|string' . $expenseCaroletegory->id]);
            $expenseCaroletegory->update(['name' => $request->name]);
        }
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function delete(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }

    public function get_all_permissions()
    {
        $permissions = Permission::all();

        return response()->json([
            'permissions' => $permissions,
        ]);
    }
}
