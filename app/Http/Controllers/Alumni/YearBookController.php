<?php

namespace App\Http\Controllers\Alumni;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\YearBook;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class YearbookController extends Controller
{
    public function index()
    {
        $yearbook = YearBook::where('user_id', Auth::id())->first();

        if (!$yearbook) {
            return view('alumni.yearbook.index', [
                'yearbook' => null, 
                'page' => 'Yearbook Information', 
                'message' => 'Sorry, you haven’t uploaded your graduation picture yet. Please upload it below.'
            ]);
        }

        return view('alumni.yearbook.index', [
            'yearbook' => $yearbook,
            'yearbook_id' => $yearbook ? $yearbook->id : null,
            'message' => '',
            'page' => 'Yearbook'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'motto' => 'required|string|max:255',
            'grad_year' => 'required|date',
        ]);

        $yearbook = YearBook::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'grad_pic' => $request->input('grad_pic_base64'),
                'motto' => $request->input('motto'),
                'grad_year' => $request->input('grad_year'),
            ]
        );

        return redirect()->route('yearbook.index')->with('success', 'Yearbook details updated successfully!');
    }
}
