@extends('layouts.user-dashboard')

@section('title', 'NihonSkuy - Profil Pribadi')

@section('content_header', 'Profil Pribadi')

@section('content_subheader', 'Ringkasan profil.')

@section('content')
  @if (session('status'))
    <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
      {{ session('status') }}
    </div>
  @endif

  @if (session('error'))
    <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
      {{ session('error') }}
    </div>
  @endif

  @if (!$profile)
    <div class="grid grid-cols-1">
      <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <h2 class="text-xl font-semibold tracking-tight text-slate-900">Isi Data profile anda</h2>
        <p class="mt-2 text-sm text-slate-600">
          Data profil membantu kami membuat CV dan memproses anda ke pihak perusahaan Jepang
        </p>
        <div class="mt-6">
          <a href="{{ route('user.profile.form') }}"
            class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800">
            Isi Data Profil
          </a>
        </div>
      </div>
    </div>
  @else
    @php
      $genderLabels = [
          'male' => 'Laki-laki',
          'female' => 'Perempuan',
      ];
      $genderJapaneseLabels = [
          'male' => '男',
          'female' => '女',
      ];
      $maritalStatusLabels = [
          'single' => 'Belum Menikah',
          'married' => 'Menikah',
          'divorce' => 'Cerai',
      ];
      $maritalStatusJapaneseLabels = [
          'single' => 'なし',
          'married' => 'あり',
          'divorce' => 'なし',
      ];
      $religionLabels = [
          'islam' => 'Islam',
          'kristen' => 'Kristen',
          'katolik' => 'Katolik',
          'hindu' => 'Hindu',
          'buddha' => 'Buddha',
      ];
      $nationalityJapaneseLabels = [
          'jepang' => '日本',
          'japan' => '日本',
          'indonesia' => 'インドネシア',
      ];
      $hijabOptions = \App\Models\User\UserProfile::hijabOptions();
      $prayerOptions = \App\Models\User\UserProfile::prayOptions();
      $porkToleranceOptions = \App\Models\User\UserProfile::porkToleranceOptions();
      $alcoholToleranceOptions = \App\Models\User\UserProfile::alcoholToleranceOptions();
      $driverLicenseOptions = \App\Models\User\UserProfile::driverLicenseOptions();
      $japaneseCertificateOptions = \App\Models\User\UserProfile::japaneseCertificateOptions();

      $profilePicturePath = $profile->profile_picture ? ltrim($profile->profile_picture, '/') : null;
      $profilePictureUrl = null;
      if ($profilePicturePath) {
          if (filter_var($profilePicturePath, FILTER_VALIDATE_URL)) {
              $profilePictureUrl = $profilePicturePath;
          } elseif (file_exists(public_path($profilePicturePath))) {
              $profilePictureUrl = asset($profilePicturePath);
          } elseif (file_exists(storage_path('app/public/' . $profilePicturePath))) {
              $profilePictureUrl = asset('storage/' . $profilePicturePath);
          }
      }

      $nationalityKey = strtolower(trim((string) $profile->nationality));
      $jlptValue = $profile->jlpt_level;
      $legacyJlptDisplayMap = [
          'none' => 'Tidak memiliki sertifikat',
          'other' => 'Lainnya',
      ];
      $jlptDisplay = $japaneseCertificateOptions[$jlptValue]['id'] ?? ($legacyJlptDisplayMap[$jlptValue] ?? ($jlptValue ?: '-'));
      $jlptJapanese = $japaneseCertificateOptions[$jlptValue]['jp'] ?? (($jlptValue === 'none') ? '資格なし' : (($jlptValue === 'other') ? 'その他' : ($jlptValue ?: null)));

      $personalInfoRows = [
          'Tanggal Lahir' => [
              'id' => $profile->birth_date?->format('d M Y') ?: '-',
              'jp' => $profile->birth_date?->format('Y年n月j日'),
          ],
          'Jenis Kelamin' => [
              'id' => $genderLabels[$profile->gender],
              'jp' => $genderJapaneseLabels[$profile->gender] ?? '-',
          ],
          'Umur' => [
              'id' => $profile->age,
          ],
          'Daerah Asal' => [
              'id' => $profile->place_of_origin,
          ],
          'Kewarganegaraan' => [
              'id' => $profile->nationality ?: '-',
              'jp' => $nationalityJapaneseLabels[$nationalityKey] ?? null,
          ],
          'Alamat Saat Ini' => [
              'id' => $profile->current_address,
          ],
          'Agama' => ['id' => $religionLabels[$profile->religion] ?? '-'],
          'Status Pernikahan' => [
              'id' => $profile->marital_status,
          ],
          'Tinggi Badan' => ['id' => ($profile->height ?: '-') . 'cm'],
          'Berat Badan' => ['id' => ($profile->weight ?: '-') . 'kg'],
          'Jenis Visa Saat Ini' => ['id' => $profile->current_visa_type ?: '-'],
          'Masa Berlaku Visa' => [
              'id' => $profile->visa_expiry_date?->format('d M Y') ?: '-',
              'jp' => $profile->visa_expiry_date?->format('Y年n月j日'),
          ],
          'Level JLPT' => [
              'id' => $jlptDisplay,
              'jp' => $jlptJapanese,
          ],
          
          'Tanggal Masuk Jepang' => [
              'id' => $profile->entry_date?->format('d M Y') ?: '-',
              'jp' => $profile->entry_date?->format('Y年n月j日'),
          ],
          'Tanggal Mulai Kerja' => [
              'id' => $profile->work_start_date?->format('d M Y') ?: '-',
              'jp' => $profile->work_start_date?->format('Y年n月j日'),
          ],
          'Memiliki SIM' => [
              'id' => $driverLicenseOptions[$profile->has_driver_license]['id'] ?? ($profile->has_driver_license ?: '-'),
              'jp' => $driverLicenseOptions[$profile->has_driver_license]['jp'] ?? null,
          ],          
      ];

      $workPreferenceRows = [
          'Kebutuhan Jilbab di Tempat Kerja?' => [
              'id' => $hijabOptions[$profile->is_wearing_hijab]['id'] ?? '-',
              'jp' => $hijabOptions[$profile->is_wearing_hijab]['jp'] ?? null,
          ],
          'Kebutuhan Ibadah di Tempat Kerja' => [
              'id' => $prayerOptions[$profile->prayer_requirement]['id'] ?? '-',
              'jp' => $prayerOptions[$profile->prayer_requirement]['jp'] ?? null,
          ],
          'Toleransi terhadap daging babi' => [
              'id' => $porkToleranceOptions[$profile->pork_tolerance]['id'] ?? '-',
              'jp' => $porkToleranceOptions[$profile->pork_tolerance]['jp'] ?? null,
          ],
          'Toleransi terhadap Alkohol' => [
              'id' => $alcoholToleranceOptions[$profile->alcohol_tolerance]['id'] ?? '-',
              'jp' => $alcoholToleranceOptions[$profile->alcohol_tolerance]['jp'] ?? null,
          ],
          'Pengalaman Teknis' => ['id' => $profile->technical_experience ?: '-'],
      ];
    @endphp

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-6">
      <div class="lg:col-span-2">
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
          <form method="POST" action="{{ route('user.profile.upload-photo') }}" enctype="multipart/form-data"
            class="mt-4 space-y-3">
            @csrf
            <div class="group relative">
              @if ($profilePictureUrl)
                <img src="{{ $profilePictureUrl }}" alt="Foto profile {{ $profile->full_name }}"
                  class="aspect-3/4 w-full rounded-xl border border-slate-200 object-cover" />
              @else
                <div
                  class="flex aspect-3/4 w-full items-center justify-center rounded-xl border border-dashed border-slate-300 bg-slate-50 text-4xl font-semibold text-slate-400">
                  {{ strtoupper(substr($profile->full_name ?: auth()->user()->name, 0, 1)) }}
                </div>
              @endif

              <input id="profilePicture" name="profilePicture" type="file" accept=".jpg,.jpeg,.png,.webp,image/*"
                class="sr-only" onchange="this.form.submit()" />
              <label for="profilePicture"
                class="absolute bottom-2 right-2 inline-flex gap-2 px-5 py-3 cursor-pointer items-center justify-center rounded-full border border-white/70 bg-slate-900/90 text-white shadow-md transition hover:bg-slate-800 sm:group-focus-within:opacity-100"
                title="Ganti foto profile">
                <x-icons.folderInput size="20" />
                <span>Upload Foto</span>
              </label>

              @error('profilePicture')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
              @enderror
            </div>
          </form>
        </div>
      </div>

      <div class="space-y-4 lg:col-span-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
          <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
              <h2 class="text-xl font-semibold text-slate-900">{{ $profile->full_name }}</h2>
              <h2 class="text-sm text-slate-500">{{ $profile->furigana_name }}</h2>
            </div>
            <a href="{{ route('user.resume.print') }}"
              class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-800">
              Download CV
            </a>
          </div>
          <div class="mt-4 grid grid-cols-1 lg:grid-cols-2">
            @foreach ($personalInfoRows as $label => $value)
              <div class="py-3 border border-slate-200 p-3">
                <div class="text-xs font-medium uppercase tracking-wide text-slate-500">{{ $label }}</div>
                <div class="text-sm font-semibold text-slate-900 flex gap-2 mt-2">
                  {{ $value['id'] }}
                  @if (!empty($value['jp']))
                    <div class="whitespace-pre-line text-sm text-slate-500">{{ $value['jp'] }}</div>
                  @endif
                </div>
              </div>
            @endforeach
          </div>

          <div class="mt-2 border border-slate-200 p-4">
            <div>
              @foreach ($workPreferenceRows as $label => $value)
                <div class="py-3">
                  <div class="text-xs font-medium uppercase tracking-wide text-slate-500">{{ $label }}</div>
                  <div class="mt-1 text-sm font-semibold text-slate-900">{{ $value['id'] }}</div>
                  @if (!empty($value['jp']))
                    <div class="mt-0.5 whitespace-pre-line text-sm font-semibold italic text-slate-500">{{ $value['jp'] }}</div>
                  @endif
                </div>
              @endforeach
            </div>
          </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
          <h2 class="text-base font-semibold text-slate-900">Riwayat Pendidikan</h2>
          <div class="mt-4 overflow-x-auto rounded-xl border border-slate-200">
            @forelse ($educationHistories as $educationHistory)
              @if ($loop->first)
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                  <thead class="bg-slate-50">
                    <tr>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Institusi</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Pendidikan</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Lokasi</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Periode</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-slate-200 bg-white">
              @endif
              <tr>
                <td class="px-4 py-3 text-slate-900">{{ $educationHistory->institution ?: '-' }}</td>
                <td class="px-4 py-3 text-slate-900">{{ $educationHistory->education ?: '-' }}</td>
                <td class="px-4 py-3 text-slate-700">{{ $educationHistory->location ?: '-' }}</td>
                <td class="px-4 py-3 text-slate-700">
                  {{ $educationHistory->date_of_entry?->format('d M Y') ?: '-' }} -
                  {{ $educationHistory->date_of_graduation?->format('d M Y') ?: ($educationHistory->date_of_dropped_out?->format('d M Y') ?: '-') }}
                </td>
                <td class="px-4 py-3 text-slate-700">{{ $educationHistory->status ?: '-' }}</td>
              </tr>
              @if ($loop->last)
                </tbody>
                </table>
              @endif
            @empty
              <div class="border border-dashed border-slate-300 bg-slate-50 p-4 text-sm text-slate-500">
                Belum ada riwayat pendidikan yang diisi.
              </div>
            @endforelse
          </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
          <h2 class="text-base font-semibold text-slate-900">Riwayat Pengalaman Kerja</h2>
          <div class="mt-4 overflow-x-auto rounded-xl border border-slate-200">
            @forelse ($workExperiences as $workExperience)
              @if ($loop->first)
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                  <thead class="bg-slate-50">
                    <tr>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Bidang Kerja</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Perusahaan</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Lokasi</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Periode</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-slate-200 bg-white">
              @endif
              <tr>
                <td class="px-4 py-3 text-slate-900">{{ $workExperience->field_of_work ?: '-' }}</td>
                <td class="px-4 py-3 text-slate-900">{{ $workExperience->company_name ?: '-' }}</td>
                <td class="px-4 py-3 text-slate-700">{{ $workExperience->location ?: '-' }}</td>
                <td class="px-4 py-3 text-slate-700">
                  {{ $workExperience->date_of_join?->format('d M Y') ?: '-' }} -
                  {{ $workExperience->date_of_resign?->format('d M Y') ?: 'Sekarang' }}
                </td>
                <td class="px-4 py-3 text-slate-700">
                  {{ $workExperience->employment_status ?: '-' }}{{ $workExperience->visa_type ? ' • ' . $workExperience->visa_type : '' }}
                </td>
              </tr>
              @if ($loop->last)
                </tbody>
                </table>
              @endif
            @empty
              <div class="border border-dashed border-slate-300 bg-slate-50 p-4 text-sm text-slate-500">
                Belum ada riwayat pengalaman kerja yang diisi.
              </div>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  @endif
@endsection
