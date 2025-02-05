<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        
        return view('admin.dashboard.index', [
            'userCount' => $userCount,
            'title' => 'Dashboard'
        ]);
    }
}
