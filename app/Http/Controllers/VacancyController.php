<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vacancy;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class VacancyController extends Controller
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

    public function index(Request $req)
    {
        $filter = $req->query('filter');
        $queryFilter = $req->query('q');

        $jobs = Vacancy::latest();

        if ($filter == "on-going-expired") {
            $jobs = Vacancy::where(['status' => 1])->whereBetween('expired_at', [
                Carbon::today(),
                Carbon::today()->addDays(config("app.vacancy_expired"))
            ]);
        } else if ($filter == "inactive") {
            $jobs = Vacancy::where(['status' => 0]);
        } else if ($filter == "active") {
            $jobs = Vacancy::where(['status' => 1]);
        }

        if ($queryFilter) {
            $jobs = $jobs->where(function ($query) use ($queryFilter) {
                $query->where('title', 'like', "%{$queryFilter}%")
                    ->orWhere('job_code', 'like', "%{$queryFilter}%")
                    ->orWhere('placement', 'like', "%{$queryFilter}%");
            });
        }

        return view('admin.vacancy.all', [
            'jobs' => $jobs->get(),
            'totalJobs' => Vacancy::count(),
            'totalActiveJobs' => Vacancy::where(['status' => 1])->count(),
            'totalInactiveJobs' => Vacancy::where(['status' => 0])->count(),
            'onGoingExpired' => Vacancy::whereBetween('expired_at', [
                Carbon::today(),
                Carbon::today()->addDays(config("app.vacancy_expired"))
            ])->count(),
        ]);
    }

    public function create()
    {
        return view('admin.vacancy.create');
    }

    public function store(Request $req)
    {
        $validated = $req->validate(
            [
                'job-id' => ['required', 'unique:vacancies,job_code', 'min:3', 'max:12'],
                'job-title' => ['required'],
                'visa-type' => ['required'],
                'job-placement' => ['required'],
                'job-type' => ['required'],
                'whatsapp-number' => ['required'],
                'gender-requirement' => ['required'],
                'domicile-requirement' => ['required'],
                'qty' => ['required', 'integer', 'min:1'],
                'source' => ['nullable', 'url'],
                'salary-from' => ['required'],
                'salary-to' => ['nullable'],
                'benefit' => ['nullable', 'array'],
                'benefit.*' => ['string'],
                'expiration-date' => ['required'],
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
                'job-id.min' => 'Job ID minimal 3 karakter.',
                'job-id.max' => 'Job ID maksimal 12 karakter.',
                'job-title.required' => 'Nama job wajib diisi.',
                'visa-type.required' => 'Jenis VISA wajib diisi.',
                'job-placement.required' => 'Penempatan wajib diisi.',
                'job-type.required' => 'Jenis pekerjaan wajib diisi.',
                'salary-from.required' => 'Minimal gaji wajib diisi.',
                'whatsapp-number.required' => 'Nomor WhatsApp wajib diisi.',
                'gender-requirement.required' => 'Persyaratan gender wajib diisi.',
                'domicile-requirement.required' => 'Persyaratan domisili wajib diisi.',
                'qty.required' => 'Kuantitas dibutuhkan wajib diisi.',
                'qty.integer' => 'Kuantitas dibutuhkan harus berupa angka.',
                'qty.min' => 'Kuantitas dibutuhkan minimal 1.',
                'additional-information.required' => 'Informasi tambahan wajib diisi.',
                'additional-information.json' => 'Format deskripsi pekerjaan tidak valid.',
                'expiration-date.required' => 'Tenggat waktu wajib diisi.',
            ]
        );

        $benefits = $validated['benefit'] ?? [];

        $salary = $validated['salary-from'];

        if ($validated['salary-to']) {
            $salary = $validated['salary-from'] . '-' . $validated['salary-to'];
        }

        $job = Vacancy::create([
            'job_code' => $validated['job-id'],
            'title' => $validated['job-title'],
            'visa_type' => $validated['visa-type'],
            'placement' => $validated['job-placement'],
            'job_type' => $validated['job-type'],
            'salary' => $salary,
            'whatsapp_number' => $validated['whatsapp-number'],
            'gender_requirement' => $validated['gender-requirement'],
            'domicile_requirement' => $validated['domicile-requirement'],
            'qty' => $validated['qty'],
            'source' => $validated['source'] ?? null,
            'benefit' => count($benefits) ? implode('|', $benefits) : null,
            'expired_at' => $validated['expiration-date'],
            'additional_information' => $validated['additional-information'],
        ]);

        return redirect()
            ->route("admin.vacancy.detail", $job->job_code)
            ->with("msg", ['success', 'Berhasil Menambahkan', 'Lowongan berhasil ditambahkan!']);
    }

    public function detail($id)
    {
        $job = Vacancy::where('job_code', $id)->firstOrFail();

        return view('admin.vacancy.detail', [
            'job' => $job,
        ]);
    }

    public function edit($id)
    {
        $job = Vacancy::where('job_code', $id)->firstOrFail();

        return view('admin.vacancy.edit', [
            'job' => $job,
        ]);
    }

    public function update(Request $req, $id)
    {
        $job = Vacancy::where('job_code', $id)->firstOrFail();

        $validated = $req->validate(
            [
                'job-title' => ['required'],
                'visa-type' => ['required'],
                'job-placement' => ['required'],
                'job-type' => ['required'],
                'salary-from' => ['required'],
                'salary-to' => ['nullable'],
                'whatsapp-number' => ['required'],
                'gender-requirement' => ['required'],
                'domicile-requirement' => ['required'],
                'qty' => ['required', 'integer', 'min:1'],
                'source' => ['nullable', 'url'],
                'benefit' => ['nullable', 'array'],
                'benefit.*' => ['string'],
                'expiration-date' => ['required'],
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
                'visa-type.required' => 'Tipe VISA wajib diisi.',
                'job-placement.required' => 'Penempatan wajib diisi.',
                'job-type.required' => 'Jenis pekerjaan wajib diisi.',
                'salary-from.required' => 'Minimal gaji wajib diisi.',
                'whatsapp-number.required' => 'Nomor WhatsApp wajib diisi.',
                'gender-requirement.required' => 'Persyaratan gender wajib diisi.',
                'domicile-requirement.required' => 'Persyaratan domisili wajib diisi.',
                'qty.required' => 'Kuantitas dibutuhkan wajib diisi.',
                'qty.integer' => 'Kuantitas dibutuhkan harus berupa angka.',
                'qty.min' => 'Kuantitas dibutuhkan minimal 1.',
                'expiration-date.required' => 'Tenggat waktu wajib diisi.',
                'additional-information.required' => 'Informasi tambahan wajib diisi.',
                'additional-information.json' => 'Format deskripsi pekerjaan tidak valid.',
            ]
        );

        $benefits = $validated['benefit'] ?? [];

        $salary = $validated['salary-from'];

        if ($validated['salary-to']) {
            $salary = $validated['salary-from'] . '-' . $validated['salary-to'];
        }

        $job->update([
            'title' => $validated['job-title'],
            'visa_type' => $validated['visa-type'],
            'placement' => $validated['job-placement'],
            'job_type' => $validated['job-type'],
            'salary' => $salary,
            'whatsapp_number' => $validated['whatsapp-number'],
            'gender_requirement' => $validated['gender-requirement'],
            'domicile_requirement' => $validated['domicile-requirement'],
            'qty' => $validated['qty'],
            'source' => $validated['source'] ?? null,
            'benefit' => count($benefits) ? implode('|', $benefits) : null,
            'additional_information' => $validated['additional-information'],
            'expired_at' => $validated['expiration-date'],
        ]);

        return redirect()->route("admin.vacancy.detail", $job->job_code)->with("msg", ["success", "Berhasil Mengedit", "Data pekerjaan berhasil diperbarui"]);
    }

    public function updateThumbnail(Request $req, $id)
    {
        $job = Vacancy::where('job_code', $id)->firstOrFail();

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

        return redirect()
            ->route("admin.vacancy.detail", $job->job_code)
            ->with("msg", ["success", "Berhasil Upload", "Thumbnail berhasil diupload"]);
    }

    public function destroy($id)
    {
        $job = Vacancy::where('job_code', $id)->firstOrFail();

        if ($job->thumbnail_path) {
            Storage::disk('public')->delete($job->thumbnail_path);
        }

        $job->delete();

        return redirect()->route("admin.vacancies")->with("msg", ["success", "Loker Dihapus", "Loker berhasil dihapus"]);
    }

    public function changeStatus($id)
    {
        $job = Vacancy::where('job_code', $id)->firstOrFail();

        $job->update([
            'status' => $job->status ? 0 : 1,
        ]);

        $title = $job->status ? 'Lowongan Dibuka' : 'Lowongan Ditutup';
        $msg = $job->status ? 'Pendaftaran berhasil dibuka' : 'Pendaftaran berhasil ditutup';

        return redirect()->route("admin.vacancy.detail", $job->job_code)->with("msg", ["success", $title, $msg]);
    }

    // public function storeTempThumbnail(Request $request)
    // {
    //     if ($request->hasFile('thumbnail')) {
    //         $file = $request->file('thumbnail');
    //         $folder = uniqid('post-', true);
    //         $filename = $file->getClientOriginalName();

    //         // Simpen di folder temporary
    //         $file->storeAs('public/tmp/' . $folder, $filename);

    //         // Balikin folder ID biar FilePond nyimpen ID ini di hidden input
    //         return $folder;
    //     }
    //     return response()->json(['error' => 'Gagal upload'], 400);
    // }
}
