<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
	        'role_name' => 'required|unique:roles,role_name|max:255',
            'url' => 'nullable|string',
	    ]);
        if ($validator->fails()) {
	        return response()->json(['errors' => $validator->errors()], 422);
	    }

        Role::create($request->all());
        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'role_name' => 'required|max:255|unique:roles,role_name,' . $role->id,
            'url' => 'nullable|string',
        ]);

        $role->update($request->all());
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Request $request)
    {
        try {
            $role = Role::find($request->role);
            if ($role->delete()) {
                return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
            }
            return response()->json(['errors' => "Something went wrong, role couldn't be deleted."], 422);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 500);
        }     
    }
}
