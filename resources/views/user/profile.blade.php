@extends('layouts.user-dashboard')

@section('title', 'Dashboard User')

@section('content_header', 'Dashboard User')

@section('content_subheader', 'Ringkasan profil, aktivitas lamaran, dan pengaturan akun Anda.')

@section('content')
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
      $maritalStatusLabels = [
          'single' => 'Belum Menikah',
          'married' => 'Menikah',
          'divorce' => 'Cerai',
      ];
      $religionLabels = [
          'islam' => 'Islam',
          'kristen' => 'Kristen',
          'katolik' => 'Katolik',
          'hindu' => 'Hindu',
          'buddha' => 'Buddha',
      ];

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

      $personalInfoRows = [
          'Nama Lengkap' => $profile->full_name ?: '-',
          'Furigana' => $profile->furigana_name ?: '-',
          'Tanggal Lahir' => $profile->birth_date?->format('d M Y') ?: '-',
          'Jenis Kelamin' => $genderLabels[$profile->gender] ?? '-',
          'Tinggi / Berat' => ($profile->height ?: '-') . ' cm / ' . ($profile->weight ?: '-') . ' kg',
          'Status Pernikahan' => $maritalStatusLabels[$profile->marital_status] ?? '-',
          'Kewarganegaraan' => $profile->nationality ?: '-',
          'Tempat Asal' => $profile->place_of_origin ?: '-',
          'Alamat Saat Ini' => $profile->current_address ?: '-',
          'Agama' => $religionLabels[$profile->religion] ?? '-',
          'Apakah Menggunakan Hijab?' => $profile->is_wearing_hijab ?: '-',
          'Kebutuhan Ibadah' => $profile->prayer_requirement ?: '-',
          'Toleransi terhadap daging babi' => $profile->pork_tolerance ?: '-',
          'Toleransi terhadap Alkohol' => $profile->alcohol_tolerance ?: '-',
          'Tanggal Masuk Jepang' => $profile->entry_date?->format('d M Y') ?: '-',
          'Masa Berlaku Visa' => $profile->visa_expiry_date?->format('d M Y') ?: '-',
          'Jenis Visa Saat Ini' => $profile->current_visa_type ?: '-',
          'Level JLPT' => $profile->jlpt_level ?: '-',
          'Memiliki SIM' => $profile->has_driver_license ?: '-',
          'Tanggal Siap Mulai Kerja' => $profile->work_start_date?->format('d M Y') ?: '-',
          'Pengalaman Teknis' => $profile->technical_experience ?: '-',
      ];
    @endphp

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-6">
      <div class="lg:col-span-2">
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
          <h2 class="text-sm font-semibold uppercase tracking-wider text-slate-500">Foto Profile</h2>
          <div class="mt-4">
            @if ($profilePictureUrl)
              <img src="{{ $profilePictureUrl }}" alt="Foto profile {{ $profile->full_name }}"
                class="aspect-[3/4] w-full rounded-xl border border-slate-200 object-cover" />
            @else
              <div
                class="flex aspect-[3/4] w-full items-center justify-center rounded-xl border border-dashed border-slate-300 bg-slate-50 text-4xl font-semibold text-slate-400">
                {{ strtoupper(substr($profile->full_name ?: auth()->user()->name, 0, 1)) }}
              </div>
            @endif
          </div>
        </div>
      </div>

      <div class="space-y-4 lg:col-span-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
          <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <h2 class="text-base font-semibold text-slate-900">Informasi Pribadi</h2>
            <a href="{{ route('user.resume.print') }}"
              class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-800">
              Download CV
            </a>
          </div>
          <div class="mt-4 divide-y divide-slate-200 rounded-xl border border-slate-200">
            @foreach ($personalInfoRows as $label => $value)
              <div class="grid grid-cols-1 gap-2 px-4 py-3 sm:grid-cols-3">
                <div class="text-sm font-medium text-slate-600">{{ $label }}</div>
                <div class="text-sm text-slate-900 sm:col-span-2">{{ $value }}</div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
          <h2 class="text-base font-semibold text-slate-900">Riwayat Pendidikan</h2>
          <div class="mt-4 space-y-3">
            @forelse ($educationHistories as $educationHistory)
              <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                <div class="text-sm font-semibold text-slate-900">
                  {{ $educationHistory->education ?: '-' }} - {{ $educationHistory->institution ?: '-' }}
                </div>
                <div class="mt-1 text-sm text-slate-600">{{ $educationHistory->location ?: '-' }}</div>
                <div class="mt-2 text-xs text-slate-500">
                  {{ $educationHistory->date_of_entry?->format('d M Y') ?: '-' }} -
                  {{ $educationHistory->date_of_graduation?->format('d M Y') ?: ($educationHistory->date_of_dropped_out?->format('d M Y') ?: '-') }}
                </div>
                <div class="mt-1 text-xs font-medium text-slate-600">{{ $educationHistory->status ?: '-' }}</div>
              </div>
            @empty
              <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 p-4 text-sm text-slate-500">
                Belum ada riwayat pendidikan yang diisi.
              </div>
            @endforelse
          </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
          <h2 class="text-base font-semibold text-slate-900">Riwayat Pengalaman Kerja</h2>
          <div class="mt-4 space-y-3">
            @forelse ($workExperiences as $workExperience)
              <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                <div class="text-sm font-semibold text-slate-900">
                  {{ $workExperience->field_of_work ?: '-' }} - {{ $workExperience->company_name ?: '-' }}
                </div>
                <div class="mt-1 text-sm text-slate-600">{{ $workExperience->location ?: '-' }}</div>
                <div class="mt-2 text-xs text-slate-500">
                  {{ $workExperience->date_of_join?->format('d M Y') ?: '-' }} -
                  {{ $workExperience->date_of_resign?->format('d M Y') ?: 'Sekarang' }}
                </div>
                <div class="mt-1 text-xs font-medium text-slate-600">
                  {{ $workExperience->employment_status ?: '-' }} {{ $workExperience->visa_type ? '• ' . $workExperience->visa_type : '' }}
                </div>
              </div>
            @empty
              <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 p-4 text-sm text-slate-500">
                Belum ada riwayat pengalaman kerja yang diisi.
              </div>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  @endif
@endsection
