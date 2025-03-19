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
    public function index(Request $request)
    {
        $users = User::with('role')
                    ->with('OtherDetail')->paginate(10);
        
        $query = User::with('role', 'OtherDetail');

        if ($request->filled('firstName')) {
            $query->where('firstname', 'LIKE', '%' . $request->firstName . '%');
        }
        if ($request->filled('lastName')) {
            $query->where('lastname', 'LIKE', '%' . $request->lastName . '%');
        }
        if ($request->filled('academicYear')) {
            $query->whereHas('OtherDetail', function ($q) use ($request) {
                $q->where('academic_year', $request->academicYear);
            });
        }
        if ($request->filled('role')) {
            $query->whereHas('role', function ($q) use ($request) {
                $q->where('id', $request->role);
            });
        }
        if ($request->filled('year')) {
            $query->whereHas('OtherDetail', function ($q) use ($request) {
                $q->where('year', $request->year);
            });
        }
        if ($request->filled('section')) {
            $query->whereHas('OtherDetail', function ($q) use ($request) {
                $q->where('section', $request->section);
            });
        }
        if ($request->filled('gender')) {
            $query->whereHas('OtherDetail', function ($q) use ($request) {
                $q->where('gender', $request->section);
            });
        }
        if ($request->filled('semester')) {
            $query->whereHas('OtherDetail', function ($q) use ($request) {
                $q->where('semester', $request->semester);
            });
        }

        $users = $query->paginate(10)->appends($request->all());

        
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

            $saveUser = new User();
            $saveUser->email = $request->email;
            $saveUser->firstname = $request->firstname;
            $saveUser->lastname = $request->lastname;
            $saveUser->middlename = $request->middlename;
            $saveUser->dateofbirth = $request->dateofbirth;
            $saveUser->password = Hash::make($request->password);
            $saveUser->role_id = $request->role_id; 
            
            if($saveUser->save()){

                $photo = null;
                if ($request->hasFile('photo')) {
                    $file = $request->file('photo');
                    $photo = 'data:image/' . $file->getClientOriginalExtension() . ';base64,' . base64_encode(file_get_contents($file));
                }
                $saveUserInfo = new OtherDetail();
                $saveUserInfo->user_id = $saveUser->id;
                $saveUserInfo->course = $request->course;
                $saveUserInfo->year = $request->year;
                $saveUserInfo->section = $request->section;
                $saveUserInfo->gender = $request->gender;
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
                    'gender' => $request->gender,
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
                $photoData = base64_encode(file_get_contents($photo->getRealPath()));
                return $photoData;
            } else {
                return null;
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
