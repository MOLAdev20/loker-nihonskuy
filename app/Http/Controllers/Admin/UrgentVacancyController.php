<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UrgentVacancy;
use App\Models\Vacancy;
use App\Services\UrgentVacancyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UrgentVacancyController extends Controller
{
    public function __construct(private readonly UrgentVacancyService $urgentVacancyService)
    {
    }

    public function index(): View
    {
        $urgentVacancies = UrgentVacancy::query()
            ->with('vacancy')
            ->orderBy('order')
            ->get();

        $selectedVacancyIds = $urgentVacancies
            ->pluck('job_id')
            ->filter()
            ->values();

        $availableVacancies = Vacancy::query()
            ->whereNotIn('id', $selectedVacancyIds)
            ->orderByDesc('status')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.vacancy.urgent', [
            'urgentVacancies' => $urgentVacancies,
            'availableVacancies' => $availableVacancies,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'job_id' => [
                'required',
                'integer',
                'exists:vacancies,id',
                'unique:urgent_vacancies,job_id',
            ],
        ], [
            'job_id.required' => 'Pilih loker yang ingin dijadikan prioritas.',
            'job_id.exists' => 'Loker yang dipilih tidak ditemukan.',
            'job_id.unique' => 'Loker tersebut sudah ada di daftar prioritas.',
        ]);

        $vacancy = Vacancy::findOrFail($validated['job_id']);

        $this->urgentVacancyService->add($vacancy);

        return redirect()
            ->route('admin.vacancy.urgent.index')
            ->with('msg', ['success', 'Loker Prioritas Ditambahkan', 'Loker berhasil dimasukkan ke daftar prioritas.']);
    }

    public function updateOrder(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'urgent_vacancy_ids' => ['required', 'array', 'min:1'],
            'urgent_vacancy_ids.*' => ['integer', 'distinct'],
        ], [
            'urgent_vacancy_ids.required' => 'Urutan loker prioritas tidak boleh kosong.',
        ]);

        try {
            $this->urgentVacancyService->reorder($validated['urgent_vacancy_ids']);
        } catch (\InvalidArgumentException) {
            return redirect()
                ->route('admin.vacancy.urgent.index')
                ->with('msg', ['error', 'Urutan Tidak Valid', 'Sebagian data loker prioritas tidak valid.']);
        }

        return redirect()
            ->route('admin.vacancy.urgent.index')
            ->with('msg', ['success', 'Urutan Disimpan', 'Urutan loker prioritas berhasil diperbarui.']);
    }

    public function destroy(UrgentVacancy $urgentVacancy): RedirectResponse
    {
        $this->urgentVacancyService->remove($urgentVacancy);

        return redirect()
            ->route('admin.vacancy.urgent.index')
            ->with('msg', ['success', 'Loker Prioritas Dihapus', 'Loker berhasil dikeluarkan dari daftar prioritas.']);
    }
}
