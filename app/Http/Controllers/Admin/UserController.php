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

            $photo = $this->uploadPhoto($request);
            if ($photo === null) {
                return redirect()->route('usersmanagement.create')->with('error', 'Failed to upload photo.');
            }

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
                $saveUserInfo->photo = $photo;
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
        $userInfo = $user->OtherDetail ?? new OtherDetail();

        return view('admin.users.edit', [
            'user' => $user,
            'userInfo' => $userInfo, 
            'roles' => $roles,
            'title' => 'Edit User'
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

            $user->email = $request->email;
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->middlename = $request->middlename;
            $user->dateofbirth = $request->dateofbirth;
            $user->role_id = $request->role_id;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $photoBase64 = 'data:' . $file->getClientMimeType() . ';base64,' . base64_encode(file_get_contents($file));
            } else {
                $photoBase64 = optional($user->OtherDetail)->photo;
            }
            
            if ($user->save()) {
                $user->otherDetail()->update([
                    'course' => $request->course,
                    'year' => $request->year,
                    'section' => $request->section,
                    'semester' => $request->semester,
                    'academic_year' => $request->academic_year,
                    'birthplace' => $request->birthplace,
                    'address' => $request->address,
                    'photo' => $photoBase64,
                ]);
            return redirect()->route('usersmanagement.edit', $id)->with('success', 'User updated successfully.');
        }
            return redirect()->route('usersmanagement.edit', $id)->with('error', 'User update failed.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('usersmanagement.index')->with([
            'success' => 'User deleted successfully.'
        ]);
    }

    public function uploadPhoto($request)
    {
        try {
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                // Process the photo (convert to base64)
                $photoData = base64_encode(file_get_contents($photo->getRealPath()));
                return $photoData;
            } else {
                return null; // Handle case where no photo is uploaded
            }
        } catch (\Exception $e) {
            \Log::error('Photo upload failed: ' . $e->getMessage());
            return null;
        }
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
