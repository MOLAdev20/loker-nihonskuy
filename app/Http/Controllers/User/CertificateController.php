<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserCertificateRequest;
use App\Models\User\UserCertificate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = UserCertificate::query()
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        return view('user.certificate', [
            'certificates' => $certificates,
            'certificateTypes' => UserCertificate::certificateTypes(),
        ]);
    }

    public function show(UserCertificate $certificate)
    {
        abort_unless($certificate->user_id === auth()->id(), 404);

        if (! Storage::disk('public')->exists($certificate->file)) {
            abort(404);
        }

        return response()->file(Storage::disk('public')->path($certificate->file));
    }

    public function store(StoreUserCertificateRequest $request)
    {
        $validated = $request->validated();
        $userId = auth()->id();
        $uploadedFile = $validated['file'];
        $extension = strtolower($uploadedFile->getClientOriginalExtension() ?: $uploadedFile->extension() ?: 'bin');
        $fileName = Str::uuid()->toString() . '.' . $extension;
        $storagePath = $uploadedFile->storeAs("user-certificates/{$userId}", $fileName, 'public');

        try {
            UserCertificate::create([
                'user_id' => $userId,
                'certificate_type' => $validated['certificate_type'],
                'file' => $storagePath,
            ]);
        } catch (Throwable $throwable) {
            Storage::disk('public')->delete($storagePath);

            throw $throwable;
        }

        return redirect()
            ->route('user.certificate')
            ->with('status', 'Sertifikat berhasil diunggah.');
    }

    public function destroy(UserCertificate $certificate)
    {
        abort_unless($certificate->user_id === auth()->id(), 404);

        if ($certificate->file && Storage::disk('public')->exists($certificate->file)) {
            Storage::disk('public')->delete($certificate->file);
        }

        $certificate->delete();

        return redirect()
            ->route('user.certificate')
            ->with('status', 'Sertifikat berhasil dihapus.');
    }
}
