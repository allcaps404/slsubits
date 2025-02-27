<?php

namespace App\Http\Controllers\Alumni;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Yearbook;
use App\Http\Controllers\Controller;

class YearbookController extends Controller
{
    public function index()
    {
        $yearbook = Yearbook::where('user_id', Auth::id())->first();

        if (!$yearbook) {
            return view('alumni.yearbook.index', ['yearbook' => null,'page'=>'Yearbook Information', 'message' => 'Sorry, you haven’t uploaded your graduation picture yet. Please upload it below.']);
        }

        return view('alumni.yearbook.index', [
            'yearbook' => $yearbook, 
            'message' => '',
            'page'=>'Yearbook Information'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'grad_pic' => 'required|image|mimes:jpeg,png,jpg,gif',
            'motto' => 'required|string|max:255',
            'grad_year' => 'required|date',
        ]);

        $gradPicPath = $request->file('grad_pic')->store('yearbook_pics', 'public');

        $yearbook = Yearbook::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'grad_pic' => $gradPicPath,
                'motto' => $request->input('motto'),
                'grad_year' => $request->input('grad_year'),
            ]
        );

        return redirect()->route('yearbook.index')->with('success', 'Yearbook details updated successfully!');
    }
}
