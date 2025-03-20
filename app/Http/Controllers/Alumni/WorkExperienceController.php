<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkExperience;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

$workExperiences = WorkExperience::all()->map(function ($experience) {
    $experience->short_description = Str::limit($experience->description, 100);
    return $experience;
});

class WorkExperienceController extends Controller
{
    /**
     * Display the user's work experiences.
     */
    public function index()
    {
        $workExperiences = WorkExperience::OrderBy('created_at','DESC')
                                            ->where('user_id', Auth::id())
                                            ->get();

        return view('alumni.work_experience.index', [
            'workExperiences' => $workExperiences,
            'page' => 'Work Experience',
            'message' => $workExperiences->isEmpty() ? 'You have not added any work experiences yet. Add one below.' : '',
        ]);
    }

    /**
     * Show the form for adding a work experience.
     */
    public function create()
    {
        return view('alumni.work_experience.create');
    }

    /**
     * Store a new work experience.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'position' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
           'respondent_affiliation' => 'required|in:Government,Non-Government,Private,Public Corporation,Startup,Multinational Corporation (MNC),Small and Medium Enterprise (SME),Freelance,Partnership,Cooperative,Educational Institution,Healthcare,Financial Institution,Manufacturing,Retail,Technology,Construction,Hospitality,Real Estate,Media,Others',
    ]);
        if ($validator->fails()) {
	        return response()->json(['errors' => $validator->errors()], 422);
	    }
        
        // Debugging: Log request data
        \Log::info('Storing Work Experience', $request->all());

        // Store multiple work experiences
        WorkExperience::create([
            'user_id' => Auth::id(),
            'position' => $request->input('position'),
            'company_name' => $request->input('company_name'),
            'contact_number' => $request->input('contact_number'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'currently_working' => $request->boolean('currently_working'),
            'description' => $request->input('description'),
            'respondent_affiliation' => $request->input('respondent_affiliation'),
        ]);
        return redirect()->route('work_experiences.index')->with('success', 'Work experience added successfully.');
    }

    /**
     * Show the form for editing a work experience.
     */
    public function edit($id) {
        $workExperience = WorkExperience::where('user_id', Auth::id())->findOrFail($id);
        return view('alumni.work_experience.edit', compact('workExperience'));
    }

    /**
     * Update a work experience.
     */
    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'position' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
            'respondent_affiliation' => 'required|in:Government,Non-Government,Private,Public Corporation,Startup,Multinational Corporation (MNC),Small and Medium Enterprise (SME),Freelance,Partnership,Cooperative,Educational Institution,Healthcare,Financial Institution,Manufacturing,Retail,Technology,Construction,Hospitality,Real Estate,Media,Others',
    ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $workExperience = WorkExperience::where('user_id', Auth::id())->findOrFail($id);
        $workExperience->update([
            'position' => $request->input('position'),
            'company_name' => $request->input('company_name'),
            'contact_number' => $request->input('contact_number'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'currently_working' => $request->has('currently_working'),
            'description' => $request->input('description'),
            'respondent_affiliation' => $request->input('respondent_affiliation'),
        ]);

        return redirect()->route('work_experiences.index')->with('success', 'Work experience updated successfully.');
    }

    /**
     * Remove a work experience.
     */
    public function destroy($id) {
        $workExperience = WorkExperience::where('user_id', Auth::id())->findOrFail($id);
        $workExperience->delete();

        return redirect()->route('work_experiences.index')->with('success', 'Work experience deleted successfully.');
    }
}
