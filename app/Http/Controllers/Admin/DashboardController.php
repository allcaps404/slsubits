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


        return view('admin.dashboard.index', [
            'totalRegisteredAdmins' => $totalRegisteredAdmins,
            'totalRegisteredStudents' => $totalRegisteredStudents,
            'totalRegisteredScanners' => $totalRegisteredScanners ,
            'title' => 'Dashboard'
        ]);
    }
}
