@extends('layouts.tsk')

@section('title', 'TSK候補者一覧')

@section('content')
  <section class="mx-auto w-full max-w-[1240px] px-8 lg:px-16 xl:px-20">
    <div class="mb-6">
      <h1 class="text-2xl font-semibold tracking-tight text-slate-900">候補者一覧</h1>
      <p class="mt-1 text-sm text-slate-600">TSK向け登録候補者カタログ</p>
    </div>

    @if ($candidates->isEmpty())
      <div class="rounded-xl border border-dashed border-slate-300 bg-white p-8 text-center text-sm text-slate-500">
        登録済み候補者はまだありません。
      </div>
    @else
      <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
        @foreach ($candidates as $candidate)
          @php
            $profile = $candidate->userProfile;
            $profilePicturePath = $profile?->profile_picture ? ltrim($profile->profile_picture, '/') : null;
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

            $displayName = $profile?->full_name ?: $candidate->name ?: '候補者';
            $birthDate = $profile?->birth_date;
            $age = $birthDate ? $birthDate->age . '歳' : '-';
          @endphp
          <a href="{{ route('tsk.candidates.show', $candidate->id) }}"
            class="group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
            <div class="aspect-[8/7] w-full bg-slate-100">
              @if ($profilePictureUrl)
                <img src="{{ $profilePictureUrl }}" alt="{{ $displayName }}のプロフィール写真" class="h-full w-full object-cover" />
              @else
                <div class="flex h-full w-full items-center justify-center text-4xl font-semibold text-slate-400">
                  {{ strtoupper(substr($displayName ?: '候補者', 0, 1)) }}
                </div>
              @endif
            </div>
            <div class="space-y-1.5 p-3">
              <div class="text-sm font-semibold text-slate-900">{{ $displayName }}</div>
              <div class="text-xs text-slate-600">{{ $profile?->furigana_name ?: '-' }}</div>
              <div class="text-xs text-slate-700">年齢: {{ $age }}</div>
            </div>
          </a>
        @endforeach
      </div>

      <div class="mt-6 rounded-xl border border-slate-200 bg-white p-4">
        {{ $candidates->links() }}
      </div>
    @endif
  </section>
@endsection
