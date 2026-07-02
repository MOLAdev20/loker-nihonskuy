<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CompanyManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_company_index_requires_authentication(): void
    {
        $response = $this->get(route('admin.company.index'));

        $response->assertRedirect('/admin/login');
    }

    public function test_admin_can_create_company_with_logo(): void
    {
        Storage::fake('public');
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin, 'admin')->post(route('admin.company.store'), [
            'name' => 'Sakura Tech',
            'logo' => UploadedFile::fake()->image('sakura.png'),
            'bio' => 'Perusahaan teknologi Jepang untuk kebutuhan industri.',
            'location' => 'Tokyo, Jepang',
            'website' => 'sakura-tech.jp',
            'field' => 'Teknologi',
            'facility' => 'Asrama, Transport',
            'established' => '2012',
        ]);

        $response->assertRedirect(route('admin.company.index'));
        $this->assertDatabaseHas('company', [
            'name' => 'Sakura Tech',
            'location' => 'Tokyo, Jepang',
            'field' => 'Teknologi',
        ]);

        $company = Company::query()->firstOrFail();

        Storage::disk('public')->assertExists($company->logo);
    }

    public function test_admin_can_update_company_and_replace_logo(): void
    {
        Storage::fake('public');
        $admin = $this->createAdmin();
        $oldLogo = UploadedFile::fake()->image('old-logo.png')->store('company-logos', 'public');
        $company = Company::create([
            'name' => 'Nihon Foods',
            'logo' => $oldLogo,
            'bio' => 'Profil awal',
            'location' => 'Osaka, Jepang',
            'website' => 'nihon-foods.jp',
            'field' => 'Pengolahan Makanan',
            'facility' => 'Makan, Asrama',
            'established' => '2010',
        ]);

        $response = $this->actingAs($admin, 'admin')->put(route('admin.company.update', $company), [
            'name' => 'Nihon Foods Updated',
            'logo' => UploadedFile::fake()->image('new-logo.png'),
            'bio' => 'Profil baru',
            'location' => 'Aichi, Jepang',
            'website' => 'nihon-foods.co.jp',
            'field' => 'Makanan',
            'facility' => 'Makan, Asrama, Bonus',
            'established' => '2011',
        ]);

        $response->assertRedirect(route('admin.company.show', $company));

        $company->refresh();

        $this->assertSame('Nihon Foods Updated', $company->name);
        $this->assertSame('Aichi, Jepang', $company->location);
        $this->assertNotSame($oldLogo, $company->logo);

        Storage::disk('public')->assertMissing($oldLogo);
        Storage::disk('public')->assertExists($company->logo);
    }

    public function test_public_company_pages_use_database_content(): void
    {
        $company = Company::create([
            'name' => 'Fuji Care',
            'logo' => 'company-logos/fuji-care.png',
            'bio' => 'Perusahaan layanan care worker di Jepang.',
            'location' => 'Shizuoka, Jepang',
            'website' => 'fujicare.jp',
            'field' => 'Kaigo',
            'facility' => "Asrama\nBonus Tahunan",
            'established' => '2015',
        ]);

        $listResponse = $this->get(route('jp.company'));

        $listResponse->assertOk();
        $listResponse->assertSee('Fuji Care');
        $listResponse->assertSee('Shizuoka, Jepang');

        $detailResponse = $this->get(route('jp.company.detail', $company->public_slug));

        $detailResponse->assertOk();
        $detailResponse->assertSee('Perusahaan layanan care worker di Jepang.');
        $detailResponse->assertSee('Bonus Tahunan');
        $detailResponse->assertSee('fujicare.jp');
    }

    public function test_company_logo_route_serves_uploaded_logo(): void
    {
        Storage::fake('public');
        $storedLogo = UploadedFile::fake()->image('logo.png')->store('company-logos', 'public');
        $company = Company::create([
            'name' => 'Logo Route Corp',
            'logo' => $storedLogo,
            'bio' => 'Bio perusahaan',
            'location' => 'Nagoya, Jepang',
            'website' => 'logo-route.jp',
            'field' => 'Manufaktur',
            'facility' => 'Asrama',
            'established' => '2018',
        ]);

        $response = $this->get(route('company.logo', $company));

        $response->assertOk();
    }

    private function createAdmin(): Admin
    {
        return Admin::create([
            'name' => 'Admin Company',
            'email' => 'admin-company@example.com',
            'password' => 'password',
        ]);
    }
}
