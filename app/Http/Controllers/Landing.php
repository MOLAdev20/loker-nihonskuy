<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Http\Request;

class Landing extends Controller
{
    public function index()
    {
        $jobs = JobListing::latest()->take(6)->get();

        return view('landing.main', [
            'jobs' => $jobs,
        ]);
    }

    public function explore(Request $request)
    {
        $query = JobListing::query();

        if ($request->filled('q')) {
            $keyword = $request->string('q')->toString();
            $query->where(function ($builder) use ($keyword) {
                $builder->where('title', 'like', "%{$keyword}%")
                    ->orWhere('visa_type', 'like', "%{$keyword}%")
                    ->orWhere('job_type', 'like', "%{$keyword}%")
                    ->orWhere('placement', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('location')) {
            $location = $request->string('location')->toString();
            $query->where('placement', 'like', "%{$location}%");
        }

        $jobs = $query->latest()->paginate(12)->withQueryString();

        return view('landing.explore', [
            'jobs' => $jobs,
            'totalJobs' => JobListing::count(),
        ]);
    }

    public function detail($id)
    {
        $job = JobListing::where('job_code', $id)->firstOrFail();

        return view('landing.detail', [
            'job' => $job,
        ]);
    }
}
