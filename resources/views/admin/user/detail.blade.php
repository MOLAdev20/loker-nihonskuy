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
    $emptyValue = '—';
    $profilePictureUrl = null;
    $isProfileCompleted = filled($profile);
    $jikoshoukaiThumbnailUrl = $profile?->jikoshoukai_thumbnail_url;

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

    $localizedText = function ($id, $jp = null) use ($emptyValue) {
      $idText = filled($id) ? (string) $id : $emptyValue;
      $jpText = filled($jp) ? (string) $jp : $idText;

      return new \Illuminate\Support\HtmlString(
        '<span data-lang="id">' . e($idText) . '</span>' .
        '<span data-lang="jp" class="hidden">' . e($jpText) . '</span>'
      );
    };
    $formatLocalizedDate = function ($dateValue) use ($emptyValue) {
      return [
        'id' => $dateValue ? $dateValue->format('d M Y') : $emptyValue,
        'jp' => $dateValue ? $dateValue->format('Y年n月j日') : null,
      ];
    };
    $genderIdLabels = ['male' => 'Laki-laki', 'female' => 'Perempuan'];
    $genderJpLabels = ['male' => '男', 'female' => '女'];
    $maritalIdLabels = ['single' => 'Belum Menikah', 'married' => 'Menikah', 'divorce' => 'Cerai'];
    $maritalJpLabels = ['single' => 'なし', 'married' => 'あり', 'divorce' => 'なし'];
    $nationalityJpLabels = ['jepang' => '日本', 'japan' => '日本', 'indonesia' => 'インドネシア'];
    $religionOptions = \App\Models\User\UserProfile::religionOptions();
    $hijabOptions = \App\Models\User\UserProfile::hijabOptions();
    $prayerOptions = \App\Models\User\UserProfile::prayOptions();
    $porkToleranceOptions = \App\Models\User\UserProfile::porkToleranceOptions();
    $alcoholToleranceOptions = \App\Models\User\UserProfile::alcoholToleranceOptions();
    $driverLicenseOptions = \App\Models\User\UserProfile::driverLicenseOptions();
    $japaneseCertificateOptions = \App\Models\User\UserProfile::japaneseCertificateOptions();
    $educationLevelOptions = \App\Models\User\UserEducationHistory::educationLevelOptions();
    $educationLocationOptions = \App\Models\User\UserEducationHistory::eduLocationOptions();
    $educationStatusOptions = \App\Models\User\UserEducationHistory::eduStatusOptions();
    $workingLocationOptions = \App\Models\User\WorkExperience::workingLocationOptions();
    $workingStatusOptions = \App\Models\User\WorkExperience::workingStatusOptions();
    $resolveEducationOption = function (?string $value, array $options) use ($emptyValue) {
      if (! filled($value) || ! isset($options[$value])) {
        return ['id' => $value ?: $emptyValue, 'jp' => null];
      }

      return ['id' => $options[$value]['id'], 'jp' => $options[$value]['jp']];
    };
    $resolveWorkOption = function (?string $value, array $options) use ($emptyValue) {
      if (! filled($value) || ! isset($options[$value])) {
        return ['id' => $value ?: $emptyValue, 'jp' => null];
      }

      return ['id' => $options[$value]['id'], 'jp' => $options[$value]['jp']];
    };
    $nationalityKey = strtolower(trim((string) ($profile?->nationality ?? '')));

    $detailFields = [
      ['label' => ['id' => 'Tanggal Lahir', 'jp' => '生年月日'], 'value' => $formatLocalizedDate($profile?->birth_date)],
      ['label' => ['id' => 'Jenis Kelamin', 'jp' => '性別'], 'value' => ['id' => $genderIdLabels[$profile?->gender] ?? $emptyValue, 'jp' => $genderJpLabels[$profile?->gender] ?? null]],
      ['label' => ['id' => 'Umur', 'jp' => '年齢'], 'value' => ['id' => $profile?->age ?? $emptyValue]],
      ['label' => ['id' => 'Daerah Asal', 'jp' => '出身地'], 'value' => ['id' => $formatValue($profile?->place_of_origin)]],
      ['label' => ['id' => 'Kewarganegaraan', 'jp' => '国籍'], 'value' => ['id' => $formatValue($profile?->nationality), 'jp' => $nationalityJpLabels[$nationalityKey] ?? null]],
      ['label' => ['id' => 'Status Pernikahan', 'jp' => '婚姻状況'], 'value' => ['id' => $maritalIdLabels[$profile?->marital_status] ?? $emptyValue, 'jp' => $maritalJpLabels[$profile?->marital_status] ?? null]],
      ['label' => ['id' => 'Tinggi Badan', 'jp' => '身長'], 'value' => ['id' => filled($profile?->height) ? $profile->height . ' cm' : $emptyValue]],
      ['label' => ['id' => 'Berat Badan', 'jp' => '体重'], 'value' => ['id' => filled($profile?->weight) ? $profile->weight . ' kg' : $emptyValue]],
      ['label' => ['id' => 'Jenis Visa Saat Ini', 'jp' => '現在の在留資格'], 'value' => ['id' => $formatValue($profile?->current_visa_type)]],
      ['label' => ['id' => 'Masa Berlaku Visa', 'jp' => '在留期限'], 'value' => $formatLocalizedDate($profile?->visa_expiry_date)],
      ['label' => ['id' => 'Level JLPT', 'jp' => 'JLPTレベル'], 'value' => ['id' => $japaneseCertificateOptions[$profile?->jlpt_level]['id'] ?? $formatValue($profile?->jlpt_level), 'jp' => $japaneseCertificateOptions[$profile?->jlpt_level]['jp'] ?? null]],
      ['label' => ['id' => 'Tanggal Masuk', 'jp' => '入国日'], 'value' => $formatLocalizedDate($profile?->entry_date)],
      ['label' => ['id' => 'Mulai Kerja', 'jp' => '就業開始日'], 'value' => $formatLocalizedDate($profile?->work_start_date)],
      ['label' => ['id' => 'Memiliki SIM', 'jp' => '運転免許'], 'value' => ['id' => $driverLicenseOptions[$profile?->has_driver_license]['id'] ?? $formatValue($profile?->has_driver_license), 'jp' => $driverLicenseOptions[$profile?->has_driver_license]['jp'] ?? null]],
    ];

    $detailLongFields = [
      ['label' => ['id' => 'Alamat Saat Ini', 'jp' => '現住所'], 'value' => ['id' => $formatValue($profile?->current_address)], 'span' => 'md:col-span-2'],
      ['label' => ['id' => 'Agama', 'jp' => '宗教'], 'value' => ['id' => $religionOptions[$profile?->religion]['id'] ?? $emptyValue, 'jp' => $religionOptions[$profile?->religion]['jp'] ?? null], 'span' => 'md:col-span-2'],
      ['label' => ['id' => 'Kebutuhan Hijab di Tempat Kerja', 'jp' => 'ヒジャブ'], 'value' => ['id' => $hijabOptions[$profile?->is_wearing_hijab]['id'] ?? $emptyValue, 'jp' => $hijabOptions[$profile?->is_wearing_hijab]['jp'] ?? null], 'span' => 'md:col-span-2'],
      ['label' => ['id' => 'Kebutuhan Ibadah di Tempat Kerja', 'jp' => '礼拝の必要'], 'value' => ['id' => $prayerOptions[$profile?->prayer_requirement]['id'] ?? $formatValue($profile?->prayer_requirement), 'jp' => $prayerOptions[$profile?->prayer_requirement]['jp'] ?? null], 'span' => 'md:col-span-2'],
      ['label' => ['id' => 'Toleransi Daging Babi', 'jp' => '豚肉の許容'], 'value' => ['id' => $porkToleranceOptions[$profile?->pork_tolerance]['id'] ?? $formatValue($profile?->pork_tolerance), 'jp' => $porkToleranceOptions[$profile?->pork_tolerance]['jp'] ?? null], 'span' => 'md:col-span-2'],
      ['label' => ['id' => 'Toleransi Minuman/Makanan Beralkohol', 'jp' => 'アルコールの許容'], 'value' => ['id' => $alcoholToleranceOptions[$profile?->alcohol_tolerance]['id'] ?? $formatValue($profile?->alcohol_tolerance), 'jp' => $alcoholToleranceOptions[$profile?->alcohol_tolerance]['jp'] ?? null], 'span' => 'md:col-span-2'],
      ['label' => ['id' => 'Pengalaman Teknis', 'jp' => '技術経験'], 'value' => ['id' => $formatValue($profile?->technical_experience)], 'span' => 'md:col-span-2'],
    ];
  @endphp

  <div data-candidate-language-root data-default-language="id">
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
          {{ $localizedText('Detail User', 'ユーザー詳細') }}
        </h1>
        <p class="mt-2 text-sm text-slate-500">
          {{ $localizedText('Ringkasan data akun, profil, pendidikan, dan pengalaman kerja.', 'アカウント、プロフィール、学歴、職歴の概要。') }}
        </p>
      </div>

      <div class="flex flex-wrap items-center gap-2">
        <x-candidate-language-switch default="id" />
        <a href="{{ route('admin.users') }}"
          class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
          {{ $localizedText('Kembali ke daftar user', 'ユーザー一覧へ戻る') }}
        </a>
      </div>
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

        <div class="mt-5 w-full rounded-xl border border-slate-200 bg-slate-50 p-4">
          <div class="mb-3 text-left">
            <p class="text-sm font-semibold text-slate-900">Video Jikoshoukai</p>
            <p class="mt-1 text-xs text-slate-500">Preview video perkenalan diri kandidat.</p>
          </div>
          @if ($jikoshoukaiThumbnailUrl && $profile?->jikoshoukai)
            <a href="{{ $profile->jikoshoukai }}" target="_blank" rel="noopener noreferrer"
              class="group block overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition hover:border-slate-300 hover:shadow-md">
              <div class="relative">
                <img src="{{ $jikoshoukaiThumbnailUrl }}" alt="Thumbnail video jikoshoukai {{ $displayName }}"
                  class="aspect-video w-full object-cover" />
                <div class="absolute inset-0 flex items-center justify-center bg-slate-950/20 transition group-hover:bg-slate-950/30">
                  <div class="flex h-14 w-14 items-center justify-center rounded-full bg-white/90 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6 fill-slate-900">
                      <path d="M8 5.14v13.72a1 1 0 0 0 1.53.85l10.4-6.86a1 1 0 0 0 0-1.7L9.53 4.29A1 1 0 0 0 8 5.14Z" />
                    </svg>
                  </div>
                </div>
              </div>
              <div class="border-t border-slate-200 px-3 py-2 text-left">
                <p class="truncate text-sm font-medium text-slate-900">{{ $profile->jikoshoukai }}</p>
                <p class="mt-1 text-xs text-slate-500">Klik untuk membuka video di YouTube</p>
              </div>
            </a>
          @else
            <div class="rounded-xl border border-dashed border-slate-300 bg-white px-4 py-8 text-center">
              <p class="text-sm font-medium text-slate-700">Belum ada video jikoshoukai</p>
              <p class="mt-1 text-xs text-slate-500">Kandidat belum menambahkan link YouTube perkenalan diri.</p>
            </div>
          @endif
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
            <div class="mt-3 flex flex-wrap items-center gap-2 text-xs text-slate-500">
              <span>{{ $user->email }}</span>
              <span
                class="inline-flex rounded-full px-2.5 py-1 font-semibold {{ $isProfileCompleted ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                {{ $isProfileCompleted ? 'Completed' : 'Incomplete' }}
              </span>
            </div>
          </div>
          <div class="flex flex-col gap-2 sm:items-end">
            <div class="text-sm text-slate-600">
              {{ $localizedText($profile?->created_at ? $profile->created_at->format('d M Y') . ' Tanggal dibuat' : $emptyValue, $profile?->created_at ? $profile->created_at->format('Y年m月d日') . ' 作成日' : $emptyValue) }}
            </div>
            <div class="flex items-center gap-2">
            <a href="{{ route('admin.users.profile.form', $user->id) }}"
              class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
              <x-icons.pencil size="14" />
              {{ $localizedText('Ubah Data', 'データ編集') }}
            </a>
            <a href="{{ route('admin.users.resume.print', $user->id) }}"
              class="inline-flex items-center gap-2 rounded-lg border border-slate-900 bg-slate-900 px-3 py-2 text-xs font-semibold text-white hover:bg-slate-800">
              <x-icons.fileText size="14" />
              {{ $localizedText('Print CV', 'CV印刷') }}
            </a>
            </div>
          </div>
        </div>

        <div class="overflow-hidden mt-10 rounded-2xl border border-slate-200 bg-slate-200">
          <div class="grid grid-cols-1 gap-px bg-slate-200 md:grid-cols-2">
            @foreach ($detailFields as $field)
              <div class="min-h-22 bg-white px-5 py-4">
                <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500">
                  {{ $localizedText($field['label']['id'], $field['label']['jp']) }}
                </p>
                <div class="flex gap-3 items-center mt-2">
                  <p class="text-sm font-medium text-slate-900">
                    {{ $localizedText($field['value']['id'], $field['value']['jp'] ?? null) }}
                  </p>
                </div>
              </div>
            @endforeach
          </div>
          <div class="mt-5 grid grid-cols-1 gap-px bg-slate-200 md:grid-cols-2">
            @foreach ($detailLongFields as $field)
              <div class="{{ $field['span'] }} min-h-28 bg-white px-5 py-4">
                <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500">
                  {{ $localizedText($field['label']['id'], $field['label']['jp']) }}
                </p>
                <p class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-700">{{ $localizedText($field['value']['id'], $field['value']['jp'] ?? null) }}</p>
              </div>
            @endforeach
          </div>
          <div class="mt-5 grid grid-cols-1 gap-px bg-slate-200 md:grid-cols-2">
            <div class="md:col-span-2 min-h-28 bg-white px-5 py-4">
              <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500">
                {{ $localizedText('Ringkasan Profil', '自己PRなど') }}
              </p>
              <p class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-700">{{ $localizedText($profile?->summary ?: $emptyValue, $profile?->jp_summary ?: null) }}</p>
            </div>
            <div class="md:col-span-2 min-h-28 bg-white px-5 py-4">
              <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500">
                {{ $localizedText('Alasan Pindah Kerja', '転職理由') }}
              </p>
              <p class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-700">{{ $localizedText($profile?->reason_for_leaving ?: $emptyValue, $profile?->jp_reason_for_leaving ?: null) }}</p>
            </div>
            <div class="md:col-span-2 min-h-28 bg-white px-5 py-4">
              <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500">
                {{ $localizedText('Informasi Tambahan', '備考') }}
              </p>
              <p class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-700">{{ $localizedText($profile?->additional_info ?: $emptyValue, $profile?->jp_additional_info ?: null) }}</p>
            </div>
          </div>
        </div>
      </section>

      <section class="rounded-2xl border border-slate-200 bg-white p-5">
        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
          <h2 class="text-sm font-semibold uppercase tracking-wider text-slate-500">
            {{ $localizedText('Riwayat Pendidikan', '学歴') }}
          </h2>
          <a href="{{ route('admin.users.education.index', $user->id) }}"
            class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
            <x-icons.pencil size="14" />
            {{ $localizedText('Ubah Data', 'データ編集') }}
          </a>
        </div>

        @if ($educationHistories->isNotEmpty())
          <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
              <thead class="bg-slate-50">
                <tr>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">{{ $localizedText('Institusi', '学校名') }}</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">{{ $localizedText('Jenjang', '学歴') }}</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">{{ $localizedText('Lokasi', '所在地') }}</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">{{ $localizedText('Masuk', '入学日') }}</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">{{ $localizedText('Lulus', '卒業日') }}</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">{{ $localizedText('Keluar', '中退日') }}</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">{{ $localizedText('Status', '状況') }}</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-200 bg-white text-slate-700">
                @foreach ($educationHistories as $educationHistory)
                  @php
                    $educationLabel = $resolveEducationOption($educationHistory->education, $educationLevelOptions);
                    $locationLabel = $resolveEducationOption($educationHistory->location, $educationLocationOptions);
                    $statusLabel = $resolveEducationOption($educationHistory->status, $educationStatusOptions);
                  @endphp
                  <tr>
                    <td class="whitespace-nowrap px-4 py-3">{{ $educationHistory->institution }}</td>
                    <td class="whitespace-nowrap px-4 py-3">
                      {{ $localizedText($educationLabel['id'], $educationLabel['jp']) }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-3">
                      {{ $localizedText($locationLabel['id'], $locationLabel['jp']) }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-3">{{ $localizedText($formatLocalizedDate($educationHistory->date_of_entry)['id'], $formatLocalizedDate($educationHistory->date_of_entry)['jp']) }}</td>
                    <td class="whitespace-nowrap px-4 py-3">{{ $localizedText($formatLocalizedDate($educationHistory->date_of_graduation)['id'], $formatLocalizedDate($educationHistory->date_of_graduation)['jp']) }}</td>
                    <td class="whitespace-nowrap px-4 py-3">{{ $localizedText($formatLocalizedDate($educationHistory->date_of_dropped_out)['id'], $formatLocalizedDate($educationHistory->date_of_dropped_out)['jp']) }}</td>
                    <td class="whitespace-nowrap px-4 py-3">
                      {{ $localizedText($statusLabel['id'], $statusLabel['jp']) }}
                    </td>
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
            {{ $localizedText('Pengalaman Kerja', '職歴') }}
          </h2>
          <a href="{{ route('admin.users.working-experience.index', $user->id) }}"
            class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
            <x-icons.pencil size="14" />
            {{ $localizedText('Ubah Data', 'データ編集') }}
          </a>
        </div>

        @if ($workExperiences->isNotEmpty())
          <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
              <thead class="bg-slate-50">
                <tr>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">{{ $localizedText('Bidang Kerja', '職種') }}</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">{{ $localizedText('Nama Perusahaan', '会社名') }}</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">{{ $localizedText('Lokasi', '所在地') }}</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">{{ $localizedText('Tanggal Masuk', '入社日') }}</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">{{ $localizedText('Tanggal Keluar', '退職日') }}</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">{{ $localizedText('Status Kerja', '雇用形態') }}</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">{{ $localizedText('Jenis Visa', '在留資格') }}</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-200 bg-white text-slate-700">
                @foreach ($workExperiences as $workExperience)
                  @php
                    $locationLabel = $resolveWorkOption($workExperience->location, $workingLocationOptions);
                    $statusLabel = $resolveWorkOption($workExperience->employment_status, $workingStatusOptions);
                  @endphp
                  <tr>
                    <td class="whitespace-nowrap px-4 py-3">{{ $workExperience->field_of_work }}</td>
                    <td class="whitespace-nowrap px-4 py-3">{{ $workExperience->company_name }}</td>
                    <td class="whitespace-nowrap px-4 py-3">
                      {{ $localizedText($locationLabel['id'], $locationLabel['jp']) }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-3">{{ $localizedText($formatLocalizedDate($workExperience->date_of_join)['id'], $formatLocalizedDate($workExperience->date_of_join)['jp']) }}</td>
                    <td class="whitespace-nowrap px-4 py-3">{{ $localizedText($formatLocalizedDate($workExperience->date_of_resign)['id'], $formatLocalizedDate($workExperience->date_of_resign)['jp']) }}</td>
                    <td class="whitespace-nowrap px-4 py-3">
                      {{ $localizedText($statusLabel['id'], $statusLabel['jp']) }}
                    </td>
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
  </div>
@endsection
