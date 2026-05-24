@extends('layouts.admin')

@push('title')
  <title>NihonSkuy - Informasi Pribadi User</title>
@endpush

@section('content')
  @php
    $profile = $user->userProfile;
    $educationHistories = $user->educationHistories;
    $workExperiences = $user->workExperiences;
    $displayName = $profile?->full_name ?? $user->name;
    $furiganaName = $profile?->furigana_name ?? $user->furigana_name;
    $bioText = $profile?->technical_experience;
    $emptyValue = '—';
    $profilePictureUrl = null;
    $isProfileCompleted = filled($profile);

    $profilePicturePath = $profile?->profile_picture ? ltrim($profile->profile_picture, '/') : null;

    if ($profilePicturePath) {
      if (filter_var($profilePicturePath, FILTER_VALIDATE_URL)) {
        $profilePictureUrl = $profilePicturePath;
      } elseif (file_exists(public_path($profilePicturePath))) {
        $profilePictureUrl = asset($profilePicturePath);
      } elseif (file_exists(storage_path('app/public/' . $profilePicturePath))) {
        $profilePictureUrl = asset('storage/' . $profilePicturePath);
      }
    }

    $initials = collect(preg_split('/\s+/', trim($displayName)))
      ->filter()
      ->take(2)
      ->map(fn($part) => strtoupper(substr($part, 0, 1)))
      ->implode('');
    $initials = $initials !== '' ? $initials : 'U';

    $formatValue = function ($value, $suffix = '') use ($emptyValue) {
      return filled($value) ? trim((string) $value) . $suffix : $emptyValue;
    };

    $formatDate = function ($dateValue) use ($emptyValue) {
      return $dateValue ? $dateValue->format('d M Y') : $emptyValue;
    };
    $formatJapaneseDate = function ($dateValue) {
      return $dateValue ? $dateValue->format('Y年n月j日') : null;
    };
    $genderIdLabels = ['male' => 'Laki-laki', 'female' => 'Perempuan'];
    $genderJpLabels = ['male' => '男', 'female' => '女'];
    $maritalIdLabels = ['single' => 'Belum Menikah', 'married' => 'Menikah', 'divorce' => 'Cerai'];
    $maritalJpLabels = ['single' => 'なし', 'married' => 'あり', 'divorce' => 'なし'];
    $religionIdLabels = ['islam' => 'Islam', 'kristen' => 'Kristen', 'katolik' => 'Katolik', 'hindu' => 'Hindu', 'buddha' => 'Buddha'];
    $nationalityJpLabels = ['jepang' => '日本', 'japan' => '日本', 'indonesia' => 'インドネシア'];
    $hijabOptions = \App\Models\User\UserProfile::hijabOptions();
    $prayerOptions = \App\Models\User\UserProfile::prayOptions();
    $porkToleranceOptions = \App\Models\User\UserProfile::porkToleranceOptions();
    $alcoholToleranceOptions = \App\Models\User\UserProfile::alcoholToleranceOptions();
    $driverLicenseOptions = \App\Models\User\UserProfile::driverLicenseOptions();
    $japaneseCertificateOptions = \App\Models\User\UserProfile::japaneseCertificateOptions();
    $nationalityKey = strtolower(trim((string) ($profile?->nationality ?? '')));

    $detailFields = [
      ['label' => 'Tanggal Lahir / 生年月日', 'value' => ['id' => $formatDate($profile?->birth_date), 'jp' => $formatJapaneseDate($profile?->birth_date)]],
      ['label' => 'Jenis Kelamin / 性別', 'value' => ['id' => $genderIdLabels[$profile?->gender] ?? $emptyValue, 'jp' => $genderJpLabels[$profile?->gender] ?? null]],
      ['label' => 'Umur / Umur', 'value' => ['id' => $profile?->age ?? $emptyValue]],
      ['label' => 'Daerah Asal / 出身地', 'value' => ['id' => $formatValue($profile?->place_of_origin)]],
      ['label' => 'Kewarganegaraan / 国籍', 'value' => ['id' => $formatValue($profile?->nationality), 'jp' => $nationalityJpLabels[$nationalityKey] ?? null]],
      ['label' => 'Alamat Saat Ini / 現住所', 'value' => ['id' => $formatValue($profile?->current_address)]],
      ['label' => 'Agama / 宗教', 'value' => ['id' => $religionIdLabels[$profile?->religion] ?? $emptyValue]],
      ['label' => 'Status Pernikahan / 婚姻状況', 'value' => ['id' => $maritalIdLabels[$profile?->marital_status] ?? $emptyValue, 'jp' => $maritalJpLabels[$profile?->marital_status] ?? null]],
      ['label' => 'Tinggi Badan / 身長', 'value' => ['id' => filled($profile?->height) ? $profile->height . ' cm' : $emptyValue]],
      ['label' => 'Berat Badan / 体重', 'value' => ['id' => filled($profile?->weight) ? $profile->weight . ' kg' : $emptyValue]],
      ['label' => 'Jenis Visa Saat Ini / 現在の在留資格', 'value' => ['id' => $formatValue($profile?->current_visa_type)]],
      ['label' => 'Masa Berlaku Visa / 在留期限', 'value' => ['id' => $formatDate($profile?->visa_expiry_date), 'jp' => $formatJapaneseDate($profile?->visa_expiry_date)]],
      ['label' => 'Level JLPT / JLPTレベル', 'value' => ['id' => $japaneseCertificateOptions[$profile?->jlpt_level]['id'] ?? $formatValue($profile?->jlpt_level), 'jp' => $japaneseCertificateOptions[$profile?->jlpt_level]['jp'] ?? null]],
      ['label' => 'Tanggal Masuk / 入国日', 'value' => ['id' => $formatDate($profile?->entry_date), 'jp' => $formatJapaneseDate($profile?->entry_date)]],
      ['label' => 'Mulai Kerja / 就業開始日', 'value' => ['id' => $formatDate($profile?->work_start_date), 'jp' => $formatJapaneseDate($profile?->work_start_date)]],
      ['label' => 'Memiliki SIM / 運転免許', 'value' => ['id' => $driverLicenseOptions[$profile?->has_driver_license]['id'] ?? $formatValue($profile?->has_driver_license), 'jp' => $driverLicenseOptions[$profile?->has_driver_license]['jp'] ?? null]],
    ];

    $detailLongFields = [
      ['label' => 'Kebutuhan Hijab di Tempat Kerja / ヒジャブ', 'value' => ['id' => $hijabOptions[$profile?->is_wearing_hijab]['id'] ?? $emptyValue, 'jp' => $hijabOptions[$profile?->is_wearing_hijab]['jp'] ?? null], 'span' => 'md:col-span-2'],
      ['label' => 'Kebutuhan Ibadah di Tempat Kerja / 礼拝の必要', 'value' => ['id' => $prayerOptions[$profile?->prayer_requirement]['id'] ?? $formatValue($profile?->prayer_requirement), 'jp' => $prayerOptions[$profile?->prayer_requirement]['jp'] ?? null], 'span' => 'md:col-span-2'],
      ['label' => 'Toleransi Daging Babi / 豚肉の許容', 'value' => ['id' => $porkToleranceOptions[$profile?->pork_tolerance]['id'] ?? $formatValue($profile?->pork_tolerance), 'jp' => $porkToleranceOptions[$profile?->pork_tolerance]['jp'] ?? null], 'span' => 'md:col-span-2'],
      ['label' => 'Toleransi Minuman/Makanan Beralkohol / アルコールの許容', 'value' => ['id' => $alcoholToleranceOptions[$profile?->alcohol_tolerance]['id'] ?? $formatValue($profile?->alcohol_tolerance), 'jp' => $alcoholToleranceOptions[$profile?->alcohol_tolerance]['jp'] ?? null], 'span' => 'md:col-span-2'],
      ['label' => 'Pengalaman Teknis / 技術経験', 'value' => ['id' => $formatValue($profile?->technical_experience)], 'span' => 'md:col-span-2'],
    ];
  @endphp

  <div class="mb-5">
    <nav class="mb-4 text-sm" aria-label="Breadcrumb">
      <ol class="flex items-center gap-2 text-slate-500">
        <li>
          <a href="#" class="hover:text-slate-700">
            Dashboard
          </a>
        </li>

        <li class="flex items-center gap-2">
          <span class="text-slate-400">/</span>
          <a href="{{ route('admin.users') }}" class="hover:text-slate-700">
            Users
          </a>
        </li>

        <li class="flex items-center gap-2">
          <span class="text-slate-400">/</span>
          <span class="font-medium text-slate-700">
            Detail User
          </span>
        </li>
      </ol>
    </nav>

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
          Detail User
        </h1>
        <p class="mt-2 text-sm text-slate-500">
          Ringkasan data akun, profil, pendidikan, dan pengalaman kerja.
        </p>
      </div>

      <a href="{{ route('admin.users') }}"
        class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
        Kembali ke daftar user
      </a>
    </div>
  </div>

  @if (session('status'))
    <div
      class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
      {{ session('status') }}
    </div>
  @endif

  @if (session('error'))
    <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
      {{ session('error') }}
    </div>
  @endif

  <div class="grid grid-cols-1 gap-5 lg:grid-cols-6">
    <section class="rounded-2xl border border-slate-200 bg-white p-6 lg:col-span-2">

      <div class="flex flex-col items-center text-center">
        <div class="group relative">
          <div
            class="flex items-center justify-center p-2 border rounded-lg border-slate-400 text-3xl font-semibold text-white">
            @if ($profilePictureUrl)
              <img src="{{ $profilePictureUrl }}" alt="Profile picture {{ $displayName }}"
                class="h-full w-full object-cover">
            @else
              <span>{{ $initials }}</span>
            @endif
          </div>

          <form method="POST" action="{{ route('admin.users.profile.upload-photo', $user->id) }}"
            enctype="multipart/form-data">
            @csrf
            <input id="profilePicture" name="profilePicture" type="file" accept=".jpg,.jpeg,.png,.webp,image/*"
              class="sr-only" onchange="this.form.submit()">
            <label for="profilePicture"
              class="absolute bottom-5 right-5 inline-flex px-5 py-2 gap-2 cursor-pointer items-center justify-center rounded-full border border-white/70 bg-slate-900/90 text-white opacity-0 shadow-md transition group-hover:opacity-100 group-focus-within:opacity-100 hover:bg-slate-800"
              title="Upload foto profile">
              <x-icons.folderInput size="20" />
              <span>Upload Foto</span>
            </label>
          </form>
        </div>

        <div class="mt-5 border rounded-lg border-slate-400 p-2">
          <iframe width="450" height="300" src="https://www.youtube.com/embed/qAxpv3cCHO8?si=GHY9J-iAw4gXU_yN" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
      </div>

      <div class="mt-4">
        @error('profilePicture')
          <p class="text-center text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>
    </section>

    <div class="space-y-5 lg:col-span-4">
      <section class="rounded-2xl border border-slate-200 bg-white p-6">
        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
          <div>
            <h2 class="text-xl font-semibold uppercase tracking-wider text-slate-800">
              {{ $displayName }}
            </h2>
            <h2 class="text-sm font-semibold uppercase tracking-wider text-slate-400">
              {{ $furiganaName }}
            </h2>
          </div>
          <div class="flex items-center gap-2">
            <a href="{{ route('admin.users.profile.form', $user->id) }}"
              class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
              <x-icons.pencil size="14" />
              Ubah Data
            </a>
            <a href="{{ route('admin.users.resume.print', $user->id) }}"
              class="inline-flex items-center gap-2 rounded-lg border border-slate-900 bg-slate-900 px-3 py-2 text-xs font-semibold text-white hover:bg-slate-800">
              <x-icons.fileText size="14" />
              Print CV
            </a>
          </div>
        </div>

        <div class="overflow-hidden mt-10 rounded-2xl border border-slate-200 bg-slate-200">
          <div class="grid grid-cols-1 gap-px bg-slate-200 md:grid-cols-2">
            @foreach ($detailFields as $field)
              <div class="min-h-22 bg-white px-5 py-4">
                <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500">
                  {{ $field['label'] }}
                </p>
                <div class="flex gap-3 items-center mt-2">
                  <p class="text-sm font-medium text-slate-900">
                    {{ $field['value']['id'] }}
                  </p>
                  @if (!empty($field['value']['jp']))
                    <p class="text-sm font-semibold italic text-slate-500">({{ $field['value']['jp'] }})</p>
                  @endif
                </div>
              </div>
            @endforeach
          </div>
          <div class="mt-5 grid grid-cols-1 gap-px bg-slate-200 md:grid-cols-2">
            @foreach ($detailLongFields as $field)
              <div class="{{ $field['span'] }} min-h-28 bg-white px-5 py-4">
                <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500">
                  {{ $field['label'] }}
                </p>
                <p class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-700">{{ $field['value']['id'] }}</p>
                @if (!empty($field['value']['jp']))
                  <p class="mt-1 whitespace-pre-line text-sm font-semibold italic text-slate-500">{{ $field['value']['jp'] }}</p>
                @endif
              </div>
            @endforeach
          </div>
        </div>
      </section>

      <section class="rounded-2xl border border-slate-200 bg-white p-5">
        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
          <h2 class="text-sm font-semibold uppercase tracking-wider text-slate-500">
            Riwayat Pendidikan / 学歴
          </h2>
          <a href="{{ route('admin.users.education.index', $user->id) }}"
            class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
            <x-icons.pencil size="14" />
            Ubah Data
          </a>
        </div>

        @if ($educationHistories->isNotEmpty())
          <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
              <thead class="bg-slate-50">
                <tr>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Institusi / 学校名</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Jenjang / 学歴</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Lokasi / 所在地</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Masuk / 入学日</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Lulus / 卒業日</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Keluar / 中退日</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status / 状況</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-200 bg-white text-slate-700">
                @foreach ($educationHistories as $educationHistory)
                  <tr>
                    <td class="whitespace-nowrap px-4 py-3">{{ $educationHistory->institution }}</td>
                    <td class="whitespace-nowrap px-4 py-3">{{ $educationHistory->education }}</td>
                    <td class="whitespace-nowrap px-4 py-3">{{ $educationHistory->location }}</td>
                    <td class="whitespace-nowrap px-4 py-3">{{ $formatDate($educationHistory->date_of_entry) }}</td>
                    <td class="whitespace-nowrap px-4 py-3">{{ $formatDate($educationHistory->date_of_graduation) }}</td>
                    <td class="whitespace-nowrap px-4 py-3">{{ $formatDate($educationHistory->date_of_dropped_out) }}</td>
                    <td class="whitespace-nowrap px-4 py-3">{{ $educationHistory->status }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 px-4 py-8 text-center text-sm text-slate-500">
            No data provided.
          </div>
        @endif
      </section>

      <section class="rounded-2xl border border-slate-200 bg-white p-5">
        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
          <h2 class="text-sm font-semibold uppercase tracking-wider text-slate-500">
            Pengalaman Kerja / 職歴
          </h2>
          <a href="{{ route('admin.users.working-experience.index', $user->id) }}"
            class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
            <x-icons.pencil size="14" />
            Ubah Data
          </a>
        </div>

        @if ($workExperiences->isNotEmpty())
          <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
              <thead class="bg-slate-50">
                <tr>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Bidang Kerja / 職種</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Nama Perusahaan / 会社名</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Lokasi / 所在地</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Tanggal Masuk / 入社日</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Tanggal Keluar / 退職日</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status Kerja / 雇用形態</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Jenis Visa / 在留資格</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-200 bg-white text-slate-700">
                @foreach ($workExperiences as $workExperience)
                  <tr>
                    <td class="whitespace-nowrap px-4 py-3">{{ $workExperience->field_of_work }}</td>
                    <td class="whitespace-nowrap px-4 py-3">{{ $workExperience->company_name }}</td>
                    <td class="whitespace-nowrap px-4 py-3">{{ $workExperience->location }}</td>
                    <td class="whitespace-nowrap px-4 py-3">{{ $formatDate($workExperience->date_of_join) }}</td>
                    <td class="whitespace-nowrap px-4 py-3">{{ $formatDate($workExperience->date_of_resign) }}</td>
                    <td class="whitespace-nowrap px-4 py-3">{{ $workExperience->employment_status }}</td>
                    <td class="whitespace-nowrap px-4 py-3">{{ $workExperience->visa_type ?: $emptyValue }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 px-4 py-8 text-center text-sm text-slate-500">
            No data provided.
          </div>
        @endif
      </section>
    </div>
  </div>
@endsection
