<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\OtherDetail;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $otherDetails = OtherDetail::where('user_id', $user->id)->first();
        
        // Check if all required fields in Users and OtherDetails are filled
        $isProfileComplete = isset($user->firstname, $user->lastname, $user->middlename, $user->dateofbirth, $user->email)
            && isset($otherDetails->idnumber, $otherDetails->course, $otherDetails->year, $otherDetails->gender,
                     $otherDetails->semester, $otherDetails->academic_year, $otherDetails->birthplace,
                     $otherDetails->address, $otherDetails->photo);

        return view('alumni.profile.index', compact('user', 'otherDetails', 'isProfileComplete'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        try {
            if (!isset($user->firstname)) {
                $user->firstname = $request->input('firstname');
            }
            if (!isset($user->lastname)) {
                $user->lastname = $request->input('lastname');
            }
            if (!isset($user->middlename)) {
                $user->middlename = $request->input('middlename');
            }
            if (!isset($user->dateofbirth)) {
                $user->dateofbirth = $request->input('dateofbirth');
            }
            if (!isset($user->email)) {
                $user->email = $request->input('email');
            }
    
            if ($user->save()) {
                $otherDetail = OtherDetail::where('user_id', $user->id)->first();
    
                if (!$otherDetail) {
                    $otherDetail = new OtherDetail();
                    $otherDetail->user_id = $user->id;
                }
    
                $fields = ['idnumber', 'course', 'year', 'gender', 'semester', 'academic_year', 'birthplace', 'address'];
    
                foreach ($fields as $field) {
                    if ($request->has($field)) {
                        $otherDetail->$field = $request->input($field);
                    }
                }
    
                if ($request->has('photo') && !empty($request->input('photo'))) {
                    $otherDetail->photo = $request->input('photo');
                }

                $otherDetail->save();
                return redirect()->route('alumni.profile')->with('success', 'Profile updated successfully.');
            }
        } catch (\Exception $e) {
            return redirect()->route('alumni.profile')->with('error', 'Failed to update profile.');
        }
    }    
}
