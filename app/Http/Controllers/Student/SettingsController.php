<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
	public function changePassword()
    {
        return view('student.settings.changepassword');
    }
	public function changePasswordUpdate(Request $request)
	{
	    // Validate input
	    $validator = Validator::make($request->all(), [
	        'current_password' => ['required'],
	        'new_password' => ['required', 'min:8', 'confirmed'],
	    ]);

	    if ($validator->fails()) {
	        return response()->json(['errors' => $validator->errors()], 422);
	    }

	    $user = auth()->user(); 
	    if (!Hash::check($request->current_password, $user->password)) {
	        return response()->json(['errors' => ['current_password' => ['Current password is incorrect.']]], 422);
	    }

	    $user->update([
	        'password' => Hash::make($request->new_password),
	    ]);

	    return response()->json(['success' => 'Password changed successfully!']);
	}
}
