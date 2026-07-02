<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\User\UserDocument;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserDocumentTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_document_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('user.document'))
            ->assertOk()
            ->assertSee('Lampiran Dokumen');
    }

    public function test_user_can_upload_document_and_duplicate_type_is_blocked(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('user.document.store'), [
                'formMode' => 'create',
                'file_type' => 'ktp',
                'file' => UploadedFile::fake()->create('ktp.pdf', 100, 'application/pdf'),
            ])
            ->assertRedirect(route('user.document'));

        $this->assertDatabaseHas('user_document', [
            'user_id' => $user->id,
            'file_type' => 'ktp',
        ]);

        $document = UserDocument::query()->where('user_id', $user->id)->firstOrFail();

        $this->actingAs($user)
            ->post(route('user.document.store'), [
                'formMode' => 'create',
                'file_type' => 'ktp',
                'file' => UploadedFile::fake()->create('ktp-2.pdf', 100, 'application/pdf'),
            ])
            ->assertSessionHasErrors([
                'file_type' => 'Dokumen KTP sudah ada. Hapus terlebih dahulu untuk menggantinya',
            ]);

        Storage::disk('public')->assertExists($document->file);
    }

    public function test_user_cannot_upload_non_pdf_document(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('user.document.store'), [
                'formMode' => 'create',
                'file_type' => 'kk',
                'file' => UploadedFile::fake()->image('kk.png'),
            ])
            ->assertSessionHasErrors(['file' => 'File Dokumen harus berformat PDF.']);
    }

    public function test_user_can_delete_owned_document_and_file_is_removed(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        Storage::disk('public')->put('user-documents/' . $user->id . '/sample.pdf', 'document');

        $document = UserDocument::create([
            'user_id' => $user->id,
            'file_type' => 'kk',
            'file' => 'user-documents/' . $user->id . '/sample.pdf',
        ]);

        $this->actingAs($user)
            ->delete(route('user.document.destroy', $document->id))
            ->assertRedirect(route('user.document'));

        $this->assertDatabaseMissing('user_document', [
            'id' => $document->id,
        ]);

        Storage::disk('public')->assertMissing('user-documents/' . $user->id . '/sample.pdf');
    }
}
