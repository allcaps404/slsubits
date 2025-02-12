<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class FaceAuthController extends Controller
{
    public function showFaceRegistration()
    {
        return view('student.settings.face-registration');
    }

    public function storeFace(Request $request)
    {
        $user = Auth::user();
        $user->face_data = $request->face_descriptor;
        $user->save();

        return response()->json(['success' => 'Face Registered Successfully']);
    }
}
