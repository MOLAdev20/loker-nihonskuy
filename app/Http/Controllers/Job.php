<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobListing;
use Illuminate\Support\Facades\Storage;

class Job extends Controller
{
    private function isEmptyQuillDelta(array $delta): bool
    {
        if (! isset($delta['ops']) || ! is_array($delta['ops'])) {
            return true;
        }

        $plainText = '';

        foreach ($delta['ops'] as $op) {
            if (is_array($op) && isset($op['insert']) && is_string($op['insert'])) {
                $plainText .= $op['insert'];
            }
        }

        return trim($plainText) === '';
    }

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
                'whatsapp-number' => ['required'],
                'gender-requirement' => ['required'],
                'domicile-requirement' => ['required'],
                'qty' => ['required', 'integer', 'min:1'],
                'source' => ['nullable', 'url'],
                'benefit' => ['nullable', 'array'],
                'benefit.*' => ['string'],
                'additional-information' => [
                    'required',
                    'json',
                    function (string $attribute, mixed $value, \Closure $fail) {
                        $delta = json_decode((string) $value, true);

                        if (! is_array($delta) || ! isset($delta['ops']) || ! is_array($delta['ops'])) {
                            $fail('Format deskripsi pekerjaan tidak valid.');
                            return;
                        }

                        if ($this->isEmptyQuillDelta($delta)) {
                            $fail('Informasi tambahan wajib diisi.');
                        }
                    },
                ],
            ],
            [
                'job-id.required' => 'Job ID wajib diisi.',
                'job-id.unique' => 'Job ID sudah digunakan.',
                'job-title.required' => 'Nama job wajib diisi.',
                'company.required' => 'Nama perusahaan wajib diisi.',
                'job-placement.required' => 'Penempatan wajib diisi.',
                'job-type.required' => 'Jenis pekerjaan wajib diisi.',
                'job-sallary.required' => 'Gaji wajib diisi.',
                'whatsapp-number.required' => 'Nomor WhatsApp wajib diisi.',
                'gender-requirement.required' => 'Persyaratan gender wajib diisi.',
                'domicile-requirement.required' => 'Persyaratan domisili wajib diisi.',
                'qty.required' => 'Kuantitas dibutuhkan wajib diisi.',
                'qty.integer' => 'Kuantitas dibutuhkan harus berupa angka.',
                'qty.min' => 'Kuantitas dibutuhkan minimal 1.',
                'additional-information.required' => 'Informasi tambahan wajib diisi.',
                'additional-information.json' => 'Format deskripsi pekerjaan tidak valid.',
            ]
        );

        $benefits = $validated['benefit'] ?? [];

        $job = JobListing::create([
            'job_code' => $validated['job-id'],
            'title' => $validated['job-title'],
            'company_name' => $validated['company'],
            'placement' => $validated['job-placement'],
            'job_type' => $validated['job-type'],
            'salary' => $validated['job-sallary'],
            'whatsapp_number' => $validated['whatsapp-number'],
            'gender_requirement' => $validated['gender-requirement'],
            'domicile_requirement' => $validated['domicile-requirement'],
            'qty' => $validated['qty'],
            'source' => $validated['source'] ?? null,
            'benefit' => count($benefits) ? implode('|', $benefits) : null,
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
                'whatsapp-number' => ['required'],
                'gender-requirement' => ['required'],
                'domicile-requirement' => ['required'],
                'qty' => ['required', 'integer', 'min:1'],
                'source' => ['nullable', 'url'],
                'benefit' => ['nullable', 'array'],
                'benefit.*' => ['string'],
                'additional-information' => [
                    'required',
                    'json',
                    function (string $attribute, mixed $value, \Closure $fail) {
                        $delta = json_decode((string) $value, true);

                        if (! is_array($delta) || ! isset($delta['ops']) || ! is_array($delta['ops'])) {
                            $fail('Format deskripsi pekerjaan tidak valid.');
                            return;
                        }

                        if ($this->isEmptyQuillDelta($delta)) {
                            $fail('Informasi tambahan wajib diisi.');
                        }
                    },
                ],
            ],
            [
                'job-title.required' => 'Nama job wajib diisi.',
                'company.required' => 'Nama perusahaan wajib diisi.',
                'job-placement.required' => 'Penempatan wajib diisi.',
                'job-type.required' => 'Jenis pekerjaan wajib diisi.',
                'job-sallary.required' => 'Gaji wajib diisi.',
                'whatsapp-number.required' => 'Nomor WhatsApp wajib diisi.',
                'gender-requirement.required' => 'Persyaratan gender wajib diisi.',
                'domicile-requirement.required' => 'Persyaratan domisili wajib diisi.',
                'qty.required' => 'Kuantitas dibutuhkan wajib diisi.',
                'qty.integer' => 'Kuantitas dibutuhkan harus berupa angka.',
                'qty.min' => 'Kuantitas dibutuhkan minimal 1.',
                'additional-information.required' => 'Informasi tambahan wajib diisi.',
                'additional-information.json' => 'Format deskripsi pekerjaan tidak valid.',
            ]
        );

        $benefits = $validated['benefit'] ?? [];

        $job->update([
            'title' => $validated['job-title'],
            'company_name' => $validated['company'],
            'placement' => $validated['job-placement'],
            'job_type' => $validated['job-type'],
            'salary' => $validated['job-sallary'],
            'whatsapp_number' => $validated['whatsapp-number'],
            'gender_requirement' => $validated['gender-requirement'],
            'domicile_requirement' => $validated['domicile-requirement'],
            'qty' => $validated['qty'],
            'source' => $validated['source'] ?? null,
            'benefit' => count($benefits) ? implode('|', $benefits) : null,
            'additional_information' => $validated['additional-information'],
        ]);

        return redirect("/admin/jobs/detail/{$job->job_code}");
    }

    public function updateThumbnail(Request $req, $id)
    {
        $job = JobListing::where('job_code', $id)->firstOrFail();

        $validated = $req->validate(
            [
                'thumbnail' => ['required', 'image', 'max:2048'],
            ],
            [
                'thumbnail.required' => 'Thumbnail wajib diunggah.',
                'thumbnail.image' => 'Thumbnail harus berupa gambar.',
                'thumbnail.max' => 'Ukuran thumbnail maksimal 2MB.',
            ]
        );

        if (! empty($job->thumbnail_path)) {
            Storage::disk('public')->delete($job->thumbnail_path);
        }

        $path = $validated['thumbnail']->store('job-thumbnails', 'public');

        $job->update([
            'thumbnail_path' => $path,
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
