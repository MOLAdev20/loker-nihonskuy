<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserEducationHistoryRequest;
use App\Models\User\UserEducationHistory;
use App\Models\User\UserProfile;

class EducationController extends Controller
{
    public function index()
    {
        $profile = UserProfile::where('user_id', auth()->id())->first();
        $educationHistories = UserEducationHistory::where('user_id', auth()->id())
            ->orderByDesc('id')
            ->get();

        return view('user.education-history-form', [
            'profile' => $profile,
            'educationHistories' => $educationHistories,
        ]);
    }

    public function store(StoreUserEducationHistoryRequest $request)
    {
        $educationHistoryPayload = $this->mapEducationHistoryPayload($request->validated());

        UserEducationHistory::create([
            'user_id' => auth()->id(),
            ...$educationHistoryPayload,
        ]);

        return redirect()
            ->route('user.education-history')
            ->with('status', 'Data riwayat pendidikan berhasil ditambahkan.');
    }

    public function update(StoreUserEducationHistoryRequest $request, int $id)
    {
        $educationHistory = $this->getOwnedEducationHistoryById($id);
        $educationHistoryPayload = $this->mapEducationHistoryPayload($request->validated());

        $educationHistory->update($educationHistoryPayload);

        return redirect()
            ->route('user.education-history')
            ->with('status', 'Data riwayat pendidikan berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $educationHistory = $this->getOwnedEducationHistoryById($id);
        $educationHistory->delete();

        return redirect()
            ->route('user.education-history')
            ->with('status', 'Data riwayat pendidikan berhasil dihapus.');
    }

    private function getOwnedEducationHistoryById(int $id): UserEducationHistory
    {
        return UserEducationHistory::where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();
    }

    private function mapEducationHistoryPayload(array $validatedData): array
    {
        return [
            'education' => $validatedData['education'],
            'institution' => $validatedData['institution'],
            'location' => $validatedData['location'],
            'date_of_entry' => $validatedData['dateOfEntry'],
            'date_of_graduation' => $validatedData['dateOfGraduation'] ?? null,
            'date_of_dropped_out' => $validatedData['dateOfDroppedOut'] ?? null,
            'status' => $validatedData['status'],
        ];
    }
}
