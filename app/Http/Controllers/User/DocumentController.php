<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserDocumentRequest;
use App\Models\User\UserDocument;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = UserDocument::query()
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        return view('user.document', [
            'documents' => $documents,
            'documentTypes' => UserDocument::fileTypes(),
        ]);
    }

    public function show(UserDocument $document)
    {
        abort_unless($document->user_id === auth()->id(), 404);

        if (! Storage::disk('public')->exists($document->file)) {
            abort(404);
        }

        return response()->file(Storage::disk('public')->path($document->file));
    }

    public function store(StoreUserDocumentRequest $request)
    {
        $validated = $request->validated();
        $userId = auth()->id();
        $uploadedFile = $validated['file'];
        $extension = strtolower($uploadedFile->getClientOriginalExtension() ?: $uploadedFile->extension() ?: 'bin');
        $fileName = Str::uuid()->toString() . '.' . $extension;
        $storagePath = $uploadedFile->storeAs("user-documents/{$userId}", $fileName, 'public');

        try {
            UserDocument::create([
                'user_id' => $userId,
                'file_type' => $validated['file_type'],
                'file' => $storagePath,
            ]);
        } catch (Throwable $throwable) {
            Storage::disk('public')->delete($storagePath);

            throw $throwable;
        }

        return redirect()
            ->route('user.document')
            ->with('status', 'Dokumen berhasil diunggah.');
    }

    public function destroy(UserDocument $document)
    {
        abort_unless($document->user_id === auth()->id(), 404);

        if ($document->file && Storage::disk('public')->exists($document->file)) {
            Storage::disk('public')->delete($document->file);
        }

        $document->delete();

        return redirect()
            ->route('user.document')
            ->with('status', 'Dokumen berhasil dihapus.');
    }
}
