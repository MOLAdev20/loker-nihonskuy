@extends('layouts.tsk')

@section('title', 'TSK候補者詳細')

@section('content')
  @php
    $genderLabels = [
        'male' => '男性',
        'female' => '女性',
    ];
    $maritalStatusLabels = [
        'single' => '未婚',
        'married' => '既婚',
        'divorce' => '離婚',
    ];
    $religionLabels = [
        'islam' => 'イスラム教',
        'kristen' => 'キリスト教',
        'katolik' => 'カトリック',
        'hindu' => 'ヒンドゥー教',
        'buddha' => '仏教',
    ];

    $displayName = $profile?->full_name ?: $candidate->name ?: '候補者';
    $personalInfoRows = [
        '氏名' => $profile?->full_name ?: $candidate->name ?: '-',
        'ふりがな' => $profile?->furigana_name ?: '-',
        '生年月日' => $profile?->birth_date?->format('d M Y') ?: '-',
        '性別' => $genderLabels[$profile?->gender] ?? '-',
        '身長 / 体重' => ($profile?->height ?: '-') . ' cm / ' . ($profile?->weight ?: '-') . ' kg',
        '婚姻状況' => $maritalStatusLabels[$profile?->marital_status] ?? '-',
        '国籍' => $profile?->nationality ?: '-',
        '出身地' => $profile?->place_of_origin ?: '-',
        '現住所' => $profile?->current_address ?: '-',
        '宗教' => $religionLabels[$profile?->religion] ?? '-',
        'ヒジャブ着用' => $profile?->is_wearing_hijab ?: '-',
        '礼拝の必要' => $profile?->prayer_requirement ?: '-',
        '豚肉の許容' => $profile?->pork_tolerance ?: '-',
        'アルコールの許容' => $profile?->alcohol_tolerance ?: '-',
        '入国日' => $profile?->entry_date?->format('d M Y') ?: '-',
        '在留期限' => $profile?->visa_expiry_date?->format('d M Y') ?: '-',
        '現在の在留資格' => $profile?->current_visa_type ?: '-',
        'JLPTレベル' => $profile?->jlpt_level ?: '-',
        '運転免許' => $profile?->has_driver_license ?: '-',
        '就業開始日' => $profile?->work_start_date?->format('d M Y') ?: '-',
        '技術経験' => $profile?->technical_experience ?: '-',
    ];
    $personalInfoChunks = array_chunk($personalInfoRows, (int) ceil(count($personalInfoRows) / 2), true);
  @endphp

  <section class="mx-auto w-full max-w-[1240px] px-8 lg:px-16 xl:px-20">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h1 class="text-2xl font-semibold tracking-tight text-slate-900">候補者詳細</h1>
        <p class="mt-1 text-sm text-slate-600">{{ $displayName }}</p>
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
            <img src="{{ $profilePictureUrl }}" alt="{{ $displayName }}のプロフィール写真"
              class="aspect-[3/4] w-full rounded-lg border border-slate-200 object-cover" />
          @else
            <div
              class="flex aspect-[3/4] w-full items-center justify-center rounded-lg border border-dashed border-slate-300 bg-slate-50 text-4xl font-semibold text-slate-400">
              {{ strtoupper(substr($displayName ?: '候補者', 0, 1)) }}
            </div>
          @endif
        </div>
      </div>

      <div class="space-y-4 lg:col-span-4">
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
          <h2 class="text-base font-semibold text-slate-900">個人情報</h2>
          <div class="mt-4 grid grid-cols-1 gap-4 lg:grid-cols-2">
            @foreach ($personalInfoChunks as $chunk)
              <div class="p-4">
                <div class="space-y-3">
                  @foreach ($chunk as $label => $value)
                    <div>
                      <div class="text-xs font-medium uppercase tracking-wide text-slate-500">{{ $label }}</div>
                      <div class="mt-1 text-sm font-semibold text-slate-900">{{ $value }}</div>
                    </div>
                  @endforeach
                </div>
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
