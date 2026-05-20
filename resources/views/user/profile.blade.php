@extends('layouts.user-dashboard')

@section('title', 'Dashboard User')

@section('content_header', 'Dashboard User')

@section('content_subheader', 'Ringkasan profil, aktivitas lamaran, dan pengaturan akun Anda.')

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
      $personalInfoChunks = array_chunk($personalInfoRows, (int) ceil(count($personalInfoRows) / 2), true);
    @endphp

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-6">
      <div class="lg:col-span-2">
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
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
          <form method="POST" action="{{ route('user.profile.upload-photo') }}" enctype="multipart/form-data"
            class="mt-4 space-y-3">
            @csrf
            <div>
              <label for="profilePicture" class="text-xs font-medium uppercase tracking-wide text-slate-500">
                Upload Foto Baru
              </label>
              <input id="profilePicture" name="profilePicture" type="file" accept=".jpg,.jpeg,.png,.webp,image/*"
                class="@error('profilePicture') border-red-400 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror mt-2 block w-full rounded-xl border bg-white px-3 py-2 text-sm text-slate-900 file:mr-3 file:rounded-lg file:border-0 file:bg-slate-900 file:px-3 file:py-1.5 file:text-xs file:font-medium file:text-white hover:file:bg-slate-800 focus:outline-none focus:ring-2" />
              @error('profilePicture')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
              @enderror
              <p class="mt-1 text-xs text-slate-500">Format: JPG, JPEG, PNG, WEBP. Maksimal 2MB.</p>
            </div>
            <button type="submit"
              class="inline-flex w-full items-center justify-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-800">
              Simpan Foto Profile
            </button>
          </form>
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

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
          <h2 class="text-base font-semibold text-slate-900">Riwayat Pendidikan</h2>
          <div class="mt-4 overflow-x-auto rounded-xl border border-slate-200">
            @forelse ($educationHistories as $educationHistory)
              @if ($loop->first)
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                  <thead class="bg-slate-50">
                    <tr>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Pendidikan</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Institusi</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Lokasi</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Periode</th>
                      <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
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
