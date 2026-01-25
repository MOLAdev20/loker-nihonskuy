<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobListing;

class Job extends Controller
{
    public function index()
    {
        $jobs = JobListing::latest()->get();

        return view('admin.job', [
            'jobs' => $jobs,
        ]);
    }

    public function create()
    {
        return view('admin.job-create');
    }

    public function store(Request $req)
    {
        $validated = $req->validate(
            [
                'job-id' => ['required', 'unique:job_listings,job_code'],
                'job-title' => ['required'],
                'company' => ['required'],
                'job-placement' => ['required'],
                'job-type' => ['required'],
                'job-sallary' => ['required'],
                'gender-requirement' => ['required'],
                'domicile-requirement' => ['required'],
                'qty' => ['required', 'integer', 'min:1'],
                'additional-information' => ['required'],
            ],
            [
                'job-id.required' => 'Job ID wajib diisi.',
                'job-id.unique' => 'Job ID sudah digunakan.',
                'job-title.required' => 'Nama job wajib diisi.',
                'company.required' => 'Nama perusahaan wajib diisi.',
                'job-placement.required' => 'Penempatan wajib diisi.',
                'job-type.required' => 'Jenis pekerjaan wajib diisi.',
                'job-sallary.required' => 'Gaji wajib diisi.',
                'gender-requirement.required' => 'Persyaratan gender wajib diisi.',
                'domicile-requirement.required' => 'Persyaratan domisili wajib diisi.',
                'qty.required' => 'Kuantitas dibutuhkan wajib diisi.',
                'qty.integer' => 'Kuantitas dibutuhkan harus berupa angka.',
                'qty.min' => 'Kuantitas dibutuhkan minimal 1.',
                'additional-information.required' => 'Informasi tambahan wajib diisi.',
            ]
        );

        $job = JobListing::create([
            'job_code' => $validated['job-id'],
            'title' => $validated['job-title'],
            'company_name' => $validated['company'],
            'placement' => $validated['job-placement'],
            'job_type' => $validated['job-type'],
            'salary' => $validated['job-sallary'],
            'gender_requirement' => $validated['gender-requirement'],
            'domicile_requirement' => $validated['domicile-requirement'],
            'qty' => $validated['qty'],
            'additional_information' => $validated['additional-information'],
        ]);

        return redirect("/admin/jobs/detail/{$job->job_code}");
    }

    public function detail($id)
    {
        $job = JobListing::where('job_code', $id)->firstOrFail();

        return view('admin.job-detail', [
            'job' => $job,
        ]);
    }

    public function edit($id)
    {
        $job = JobListing::where('job_code', $id)->firstOrFail();

        return view('admin.job-edit', [
            'job' => $job,
        ]);
    }

    public function update(Request $req, $id)
    {
        $job = JobListing::where('job_code', $id)->firstOrFail();

        $validated = $req->validate(
            [
                'job-title' => ['required'],
                'company' => ['required'],
                'job-placement' => ['required'],
                'job-type' => ['required'],
                'job-sallary' => ['required'],
                'gender-requirement' => ['required'],
                'domicile-requirement' => ['required'],
                'qty' => ['required', 'integer', 'min:1'],
                'additional-information' => ['required'],
            ],
            [
                'job-title.required' => 'Nama job wajib diisi.',
                'company.required' => 'Nama perusahaan wajib diisi.',
                'job-placement.required' => 'Penempatan wajib diisi.',
                'job-type.required' => 'Jenis pekerjaan wajib diisi.',
                'job-sallary.required' => 'Gaji wajib diisi.',
                'gender-requirement.required' => 'Persyaratan gender wajib diisi.',
                'domicile-requirement.required' => 'Persyaratan domisili wajib diisi.',
                'qty.required' => 'Kuantitas dibutuhkan wajib diisi.',
                'qty.integer' => 'Kuantitas dibutuhkan harus berupa angka.',
                'qty.min' => 'Kuantitas dibutuhkan minimal 1.',
                'additional-information.required' => 'Informasi tambahan wajib diisi.',
            ]
        );

        $job->update([
            'title' => $validated['job-title'],
            'company_name' => $validated['company'],
            'placement' => $validated['job-placement'],
            'job_type' => $validated['job-type'],
            'salary' => $validated['job-sallary'],
            'gender_requirement' => $validated['gender-requirement'],
            'domicile_requirement' => $validated['domicile-requirement'],
            'qty' => $validated['qty'],
            'additional_information' => $validated['additional-information'],
        ]);

        return redirect("/admin/jobs/detail/{$job->job_code}");
    }

    public function destroy($id)
    {
        $job = JobListing::where('job_code', $id)->firstOrFail();
        $job->delete();

        return redirect("/admin/jobs");
    }
}
