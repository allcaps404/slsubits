<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRegisteredAdmins = User::where('role_id',1)
        									->count();
		$totalRegisteredStudents = User::where('role_id',2)
        									->count();
        $totalRegisteredScanners = User::where('role_id',3)
        									->count();
        $totalRegisteredEventOrganizers = User::where('role_id',4)
                                            ->count();
        $totalRegisteredAlumnus = User::where('role_id', 5)
                                            ->count();
         $totalRegisteredAlumnae = User::where('role_id', 6)
                                            ->count();


        return view('admin.dashboard.index', [
            'totalRegisteredAdmins' => $totalRegisteredAdmins,
            'totalRegisteredStudents' => $totalRegisteredStudents,
            'totalRegisteredScanners' => $totalRegisteredScanners ,
            'totalRegisteredEventOrganizers' => $totalRegisteredEventOrganizers,
            'totalRegisteredAlumnus' => $totalRegisteredAlumnus,
            'totalRegisteredAlumnae' => $totalRegisteredAlumnae,
            'title' => 'Dashboard'
        ]);
    }
}
