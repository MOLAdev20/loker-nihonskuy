@extends('layouts.public-share')

@section('title', '候補者プロフィール')

@section('content')
  @php
    $emptyValue = '-';
    $localizedText = function ($id, $jp = null) use ($emptyValue) {
        $idText = filled($id) ? (string) $id : $emptyValue;
        $jpText = filled($jp) ? (string) $jp : $idText;

        return new \Illuminate\Support\HtmlString(
            '<span data-lang="id" class="hidden">' . e($idText) . '</span>' .
            '<span data-lang="jp">' . e($jpText) . '</span>'
        );
    };
    $genderLabels = ['male' => 'Laki-laki', 'female' => 'Perempuan'];
    $genderJapaneseLabels = ['male' => '男', 'female' => '女'];
    $maritalStatusLabels = ['single' => 'Belum Menikah', 'married' => 'Menikah', 'divorce' => 'Cerai'];
    $maritalStatusJapaneseLabels = ['single' => 'なし', 'married' => 'あり', 'divorce' => 'なし'];
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
    $resolveCountryOption = function (?string $value) use ($countryOptions, $emptyValue) {
        $key = strtolower(trim((string) $value));

        if (! filled($key) || ! isset($countryOptions[$key])) {
            return ['id' => $value ?: $emptyValue, 'jp' => null];
        }

        return ['id' => $countryOptions[$key]['id'], 'jp' => $countryOptions[$key]['jp']];
    };
    $jikoshoukaiThumbnailUrl = $profile?->jikoshoukai_thumbnail_url;
    $personalInfoRows = [
        ['label' => ['id' => 'Tanggal Lahir', 'jp' => '生年月日'], 'value' => $formatLocalizedDate($profile?->birth_date)],
        ['label' => ['id' => 'Jenis Kelamin', 'jp' => '性別'], 'value' => ['id' => $genderLabels[$profile?->gender] ?? $emptyValue, 'jp' => $genderJapaneseLabels[$profile?->gender] ?? null]],
        ['label' => ['id' => 'Umur', 'jp' => '年齢'], 'value' => ['id' => $profile?->age ?? $emptyValue]],
        ['label' => ['id' => 'Daerah Asal', 'jp' => '出身地'], 'value' => ['id' => $profile?->place_of_origin ?: $emptyValue]],
        ['label' => ['id' => 'Kewarganegaraan', 'jp' => '国籍'], 'value' => $resolveCountryOption($profile?->nationality)],
        ['label' => ['id' => 'Domisili', 'jp' => '居住地'], 'value' => $resolveCountryOption($profile?->domicile)],
        ['label' => ['id' => 'Status Pernikahan', 'jp' => '婚姻状況'], 'value' => ['id' => $maritalStatusLabels[$profile?->marital_status] ?? $emptyValue, 'jp' => $maritalStatusJapaneseLabels[$profile?->marital_status] ?? null]],
        ['label' => ['id' => 'Tinggi Badan', 'jp' => '身長'], 'value' => ['id' => ($profile?->height ?: $emptyValue) . ' cm']],
        ['label' => ['id' => 'Berat Badan', 'jp' => '体重'], 'value' => ['id' => ($profile?->weight ?: $emptyValue) . ' kg']],
        ['label' => ['id' => 'Jenis Visa Saat Ini', 'jp' => '現在の在留資格'], 'value' => ['id' => $profile?->current_visa_type ?: $emptyValue]],
        ['label' => ['id' => 'Masa Berlaku Visa', 'jp' => '在留期限'], 'value' => $formatLocalizedDate($profile?->visa_expiry_date)],
        ['label' => ['id' => 'Level JLPT', 'jp' => 'JLPTレベル'], 'value' => ['id' => $japaneseCertificateOptions[$profile?->jlpt_level]['id'] ?? ($profile?->jlpt_level ?: $emptyValue), 'jp' => $japaneseCertificateOptions[$profile?->jlpt_level]['jp'] ?? null]],
        ['label' => ['id' => 'Tanggal Masuk', 'jp' => '入国日'], 'value' => $formatLocalizedDate($profile?->entry_date)],
        ['label' => ['id' => 'Mulai Kerja', 'jp' => '就業開始日'], 'value' => ['id' => $profile?->work_start_date ?: $emptyValue]],
        ['label' => ['id' => 'Memiliki SIM', 'jp' => '運転免許'], 'value' => ['id' => $driverLicenseOptions[$profile?->has_driver_license]['id'] ?? ($profile?->has_driver_license ?: $emptyValue), 'jp' => $driverLicenseOptions[$profile?->has_driver_license]['jp'] ?? null]],
    ];

    $workPreferenceRows = [
        ['label' => ['id' => 'Alamat Saat Ini', 'jp' => '現住所'], 'value' => ['id' => $profile?->current_address ?: $emptyValue]],
        ['label' => ['id' => 'Agama', 'jp' => '宗教'], 'value' => ['id' => $religionOptions[$profile?->religion]['id'] ?? $emptyValue, 'jp' => $religionOptions[$profile?->religion]['jp'] ?? null]],
        ['label' => ['id' => 'Kebutuhan Hijab', 'jp' => 'ヒジャブ着用'], 'value' => ['id' => $hijabOptions[$profile?->is_wearing_hijab]['id'] ?? $emptyValue, 'jp' => $hijabOptions[$profile?->is_wearing_hijab]['jp'] ?? null]],
        ['label' => ['id' => 'Kebutuhan Ibadah', 'jp' => '礼拝の必要'], 'value' => ['id' => $prayerOptions[$profile?->prayer_requirement]['id'] ?? $emptyValue, 'jp' => $prayerOptions[$profile?->prayer_requirement]['jp'] ?? null]],
        ['label' => ['id' => 'Toleransi Daging Babi', 'jp' => '豚肉の許容'], 'value' => ['id' => $porkToleranceOptions[$profile?->pork_tolerance]['id'] ?? $emptyValue, 'jp' => $porkToleranceOptions[$profile?->pork_tolerance]['jp'] ?? null]],
        ['label' => ['id' => 'Toleransi Alkohol', 'jp' => 'アルコールの許容'], 'value' => ['id' => $alcoholToleranceOptions[$profile?->alcohol_tolerance]['id'] ?? $emptyValue, 'jp' => $alcoholToleranceOptions[$profile?->alcohol_tolerance]['jp'] ?? null]],
        ['label' => ['id' => 'Pengalaman Teknis', 'jp' => '技術経験'], 'value' => ['id' => $profile?->technical_experience ?: $emptyValue]],
    ];
  @endphp

  <section data-candidate-language-root data-default-language="jp" class="mx-auto w-full max-w-[1240px] px-8 lg:px-16 xl:px-20">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h1 class="text-2xl font-semibold tracking-tight text-slate-900">{{ $localizedText('Profil Kandidat', '候補者プロフィール') }}</h1>
        <p class="mt-1 text-sm text-slate-600">{{ $profile->full_name }}</p>
      </div>
      <x-candidate-language-switch default="jp" />
    </div>

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-6">
      <div class="lg:col-span-2">
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
          @if ($profilePictureUrl)
            <img src="{{ $profilePictureUrl }}" alt="{{ $profile->full_name }}のプロフィール写真"
              class="aspect-[3/4] w-full rounded-lg border border-slate-200 object-cover" />
          @else
            <div
              class="flex aspect-[3/4] w-full items-center justify-center rounded-lg border border-dashed border-slate-300 bg-slate-50 text-4xl font-semibold text-slate-400">
              {{ strtoupper(substr($profile->full_name ?: '候補者', 0, 1)) }}
            </div>
          @endif
        </div>
        <div class="mt-5 rounded-xl border border-slate-200 bg-slate-50 p-4">
          <div class="mb-3">
            <p class="text-sm font-semibold text-slate-900">{{ $localizedText('Video Jikoshoukai', '自己紹介動画') }}</p>
            <p class="mt-1 text-xs text-slate-500">{{ $localizedText('Preview video perkenalan diri kandidat.', '候補者の自己紹介動画プレビュー。') }}</p>
          </div>
          @if ($jikoshoukaiThumbnailUrl && $profile?->jikoshoukai)
            <a href="{{ $profile->jikoshoukai }}" target="_blank" rel="noopener noreferrer"
              class="group block overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition hover:border-slate-300 hover:shadow-md">
              <div class="relative">
                <img src="{{ $jikoshoukaiThumbnailUrl }}" alt="{{ $profile->full_name }}の自己紹介動画サムネイル"
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
                <p class="mt-1 text-xs text-slate-500">{{ $localizedText('Klik untuk membuka video di YouTube', 'YouTubeで動画を開く') }}</p>
              </div>
            </a>
          @else
            <div class="rounded-xl border border-dashed border-slate-300 bg-white px-4 py-8 text-center">
              <p class="text-sm font-medium text-slate-700">{{ $localizedText('Belum ada video jikoshoukai', '自己紹介動画はまだありません') }}</p>
              <p class="mt-1 text-xs text-slate-500">{{ $localizedText('Kandidat belum menambahkan link YouTube perkenalan diri.', '候補者はまだYouTubeリンクを追加していません。') }}</p>
            </div>
          @endif
        </div>
      </div>

      <div class="space-y-4 lg:col-span-4">
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
          <div class="flex justify-between items-center">
            <div>
              <h2 class="text-base font-semibold text-slate-900">{{ $profile->furigana_name }}</h2>
              <p class="text-sm text-slate-500">{{ $profile->full_name }}</p>
            </div>
            <div class="text-sm text-slate-600">
              {{ $localizedText($profile?->created_at?->format('d M Y') . ' Tanggal dibuat', $profile?->created_at?->format('Y年m月d日') . ' 作成日') }}
            </div>
          </div>
          <div class="mt-5 grid grid-cols-1 gap-4 lg:grid-cols-2">
            @foreach ($personalInfoRows as $row)
              <div class="mt-1">
                <div class="text-xs font-medium uppercase tracking-wide text-slate-500">{{ $localizedText($row['label']['id'], $row['label']['jp']) }}</div>
                <div class="mt-1 whitespace-pre-line text-sm font-semibold text-slate-900">{{ $localizedText($row['value']['id'], $row['value']['jp'] ?? null) }}</div>
              </div>
            @endforeach
          </div>

          <div class="mt-5 border border-slate-200 p-4">
            @foreach ($workPreferenceRows as $row)
              <div class="py-3">
                <div class="text-xs font-medium uppercase tracking-wide text-slate-500">{{ $localizedText($row['label']['id'], $row['label']['jp']) }}</div>
                <div class="mt-1 whitespace-pre-line text-sm font-semibold text-slate-900">{{ $localizedText($row['value']['id'], $row['value']['jp'] ?? null) }}</div>
              </div>
            @endforeach
          </div>
          <div class="mt-3 border border-slate-200 p-4">
            <div class="py-3">
              <div class="text-xs font-medium uppercase tracking-wide text-slate-500">{{ $localizedText('Ringkasan Profil', '自己PRなど') }}</div>
              <div class="mt-1 whitespace-pre-line text-sm font-semibold text-slate-900">{{ $localizedText($profile->summary ?: $emptyValue, $profile->jp_summary ?: null) }}</div>
            </div>
          </div>
          <div class="mt-2 border border-slate-200 p-4">
            <div class="py-3">
              <div class="text-xs font-medium uppercase tracking-wide text-slate-500">{{ $localizedText('Alasan Pindah Kerja', '転職理由') }}</div>
              <div class="mt-1 whitespace-pre-line text-sm font-semibold text-slate-900">{{ $localizedText($profile->reason_for_leaving ?: $emptyValue, $profile->jp_reason_for_leaving ?: null) }}</div>
            </div>
          </div>
          <div class="mt-2 border border-slate-200 p-4">
            <div class="py-3">
              <div class="text-xs font-medium uppercase tracking-wide text-slate-500">{{ $localizedText('Informasi Tambahan', '備考') }}</div>
              <div class="mt-1 whitespace-pre-line text-sm font-semibold text-slate-900">{{ $localizedText($profile->additional_info ?: $emptyValue, $profile->jp_additional_info ?: null) }}</div>
            </div>
          </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
          <h2 class="text-base font-semibold text-slate-900">{{ $localizedText('Riwayat Pendidikan', '学歴') }}</h2>
          <div class="mt-4 overflow-x-auto rounded-lg border border-slate-200">
            @forelse ($educationHistories as $educationHistory)
              @if ($loop->first)
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                  <thead class="bg-slate-50">
                    <tr>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $localizedText('Jenjang', '学歴') }}</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $localizedText('Nama Sekolah', '学校名') }}</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $localizedText('Lokasi', '所在地') }}</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $localizedText('Periode', '期間') }}</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $localizedText('Status', '状況') }}</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-slate-200 bg-white">
              @endif
              @php
                $educationLabel = $resolveEducationOption($educationHistory->education, $educationLevelOptions);
                $locationLabel = $resolveEducationOption($educationHistory->location, $educationLocationOptions);
                $statusLabel = $resolveEducationOption($educationHistory->status, $educationStatusOptions);
                $educationPeriod = $formatLocalizedPeriod(
                  $educationHistory->date_of_entry,
                  $educationHistory->date_of_graduation ?: $educationHistory->date_of_dropped_out
                );
              @endphp
              <tr>
                <td class="px-4 py-3 text-slate-900">{{ $localizedText($educationLabel['id'], $educationLabel['jp']) }}</td>
                <td class="px-4 py-3 text-slate-900">{{ $educationHistory->institution ?: '-' }}</td>
                <td class="px-4 py-3 text-slate-700">{{ $localizedText($locationLabel['id'], $locationLabel['jp']) }}</td>
                <td class="px-4 py-3 text-slate-700">{{ $localizedText($educationPeriod['id'], $educationPeriod['jp']) }}</td>
                <td class="px-4 py-3 text-slate-700">{{ $localizedText($statusLabel['id'], $statusLabel['jp']) }}</td>
              </tr>
              @if ($loop->last)
                  </tbody>
                </table>
              @endif
            @empty
              <div class="border border-dashed border-slate-300 bg-slate-50 p-4 text-sm text-slate-500">
                {{ $localizedText('Data pendidikan belum tersedia.', '学歴データはまだありません。') }}
              </div>
            @endforelse
          </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
          <h2 class="text-base font-semibold text-slate-900">{{ $localizedText('Pengalaman Kerja', '職歴') }}</h2>
          <div class="mt-4 overflow-x-auto rounded-lg border border-slate-200">
            @forelse ($workExperiences as $workExperience)
              @if ($loop->first)
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                  <thead class="bg-slate-50">
                    <tr>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $localizedText('Bidang Kerja', '職種') }}</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $localizedText('Nama Perusahaan', '会社名') }}</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $localizedText('Lokasi', '所在地') }}</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $localizedText('Periode', '期間') }}</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $localizedText('Status Kerja / Visa', '雇用 / 在留資格') }}</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-slate-200 bg-white">
              @endif
              @php
                $locationLabel = $resolveWorkOption($workExperience->location, $workingLocationOptions);
                $statusLabel = $resolveWorkOption($workExperience->employment_status, $workingStatusOptions);
                $workPeriod = $formatLocalizedPeriod($workExperience->date_of_join, $workExperience->date_of_resign, 'Sekarang', '現在');
              @endphp
              <tr>
                <td class="px-4 py-3 text-slate-900">{{ $workExperience->field_of_work ?: '-' }}</td>
                <td class="px-4 py-3 text-slate-900">{{ $workExperience->company_name ?: '-' }}</td>
                <td class="px-4 py-3 text-slate-700">{{ $localizedText($locationLabel['id'], $locationLabel['jp']) }}</td>
                <td class="px-4 py-3 text-slate-700">{{ $localizedText($workPeriod['id'], $workPeriod['jp']) }}</td>
                <td class="px-4 py-3 text-slate-700">
                  {{ $localizedText($statusLabel['id'] . ($workExperience->visa_type ? ' • ' . $workExperience->visa_type : ''), ($statusLabel['jp'] ?? $statusLabel['id']) . ($workExperience->visa_type ? ' • ' . $workExperience->visa_type : '')) }}
                </td>
              </tr>
              @if ($loop->last)
                  </tbody>
                </table>
              @endif
            @empty
              <div class="border border-dashed border-slate-300 bg-slate-50 p-4 text-sm text-slate-500">
                {{ $localizedText('Data pengalaman kerja belum tersedia.', '職歴データはまだありません。') }}
              </div>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
