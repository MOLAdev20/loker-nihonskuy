@extends('layouts.tsk')

@section('title', 'TSK候補者詳細')

@section('content')
  @php
    $genderLabels = ['male' => 'Laki-laki', 'female' => 'Perempuan'];
    $genderJapaneseLabels = ['male' => '男', 'female' => '女'];
    $maritalStatusLabels = ['single' => 'Belum Menikah', 'married' => 'Menikah', 'divorce' => 'Cerai'];
    $maritalStatusJapaneseLabels = ['single' => 'なし', 'married' => 'あり', 'divorce' => 'なし'];
    $nationalityJapaneseLabels = ['jepang' => '日本', 'japan' => '日本', 'indonesia' => 'インドネシア'];
    $religionOptions = \App\Models\User\UserProfile::religionOptions();
    $hijabOptions = \App\Models\User\UserProfile::hijabOptions();
    $prayerOptions = \App\Models\User\UserProfile::prayOptions();
    $porkToleranceOptions = \App\Models\User\UserProfile::porkToleranceOptions();
    $alcoholToleranceOptions = \App\Models\User\UserProfile::alcoholToleranceOptions();
    $driverLicenseOptions = \App\Models\User\UserProfile::driverLicenseOptions();
    $japaneseCertificateOptions = \App\Models\User\UserProfile::japaneseCertificateOptions();
    $nationalityKey = strtolower(trim((string) ($profile?->nationality ?? '')));
    $personalInfoRows = [
        '生年月日' => ['id' => $profile?->birth_date?->format('d M Y') ?: '-', 'jp' => $profile?->birth_date?->format('Y年n月j日')],
        '性別' => ['id' => $genderLabels[$profile?->gender] ?? '-', 'jp' => $genderJapaneseLabels[$profile?->gender] ?? null],
        '年' => ['id' => $profile?->age ?? '-'],
        '出身地' => ['id' => $profile?->place_of_origin ?: '-'],
        '国籍' => ['id' => $profile?->nationality ?: '-', 'jp' => $nationalityJapaneseLabels[$nationalityKey] ?? null],
        '婚姻状況' => ['jp' => $maritalStatusJapaneseLabels[$profile?->marital_status] ?: '-'],
        '身長' => ['id' => ($profile?->height ?: '-') . ' cm'],
        '体重' =>  ['id' => ($profile?->weight ?: '-') . ' kg'],
        '現在の在留資格' => ['id' => $profile?->current_visa_type ?: '-'],
        '在留期限' => ['id' => $profile?->visa_expiry_date?->format('d M Y') ?: '-', 'jp' => $profile?->visa_expiry_date?->format('Y年n月j日')],
        'JLPTレベル' => ['id' => $japaneseCertificateOptions[$profile?->jlpt_level]['id'] ?? ($profile?->jlpt_level ?: '-'), 'jp' => $japaneseCertificateOptions[$profile?->jlpt_level]['jp'] ?? null],
        '入国日' => ['id' => $profile?->entry_date?->format('d M Y') ?: '-', 'jp' => $profile?->entry_date?->format('Y年n月j日')],
        '就業開始日' => ['id' => $profile?->work_start_date?->format('d M Y') ?: '-', 'jp' => $profile?->work_start_date?->format('Y年n月j日')],
        '運転免許' => ['id' => $driverLicenseOptions[$profile?->has_driver_license]['id'] ?? ($profile?->has_driver_license ?: '-'), 'jp' => $driverLicenseOptions[$profile?->has_driver_license]['jp'] ?? null],
    ];

    $workPreferenceRows = [
        '現住所' => ['id' => $profile?->current_address ?: '-'],
        '宗教' => ['id' => $religionOptions[$profile?->religion]['id'] ?? '-', 'jp' => $religionOptions[$profile?->religion]['jp'] ?? null],
        'ヒジャブ着用' => ['id' => $hijabOptions[$profile?->is_wearing_hijab]['id'] ?? '-', 'jp' => $hijabOptions[$profile?->is_wearing_hijab]['jp'] ?? null],
        '礼拝の必要' => ['id' => $prayerOptions[$profile?->prayer_requirement]['id'] ?? '-', 'jp' => $prayerOptions[$profile?->prayer_requirement]['jp'] ?? null],
        '豚肉の許容' => ['id' => $porkToleranceOptions[$profile?->pork_tolerance]['id'] ?? '-', 'jp' => $porkToleranceOptions[$profile?->pork_tolerance]['jp'] ?? null],
        'アルコールの許容' => ['id' => $alcoholToleranceOptions[$profile?->alcohol_tolerance]['id'] ?? '-', 'jp' => $alcoholToleranceOptions[$profile?->alcohol_tolerance]['jp'] ?? null],
        '技術経験' => ['id' => $profile?->technical_experience ?: '-'],
    ];
  @endphp

  <section class="mx-auto w-full max-w-[1240px] px-8 lg:px-16 xl:px-20">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h1 class="text-2xl font-semibold tracking-tight text-slate-900">候補者詳細</h1>
        <p class="mt-1 text-sm text-slate-600">{{ $profile->full_name }}</p>
      </div>
      <div class="flex flex-wrap items-center gap-2">
        <a href="{{ route('tsk.candidates.resume.download', $candidate->id) }}"
          class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-800">
          CVダウンロード
        </a>
        <a href="{{ route('tsk.candidates.index') }}"
          class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
          候補者一覧へ戻る
        </a>
      </div>
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
      </div>

      <div class="space-y-4 lg:col-span-4">
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
          <div>
            <h2 class="text-base font-semibold text-slate-900">{{ $profile->furigana_name }}</h2>
            <p class="text-slate-500 text-sm">{{ $profile->full_name }}</p>
          </div>
          <div class="mt-5 grid grid-cols-1 gap-4 lg:grid-cols-2">
            @foreach ($personalInfoRows as $label => $value)
              <div class="py-3">
                <div class="text-xs font-medium uppercase tracking-wide text-slate-500">{{ $label }}</div>
                <div class="mt-1 whitespace-pre-line text-sm font-semibold text-slate-900">{{ $value['jp'] ?? $value['id'] }}</div>
              </div>
            @endforeach
          </div>

          <div class="mt-2 border border-slate-200 p-4">
            @foreach ($workPreferenceRows as $label => $value)
              <div class="py-3">
                <div class="text-xs font-medium uppercase tracking-wide text-slate-500">{{ $label }}</div>
                <div class="mt-1 whitespace-pre-line text-sm font-semibold text-slate-900">{{ $value['jp'] ?? $value['id'] }}</div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
          <h2 class="text-base font-semibold text-slate-900">学歴</h2>
          <div class="mt-4 overflow-x-auto rounded-lg border border-slate-200">
            @forelse ($educationHistories as $educationHistory)
              @if ($loop->first)
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                  <thead class="bg-slate-50">
                    <tr>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">学歴</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">学校名</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">所在地</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">期間</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">状況</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-slate-200 bg-white">
              @endif
              <tr>
                <td class="px-4 py-3 text-slate-900">{{ $educationHistory->education ?: '-' }}</td>
                <td class="px-4 py-3 text-slate-900">{{ $educationHistory->institution ?: '-' }}</td>
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
                学歴データはまだありません。
              </div>
            @endforelse
          </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
          <h2 class="text-base font-semibold text-slate-900">職歴</h2>
          <div class="mt-4 overflow-x-auto rounded-lg border border-slate-200">
            @forelse ($workExperiences as $workExperience)
              @if ($loop->first)
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                  <thead class="bg-slate-50">
                    <tr>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">職種</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">会社名</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">所在地</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">期間</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">雇用 / 在留資格</th>
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
                  {{ $workExperience->date_of_resign?->format('d M Y') ?: '現在' }}
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
                職歴データはまだありません。
              </div>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
