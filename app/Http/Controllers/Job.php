<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Job extends Controller
{
    public function index()
    {
        return view('admin.job');
    }

    public function store(Request $req)
    {
        $validated = $req->validate(
            [
                'job-id' => ['required'],
                'job-title' => ['required'],
                'company' => ['required'],
                'job-placement' => ['required'],
                'job-type' => ['required'],
                'job-sallary' => ['required'],
                'gender-requirement' => ['required'],
                'domicile-requirement' => ['required'],
                'qty' => ['required'],
                'additional-information' => ['required'],
            ],
            [
                'job-id.required' => 'Job ID wajib diisi.',
                'job-title.required' => 'Nama job wajib diisi.',
                'company.required' => 'Nama perusahaan wajib diisi.',
                'job-placement.required' => 'Penempatan wajib diisi.',
                'job-type.required' => 'Jenis pekerjaan wajib diisi.',
                'job-sallary.required' => 'Gaji wajib diisi.',
                'gender-requirement.required' => 'Persyaratan gender wajib diisi.',
                'domicile-requirement.required' => 'Persyaratan domisili wajib diisi.',
                'qty.required' => 'Kuantitas dibutuhkan wajib diisi.',
                'additional-information.required' => 'Informasi tambahan wajib diisi.',
            ]
        );

        return response()->json([
            "status" => "success",
            "data-post" => $validated
        ]);
    }
}
