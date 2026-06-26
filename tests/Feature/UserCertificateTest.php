<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\User\UserCertificate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserCertificateTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_certificate_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('user.certificate'))
            ->assertOk()
            ->assertSee('Lampiran Sertifikat');
    }

    public function test_user_can_upload_certificate_and_duplicate_type_is_blocked(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('user.certificate.store'), [
                'formMode' => 'create',
                'certificate_type' => 'n5',
                'file' => UploadedFile::fake()->create('n5.pdf', 100, 'application/pdf'),
            ])
            ->assertRedirect(route('user.certificate'));

        $this->assertDatabaseHas('user_certificate', [
            'user_id' => $user->id,
            'certificate_type' => 'n5',
        ]);

        $certificate = UserCertificate::query()->where('user_id', $user->id)->firstOrFail();

        $this->actingAs($user)
            ->post(route('user.certificate.store'), [
                'formMode' => 'create',
                'certificate_type' => 'n5',
                'file' => UploadedFile::fake()->create('n5-2.pdf', 100, 'application/pdf'),
            ])
            ->assertSessionHasErrors([
                'certificate_type' => 'sertifikat N5 sudah ada. Hapus terlebih dahulu untuk menggantinya',
            ]);

        Storage::disk('public')->assertExists($certificate->file);
    }

    public function test_user_cannot_upload_invalid_certificate_file_type(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('user.certificate.store'), [
                'formMode' => 'create',
                'certificate_type' => 'n4',
                'file' => UploadedFile::fake()->create('certificate.txt', 100, 'text/plain'),
            ])
            ->assertSessionHasErrors(['file' => 'File Sertifikat harus berformat PDF, JPG, JPEG, atau PNG.']);
    }

    public function test_user_can_delete_owned_certificate_and_file_is_removed(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        Storage::disk('public')->put('user-certificates/' . $user->id . '/sample.pdf', 'certificate');

        $certificate = UserCertificate::create([
            'user_id' => $user->id,
            'certificate_type' => 'ssw_pertanian',
            'file' => 'user-certificates/' . $user->id . '/sample.pdf',
        ]);

        $this->actingAs($user)
            ->delete(route('user.certificate.destroy', $certificate->id))
            ->assertRedirect(route('user.certificate'));

        $this->assertDatabaseMissing('user_certificate', [
            'id' => $certificate->id,
        ]);

        Storage::disk('public')->assertMissing('user-certificates/' . $user->id . '/sample.pdf');
    }
}
