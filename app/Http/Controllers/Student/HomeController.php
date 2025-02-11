<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OtherDetail;
use App\Models\Announcement;

class HomeController extends Controller
{
    public function index()
    {
    	$getOtherdetails = OtherDetail::Where('user_id', auth()->user()->id)
    									->first();
    	$announcements = Announcement::orderBy('date', 'desc')->get();
    	return view('student.home.index',[
    		'title' => 'Home',
    		'otherdetails'=> $getOtherdetails,
    		'announcements'=> $announcements
    	]);
    }
}