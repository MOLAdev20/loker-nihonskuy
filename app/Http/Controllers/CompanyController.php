<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CompanyController extends Controller
{
    public function landingIndex()
    {
        $companies = Company::query()
            ->orderByDesc('id')
            ->get();

        return view('landing.jp-company', [
            'companies' => $companies,
            'locationCount' => $companies->pluck('location')->filter()->unique()->count(),
        ]);
    }

    public function landingShow(string $company)
    {
        return view('landing.jp-company-detail', [
            'company' => $this->resolvePublicCompany($company),
        ]);
    }

    public function index()
    {
        $companies = Company::query()
            ->orderByDesc('id')
            ->paginate(10);

        return view('admin.company.index', [
            'companies' => $companies,
            'totalCompanies' => Company::query()->count(),
            'totalLocations' => Company::query()->distinct('location')->count('location'),
        ]);
    }

    public function create()
    {
        return view('admin.company.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request, true);
        $validated['logo'] = $this->storeLogo($request->file('logo'));

        Company::create($validated);

        return redirect()
            ->route('admin.company.index')
            ->with('status', 'Data perusahaan berhasil ditambahkan.');
    }

    public function show(Company $company)
    {
        return view('admin.company.show', [
            'company' => $company,
        ]);
    }

    public function edit(Company $company)
    {
        return view('admin.company.edit', [
            'company' => $company,
        ]);
    }

    public function update(Request $request, Company $company)
    {
        $validated = $this->validateRequest($request, false);

        if ($request->hasFile('logo')) {
            $this->deleteLogo($company->logo);
            $validated['logo'] = $this->storeLogo($request->file('logo'));
        } else {
            unset($validated['logo']);
        }

        $company->update($validated);

        return redirect()
            ->route('admin.company.show', $company)
            ->with('status', 'Data perusahaan berhasil diperbarui.');
    }

    public function destroy(Company $company)
    {
        $this->deleteLogo($company->logo);
        $company->delete();

        return redirect()
            ->route('admin.company.index')
            ->with('status', 'Data perusahaan berhasil dihapus.');
    }

    public function logo(Company $company): BinaryFileResponse
    {
        $path = ltrim((string) $company->logo, '/');

        abort_if($path === '', 404);

        $publicFilePath = public_path($path);
        if (is_file($publicFilePath)) {
            return response()->file($publicFilePath);
        }

        if (Storage::disk('public')->exists($path)) {
            return response()->file(Storage::disk('public')->path($path));
        }

        abort(404);
    }

    private function validateRequest(Request $request, bool $isCreate): array
    {
        $logoRule = $isCreate
            ? ['required', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048']
            : ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'];

        return $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'logo' => $logoRule,
                'bio' => ['required', 'string', 'max:255'],
                'location' => ['required', 'string', 'max:255'],
                'website' => ['required', 'string', 'max:255'],
                'field' => ['required', 'string', 'max:255'],
                'facility' => ['required', 'string', 'max:255'],
                'established' => ['required', 'string', 'max:255'],
            ],
            [
                'required' => ':attribute wajib diisi.',
                'string' => ':attribute harus berupa teks.',
                'max' => ':attribute maksimal :max karakter.',
                'logo.image' => 'Logo harus berupa file gambar.',
                'logo.mimes' => 'Logo harus berformat jpg, jpeg, png, webp, atau svg.',
                'logo.max' => 'Ukuran logo maksimal 2 MB.',
            ],
            [
                'name' => 'Nama perusahaan',
                'logo' => 'Logo perusahaan',
                'bio' => 'Profil perusahaan',
                'location' => 'Lokasi',
                'website' => 'Website',
                'field' => 'Bidang perusahaan',
                'facility' => 'Fasilitas',
                'established' => 'Tahun berdiri',
            ],
        );
    }

    private function storeLogo(UploadedFile $logo): string
    {
        return $logo->store('company-logos', 'public');
    }

    private function deleteLogo(?string $path): void
    {
        if (! $path) {
            return;
        }

        if (preg_match('/^https?:\/\//i', $path)) {
            return;
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    private function resolvePublicCompany(string $slug): Company
    {
        $companyId = (int) Str::before($slug, '-');

        if ($companyId > 0) {
            return Company::query()->findOrFail($companyId);
        }

        $company = Company::query()
            ->get()
            ->first(fn (Company $item) => Str::slug($item->name) === $slug);

        abort_unless($company, 404);

        return $company;
    }
}
