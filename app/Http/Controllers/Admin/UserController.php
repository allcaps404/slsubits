<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\OtherDetail;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')
                    ->with('OtherDetail')->paginate(4);

        return view('admin.users.index', [
            'users' => $users,
            'title' => 'Users'
        ]);
        
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', [
            'roles' => $roles,
            'title' => 'Create User'
        ]);
    }

    public function store(Request $request)
    {
        try {

            if(User::where('email', $request->email)->exists()){
                return redirect()->route('usersmanagement.create')->with('error', 'Email already exists.');
            }
            if(User::where('firstname', $request->firstname)->where('lastname', $request->lastname)->where('dateofbirth', $request->dateofbirth)->exists()){
                return redirect()->route('usersmanagement.create')->with('error', 'User already exists.');
            }
            // return $request-> all();
            $saveUser = new User();
            $saveUser->email = $request->email;
            $saveUser->firstname = $request->firstname;
            $saveUser->lastname = $request->lastname;
            $saveUser->middlename = $request->middlename;
            $saveUser->dateofbirth = $request->dateofbirth;
            $saveUser->password = Hash::make($request->password);
            $saveUser->role_id = $request->role_id;

            if($saveUser->save()){
                $saveUserInfo = new OtherDetail();
                $saveUserInfo->user_id = $saveUser->id;
                $saveUserInfo->course = $request->course;
                $saveUserInfo->year = $request->year;
                $saveUserInfo->section = $request->section;
                $saveUserInfo->semester = $request->semester;
                $saveUserInfo->academic_year = $request->academic_year;
                $saveUserInfo->birthplace = $request->birthplace;
                $saveUserInfo->address = $request->address;
                $saveUserInfo->save();
                return redirect()->route('usersmanagement.create')->with('success', 'User created successfully.');
            }
            else{
                return redirect()->route('usersmanagement.create')->with('error', 'User creation failed.');
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create user.');
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        // Retrieve the information associated with the user
        $userInfo = $user->information;

        return view('admin.users.edit', [
            'user' => $user,
            'userInfo' => $userInfo,  // Pass the information model
            'roles' => $roles,
            'title' => 'Edit User'
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'password' => 'nullable|min:6',
            'role_id' => 'required|exists:roles,id',
            'course' => 'required|string|max:255',
            'year' => 'required|integer|min:1|max:5',
            'section' => 'required|string|max:255',
            'semester' => 'required|string|max:255',
            'academic_year' => 'required|string|max:255',
            'birthdate' => 'nullable|date|before_or_equal:today',
            'birthplace' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        // Update user information
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

        // Update the user model
        $user->email = $request->email;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->middlename = $request->middlename;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->role_id = $request->role_id;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with([
            'success' => 'User deleted successfully.'
        ]);
    }

    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
    
        // Check if a file was uploaded
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $directory = 'public/photos';
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs($directory, $fileName);    
            return back()->with('success', 'Photo uploaded successfully');
        }
        return back()->with('error', 'No photo uploaded');
    }

    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'user_id' => 'required|exists:users,id'
        ]);

        $emailExists = User::where('email', $request->email)
                        ->where('id', '!=', $request->user_id)
                        ->exists();

        return response()->json(['exists' => $emailExists]);
    }
}
