<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'name' => 'required|string|max:255',
            'password' => 'required|min:6',
            'role_id'  => 'required|exists:roles,id',
        ]);

        // Create the user first
        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'role_id'  => $request->role_id,
        ]);

        // Create the related information
        $user->information()->create([
            'course' => $request->course,
            'year' => $request->year,
            'section' => $request->section,
            'semester' => $request->semester,
            'academic_year' => $request->academic_year,
            'birthdate' => $request->birthdate,
            'birthplace' => $request->birthplace,
            'address' => $request->address,
            'photo' => $this->uploadPhoto($request),
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|unique:users,username,' . $user->id,
            'name' => 'required|string|max:255',
            'password' => 'nullable|min:6',
            'role_id'  => 'required|exists:roles,id',
        ]);

        // Update information or create it if it doesn't exist
        $user->information()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'course' => $request->course,
                'year' => $request->year,
                'section' => $request->section,
                'semester' => $request->semester,
                'academic_year' => $request->academic_year,
                'birthdate' => $request->birthdate,
                'birthplace' => $request->birthplace,
                'address' => $request->address,
                'photo' => $request->hasFile('photo') ? $this->uploadPhoto($request) : ($user->information->photo ?? null),
            ]
        );

        // Update the user
        $user->username = $request->username;
        $user->name = $request->name;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->role_id = $request->role_id;
        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    protected function uploadPhoto($request)
    {
        if ($request->hasFile('photo')) {
            return $request->file('photo')->store('photos', 'public');
        }
        return null;
    }
}
