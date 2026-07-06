@extends('layouts.user-dashboard')

@section('title', 'NihonSkuy - Profil Pribadi')

@section('content_header', 'Curiculum Vitae')

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
      $emptyValue = '-';
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
      $formatLocalizedPeriod = function ($startDate, $endDate, $ongoingId = null, $ongoingJp = null) use ($formatLocalizedDate, $emptyValue) {
          $start = $formatLocalizedDate($startDate);
          $end = $endDate ? $formatLocalizedDate($endDate) : ['id' => $ongoingId ?: $emptyValue, 'jp' => $ongoingJp];

          return [
              'id' => $start['id'] . ' - ' . $end['id'],
              'jp' => ($start['jp'] ?? $start['id']) . ' - ' . ($end['jp'] ?? $end['id']),
          ];
      };
      $genderLabels = [
          'male' => 'Laki-laki',
          'female' => 'Perempuan',
      ];
      $genderJapaneseLabels = [
          'male' => '男',
          'female' => '女',
      ];
      $countryOptions = \App\Models\User\UserProfile::countryOptions();
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
      $resolveEducationOption = function (?string $value, array $options, bool $includeJapanese = true) {
          if (! filled($value) || ! isset($options[$value])) {
              return [
                  'id' => $value ?: '-',
                  'jp' => null,
              ];
          }

              return [
                  'id' => $options[$value]['id'],
                  'jp' => $includeJapanese ? $options[$value]['jp'] : null,
              ];
      };
      $resolveWorkOption = function (?string $value, array $options, bool $includeJapanese = true) {
          if (! filled($value) || ! isset($options[$value])) {
              return [
                  'id' => $value ?: '-',
                  'jp' => null,
              ];
          }

          return [
              'id' => $options[$value]['id'],
              'jp' => $includeJapanese ? $options[$value]['jp'] : null,
          ];
      };
      $publicShareUrl = route('public.candidates.show', auth()->id());

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

      $jlptValue = $profile->jlpt_level;
      $jikoshoukaiValue = old('jikoshoukai', $profile->jikoshoukai);
      $jikoshoukaiThumbnailUrl = $profile->jikoshoukai_thumbnail_url;
      $legacyJlptDisplayMap = [
          'none' => 'Tidak memiliki sertifikat',
          'other' => 'Lainnya',
      ];
      $jlptDisplay = $japaneseCertificateOptions[$jlptValue]['id'] ?? ($legacyJlptDisplayMap[$jlptValue] ?? ($jlptValue ?: '-'));
      $jlptJapanese = $japaneseCertificateOptions[$jlptValue]['jp'] ?? (($jlptValue === 'none') ? '資格なし' : (($jlptValue === 'other') ? 'その他' : ($jlptValue ?: null)));

      $resolveCountryOption = function (?string $value) use ($countryOptions, $emptyValue) {
          $key = strtolower(trim((string) $value));

          if (! filled($key) || ! isset($countryOptions[$key])) {
              return ['id' => $value ?: $emptyValue, 'jp' => null];
          }

          return ['id' => $countryOptions[$key]['id'], 'jp' => $countryOptions[$key]['jp']];
      };
      $personalInfoRows = [
          ['label' => ['id' => 'Tanggal Lahir', 'jp' => '生年月日'], 'value' => $formatLocalizedDate($profile->birth_date)],
          ['label' => ['id' => 'Jenis Kelamin', 'jp' => '性別'], 'value' => ['id' => $genderLabels[$profile->gender] ?? $emptyValue, 'jp' => $genderJapaneseLabels[$profile->gender] ?? null]],
          ['label' => ['id' => 'Umur', 'jp' => '年齢'], 'value' => ['id' => $profile->age ?? $emptyValue]],
          ['label' => ['id' => 'Daerah Asal', 'jp' => '出身地'], 'value' => ['id' => $profile->place_of_origin ?: $emptyValue]],
          ['label' => ['id' => 'Kewarganegaraan', 'jp' => '国籍'], 'value' => $resolveCountryOption($profile->nationality)],
          ['label' => ['id' => 'Domisili', 'jp' => '居住地'], 'value' => $resolveCountryOption($profile->domicile)],
          ['label' => ['id' => 'Tinggi Badan', 'jp' => '身長'], 'value' => ['id' => ($profile->height ?: $emptyValue) . ' cm']],
          ['label' => ['id' => 'Berat Badan', 'jp' => '体重'], 'value' => ['id' => ($profile->weight ?: $emptyValue) . ' kg']],
          ['label' => ['id' => 'Jenis Visa Saat Ini', 'jp' => '現在の在留資格'], 'value' => ['id' => $profile->current_visa_type ?: $emptyValue]],
          ['label' => ['id' => 'Masa Berlaku Visa', 'jp' => '在留期限'], 'value' => $formatLocalizedDate($profile->visa_expiry_date)],
          ['label' => ['id' => 'Level JLPT', 'jp' => 'JLPTレベル'], 'value' => ['id' => $jlptDisplay, 'jp' => $jlptJapanese]],
          ['label' => ['id' => 'Tanggal Masuk Jepang', 'jp' => '入国日'], 'value' => $formatLocalizedDate($profile->entry_date)],
          ['label' => ['id' => 'Tanggal Mulai Kerja', 'jp' => '就業開始日'], 'value' => ['id' => $profile->work_start_date ?: $emptyValue]],
          ['label' => ['id' => 'Memiliki SIM', 'jp' => '運転免許'], 'value' => ['id' => $driverLicenseOptions[$profile->has_driver_license]['id'] ?? ($profile->has_driver_license ?: $emptyValue), 'jp' => $driverLicenseOptions[$profile->has_driver_license]['jp'] ?? null]],
      ];

      $workPreferenceRows = [
          ['label' => ['id' => 'Alamat Saat Ini', 'jp' => '現住所'], 'value' => ['id' => $profile->current_address ?? $emptyValue]],
          ['label' => ['id' => 'Agama', 'jp' => '宗教'], 'value' => ['id' => $religionOptions[$profile->religion]['id'] ?? $emptyValue, 'jp' => $religionOptions[$profile->religion]['jp'] ?? null]],
          ['label' => ['id' => 'Kebutuhan Jilbab di Tempat Kerja?', 'jp' => 'ヒジャブ着用'], 'value' => ['id' => $hijabOptions[$profile->is_wearing_hijab]['id'] ?? $emptyValue, 'jp' => $hijabOptions[$profile->is_wearing_hijab]['jp'] ?? null]],
          ['label' => ['id' => 'Kebutuhan Ibadah di Tempat Kerja', 'jp' => '礼拝の必要'], 'value' => ['id' => $prayerOptions[$profile->prayer_requirement]['id'] ?? $emptyValue, 'jp' => $prayerOptions[$profile->prayer_requirement]['jp'] ?? null]],
          ['label' => ['id' => 'Toleransi terhadap daging babi', 'jp' => '豚肉の許容'], 'value' => ['id' => $porkToleranceOptions[$profile->pork_tolerance]['id'] ?? $emptyValue, 'jp' => $porkToleranceOptions[$profile->pork_tolerance]['jp'] ?? null]],
          ['label' => ['id' => 'Toleransi terhadap Alkohol', 'jp' => 'アルコールの許容'], 'value' => ['id' => $alcoholToleranceOptions[$profile->alcohol_tolerance]['id'] ?? $emptyValue, 'jp' => $alcoholToleranceOptions[$profile->alcohol_tolerance]['jp'] ?? null]],
          ['label' => ['id' => 'Pengalaman Teknis', 'jp' => '技術経験'], 'value' => ['id' => $profile->technical_experience ?: $emptyValue]],
      ];
    @endphp

    <div data-candidate-language-root data-default-language="jp" class="grid grid-cols-1 gap-4 lg:grid-cols-6">
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
          <div class="mt-5 rounded-xl border border-slate-200 bg-slate-50 p-4">
            <div class="mb-3">
              <h3 class="text-sm font-semibold text-slate-900">Video Jikoshoukai</h3>
              <p class="mt-1 text-xs text-slate-500">Tambahkan link YouTube perkenalan diri agar tampil pada profil kandidat.</p>
            </div>

            <form method="POST" action="{{ route('user.profile.jikoshoukai.store') }}" class="space-y-3">
              @csrf
              <div>
                <input id="jikoshoukai" name="jikoshoukai" type="url" value="{{ $jikoshoukaiValue }}"
                  placeholder="https://www.youtube.com/watch?v=..."
                  class="@error('jikoshoukai') border-red-300 focus:border-red-400 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror w-full rounded-xl border bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:ring-4" />
                @error('jikoshoukai')
                  <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <button type="submit"
                class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800">
                Simpan Link
              </button>
            </form>

            <div class="mt-4">
              @if ($jikoshoukaiThumbnailUrl && $profile->jikoshoukai)
                <a href="{{ $profile->jikoshoukai }}" target="_blank" rel="noopener noreferrer"
                  class="group block overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition hover:border-slate-300 hover:shadow-md">
                  <div class="relative">
                    <img src="{{ $jikoshoukaiThumbnailUrl }}" alt="Thumbnail video jikoshoukai {{ $profile->full_name }}"
                      class="aspect-video w-full object-cover" />
                    <div class="absolute inset-0 flex items-center justify-center bg-slate-950/20 transition group-hover:bg-slate-950/30">
                      <div class="flex h-14 w-14 items-center justify-center rounded-full bg-white/90 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6 fill-slate-900">
                          <path d="M8 5.14v13.72a1 1 0 0 0 1.53.85l10.4-6.86a1 1 0 0 0 0-1.7L9.53 4.29A1 1 0 0 0 8 5.14Z" />
                        </svg>
                      </div>
                    </div>
                  </div>
                  <div class="border-t border-slate-200 px-3 py-2">
                    <p class="truncate text-sm font-medium text-slate-900">{{ $profile->jikoshoukai }}</p>
                    <p class="mt-1 text-xs text-slate-500">Klik untuk membuka video di YouTube</p>
                  </div>
                </a>
              @else
                <div class="rounded-xl border border-dashed border-slate-300 bg-white px-4 py-8 text-center">
                  <p class="text-sm font-medium text-slate-700">Belum ada video jikoshoukai</p>
                  <p class="mt-1 text-xs text-slate-500">Masukkan link YouTube di atas untuk menampilkan thumbnail video.</p>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>

      <div class="space-y-4 lg:col-span-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
          <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
              <h2 class="text-xl font-semibold text-slate-900">{{ $profile->full_name }}</h2>
              <h2 class="text-sm text-slate-500">{{ $profile->furigana_name }}</h2>
            </div>
            <div class="flex flex-col gap-2 sm:items-end">
              <div class="text-sm text-slate-600">
                {{ $localizedText($profile->created_at ? $profile->created_at->format('d M Y') . ' Tanggal dibuat' : $emptyValue, $profile->created_at ? $profile->created_at->format('Y年m月d日') . ' 作成日' : $emptyValue) }}
              </div>
              <div class="relative">
                <button type="button" data-profile-menu-toggle aria-expanded="false"
                  class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                  <x-icons.menu size="16" />
                  <span>Menu</span>
                  <x-icons.chevronDown size="16" />
                </button>

                <div data-profile-menu-panel
                  class="absolute right-0 z-30 mt-2 w-[18rem] rounded-2xl border border-slate-200 bg-white p-3 shadow-xl"
                  style="display: none;">
                  <div class="space-y-1">
                    <div class="rounded-xl px-3 py-2">
                      <div class="mb-2 text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500">
                        {{ $localizedText('Bahasa', '言語') }}
                      </div>
                      <x-candidate-language-switch default="jp" />
                    </div>

                    <a href="{{ route('user.profile.form') }}" data-profile-menu-close
                      class="inline-flex w-full items-center rounded-xl px-3 py-2 text-left text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                      {{ $localizedText('Ubah Data', 'データの変更') }}
                    </a>

                    <button type="button" data-share-link="{{ $publicShareUrl }}" data-profile-menu-close
                      class="js-copy-public-link inline-flex w-full items-center rounded-xl px-3 py-2 text-left text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                      {{ $localizedText('Bagikan Profile', 'プロフィール共有') }}
                    </button>

                    <a href="{{ route('user.resume.print') }}" data-profile-menu-close
                      class="inline-flex w-full items-center rounded-xl px-3 py-2 text-left text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                      {{ $localizedText('Download CV', 'CVダウンロード') }}
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <p id="public-share-feedback" class="mt-2 hidden text-sm text-emerald-600">Link publik berhasil disalin.</p>
          <div class="mt-4 grid grid-cols-1 lg:grid-cols-2">
            @foreach ($personalInfoRows as $row)
              <div class="py-3 border border-slate-200 p-3">
                <div class="text-xs font-medium uppercase tracking-wide text-slate-500">{{ $localizedText($row['label']['id'], $row['label']['jp']) }}</div>
                <div class="mt-2 text-sm font-semibold text-slate-900">
                  {{ $localizedText($row['value']['id'], $row['value']['jp'] ?? null) }}
                </div>
              </div>
            @endforeach
          </div>

          <div class="mt-2 border border-slate-200 p-4">
            <div>
              @foreach ($workPreferenceRows as $row)
                <div class="py-3">
                  <div class="text-xs font-medium uppercase tracking-wide text-slate-500">{{ $localizedText($row['label']['id'], $row['label']['jp']) }}</div>
                  <div class="mt-1 whitespace-pre-line text-sm font-semibold text-slate-900">{{ $localizedText($row['value']['id'], $row['value']['jp'] ?? null) }}</div>
                </div>
              @endforeach
            </div>
          </div>

          <div class="mt-2 border border-slate-200 p-4">
            <div>
                <div class="py-3">
                  <div class="text-xs font-medium uppercase tracking-wide text-slate-500">{{ $localizedText('Ringkasan Profil', '自己PRなど') }}</div>
                  <div class="mt-1 whitespace-pre-line text-sm font-semibold text-slate-900">{{ $localizedText($profile->summary ?: $emptyValue, $profile->jp_summary ?: null) }}</div>
                </div>
            </div>
          </div>
          <div class="mt-2 border border-slate-200 p-4">
            <div>
                <div class="py-3">
                  <div class="text-xs font-medium uppercase tracking-wide text-slate-500">{{ $localizedText('Alasan Pindah Kerja', '転職理由') }}</div>
                  <div class="mt-1 whitespace-pre-line text-sm font-semibold text-slate-900">{{ $localizedText($profile->reason_for_leaving ?: $emptyValue, $profile->jp_reason_for_leaving ?: null) }}</div>
                </div>
            </div>
          </div>
          <div class="mt-2 border border-slate-200 p-4">
            <div>
                <div class="py-3">
                  <div class="text-xs font-medium uppercase tracking-wide text-slate-500">{{ $localizedText('Keterangan Tambahan', '備考') }}</div>
                  <div class="mt-1 whitespace-pre-line text-sm font-semibold text-slate-900">{{ $localizedText($profile->additional_info ?: $emptyValue, $profile->jp_additional_info ?: null) }}</div>
                </div>
            </div>
          </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
          <h2 class="text-base font-semibold text-slate-900">{{ $localizedText('Riwayat Pendidikan', '学歴') }}</h2>
          <div class="mt-4 overflow-x-auto rounded-xl border border-slate-200">
            @forelse ($educationHistories as $educationHistory)
              @if ($loop->first)
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                  <thead class="bg-slate-50">
                    <tr>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $localizedText('Institusi', '学校名') }}</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $localizedText('Pendidikan', '学歴') }}</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $localizedText('Lokasi', '所在地') }}</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $localizedText('Periode', '期間') }}</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $localizedText('Status', '状況') }}</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-slate-200 bg-white">
              @endif
              <tr>
                @php
                  $educationLabel = $resolveEducationOption($educationHistory->education, $educationLevelOptions);
                  $educationLocationLabel = $resolveEducationOption($educationHistory->location, $educationLocationOptions);
                  $educationStatusLabel = $resolveEducationOption($educationHistory->status, $educationStatusOptions);
                  $educationPeriod = $formatLocalizedPeriod(
                    $educationHistory->date_of_entry,
                    $educationHistory->date_of_graduation ?: $educationHistory->date_of_dropped_out
                  );
                @endphp
                <td class="px-4 py-3 text-slate-900">{{ $educationHistory->institution ?: '-' }}</td>
                <td class="px-4 py-3 text-slate-900">
                  {{ $localizedText($educationLabel['id'], $educationLabel['jp']) }}
                </td>
                <td class="px-4 py-3 text-slate-700">
                  {{ $localizedText($educationLocationLabel['id'], $educationLocationLabel['jp']) }}
                </td>
                <td class="px-4 py-3 text-slate-700">{{ $localizedText($educationPeriod['id'], $educationPeriod['jp']) }}</td>
                <td class="px-4 py-3 text-slate-700">
                  {{ $localizedText($educationStatusLabel['id'], $educationStatusLabel['jp']) }}
                </td>
              </tr>
              @if ($loop->last)
                </tbody>
                </table>
              @endif
            @empty
              <div class="border border-dashed border-slate-300 bg-slate-50 p-4 text-sm text-slate-500">
                {{ $localizedText('Belum ada riwayat pendidikan yang diisi.', '学歴データはまだありません。') }}
              </div>
            @endforelse
          </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
          <h2 class="text-base font-semibold text-slate-900">{{ $localizedText('Riwayat Pengalaman Kerja', '職歴') }}</h2>
          <div class="mt-4 overflow-x-auto rounded-xl border border-slate-200">
            @forelse ($workExperiences as $workExperience)
              @if ($loop->first)
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                  <thead class="bg-slate-50">
                    <tr>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $localizedText('Bidang Kerja', '職種') }}</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $localizedText('Perusahaan', '会社名') }}</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $localizedText('Lokasi', '所在地') }}</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $localizedText('Periode', '期間') }}</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $localizedText('Status', '雇用 / 在留資格') }}</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-slate-200 bg-white">
              @endif
              <tr>
                @php
                  $locationLabel = $resolveWorkOption($workExperience->location, $workingLocationOptions);
                  $statusLabel = $resolveWorkOption($workExperience->employment_status, $workingStatusOptions);
                  $workPeriod = $formatLocalizedPeriod($workExperience->date_of_join, $workExperience->date_of_resign, 'Sekarang', '現在');
                @endphp
                <td class="px-4 py-3 text-slate-900">{{ $workExperience->field_of_work ?: '-' }}</td>
                <td class="px-4 py-3 text-slate-900">{{ $workExperience->company_name ?: '-' }}</td>
                <td class="px-4 py-3 text-slate-700">
                  {{ $localizedText($locationLabel['id'], $locationLabel['jp']) }}
                </td>
                <td class="px-4 py-3 text-slate-700">{{ $localizedText($workPeriod['id'], $workPeriod['jp']) }}</td>
                <td class="px-4 py-3 text-slate-700">
                  {{ $localizedText($statusLabel['id'] . ($workExperience->visa_type ? ' • Visa: ' . $workExperience->visa_type : ''), ($statusLabel['jp'] ?? $statusLabel['id']) . ($workExperience->visa_type ? ' • 在留資格: ' . $workExperience->visa_type : '')) }}
                </td>
              </tr>
              @if ($loop->last)
                </tbody>
                </table>
              @endif
            @empty
              <div class="border border-dashed border-slate-300 bg-slate-50 p-4 text-sm text-slate-500">
                {{ $localizedText('Belum ada riwayat pengalaman kerja yang diisi.', '職歴データはまだありません。') }}
              </div>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  @endif
@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const copyButton = document.querySelector('.js-copy-public-link');
      const feedback = document.getElementById('public-share-feedback');
      const menuToggle = document.querySelector('[data-profile-menu-toggle]');
      const menuPanel = document.querySelector('[data-profile-menu-panel]');
      const menuCloseItems = document.querySelectorAll('[data-profile-menu-close]');

      const closeMenu = () => {
        if (!menuToggle || !menuPanel) {
          return;
        }

        menuPanel.style.display = 'none';
        menuToggle.setAttribute('aria-expanded', 'false');
      };

      const openMenu = () => {
        if (!menuToggle || !menuPanel) {
          return;
        }

        menuPanel.style.display = 'block';
        menuToggle.setAttribute('aria-expanded', 'true');
      };

      if (menuToggle && menuPanel) {
        menuToggle.addEventListener('click', (event) => {
          event.stopPropagation();

          if (menuToggle.getAttribute('aria-expanded') === 'true') {
            closeMenu();
            return;
          }

          openMenu();
        });

        menuPanel.addEventListener('click', (event) => {
          event.stopPropagation();
        });

        menuCloseItems.forEach((item) => {
          item.addEventListener('click', closeMenu);
        });

        document.addEventListener('click', (event) => {
          if (!menuToggle.contains(event.target) && !menuPanel.contains(event.target)) {
            closeMenu();
          }
        });

        document.addEventListener('keydown', (event) => {
          if (event.key === 'Escape') {
            closeMenu();
          }
        });
      }

      if (!copyButton) {
        return;
      }

      copyButton.addEventListener('click', async () => {
        const shareLink = copyButton.dataset.shareLink;

        try {
          if (navigator.clipboard && window.isSecureContext) {
            await navigator.clipboard.writeText(shareLink);
          } else {
            const tempInput = document.createElement('input');
            tempInput.value = shareLink;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            tempInput.remove();
          }

          if (feedback) {
            feedback.classList.remove('hidden');
            feedback.classList.remove('text-red-600');
            feedback.classList.add('text-emerald-600');
            feedback.textContent = 'Link publik berhasil disalin.';
          }
        } catch (error) {
          if (feedback) {
            feedback.classList.remove('hidden');
            feedback.textContent = 'Gagal menyalin link publik.';
            feedback.classList.remove('text-emerald-600');
            feedback.classList.add('text-red-600');
          }
        }
      });
    });
  </script>
@endpush
