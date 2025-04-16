<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Services\JobStreetApiService;

class AlumniController extends Controller
{
    protected $jobStreetApiService;

    public function __construct(JobStreetApiService $jobStreetApiService)
    {
        $this->jobStreetApiService = $jobStreetApiService;
    }

    public function index()
    {
        $jobListings = $this->jobStreetApiService->getJobListings([
            'location' => 'Singapore',
            'job_type' => 'full-time',
        ]);

        return view('alumni.joblisting.index', compact('jobListings'));
    }
}
