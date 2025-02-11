<?php

namespace App\Http\Controllers\Student;

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

        return view('student.profile.index', compact('user', 'otherDetails'));
    }

    public function update(Request $request)
	{
	    $user = Auth::user();
	    try {
	        // Update user details
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
	  		if($user->save()){
		        $otherDetail = OtherDetail::where('user_id', $user->id)->first();
		        
		        if(!$otherDetail) {
		            $otherDetail = new OtherDetail();
		            $otherDetail->user_id = $user->id;
		        }

				$fields = ['idnumber', 'course', 'year', 'section', 'semester', 'academic_year', 'birthplace', 'address'];

				foreach ($fields as $field) {
				    if ($request->has($field)) {
				        $otherDetail->$field = $request->input($field);
				    }
				}

		        $otherDetail->save();
		        return redirect()->route('student.profile')->with('success', 'Profile updated successfully.');
			}	        
	    } catch (\Exception $e) {	        
	    	return redirect()->route('student.profile')->with('error', 'Failed to update profile.');
	    }
	}
}
