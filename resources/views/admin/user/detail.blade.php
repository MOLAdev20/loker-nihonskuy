@extends('layouts.admin')

@push('title')
  <title>NihonSkuy - Detail User</title>
@endpush

@section('content')
  @php
    $profile = $user->userProfile;
    $educationHistories = $user->educationHistories;
    $workExperiences = $user->workExperiences;
    $displayName = $profile?->full_name ?? $user->name;
    $bioText = $profile?->technical_experience;
    $profilePictureUrl = null;

    if ($profile?->profile_picture) {
      $profilePictureValue = $profile->profile_picture;
      $isExternalUrl = str_starts_with($profilePictureValue, 'http://') ||
        str_starts_with($profilePictureValue, 'https://');
      $profilePictureUrl = $isExternalUrl
        ? $profilePictureValue
        : asset('storage/' . ltrim($profilePictureValue, '/'));
    }

    $formatDate = function ($dateValue) {
      return $dateValue ? $dateValue->format('d M Y') : '-';
    };
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
    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm lg:col-span-2">
      <h2 class="mb-4 text-sm font-semibold uppercase tracking-wider text-slate-500">
        Profile Picture
      </h2>

      <div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50">
        @if ($profilePictureUrl)
          <img src="{{ $profilePictureUrl }}" alt="Profile picture {{ $displayName }}"
            class="h-56 w-full object-cover">
        @else
          <div class="grid h-56 place-items-center text-sm font-semibold text-slate-500">
            No Profile Picture
          </div>
        @endif
      </div>

      <form method="POST" action="{{ route('admin.users.profile.upload-photo', $user->id) }}"
        enctype="multipart/form-data" class="mt-4">
        @csrf
        <label for="profilePicture"
          class="mb-2 block text-xs font-semibold uppercase tracking-wider text-slate-500">
          Upload Foto Baru
        </label>
        <input id="profilePicture" name="profilePicture" type="file" accept=".jpg,.jpeg,.png,.webp,image/*"
          class="block w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 file:mr-3 file:rounded-lg file:border-0 file:bg-slate-900 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-slate-800">
        @error('profilePicture')
          <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
        @enderror
        <button type="submit"
          class="mt-3 inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
          Upload Foto
        </button>
      </form>
    </section>

    <div class="space-y-5 lg:col-span-4">
      <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
          <h2 class="text-sm font-semibold uppercase tracking-wider text-slate-500">
            Profile Detail
          </h2>
          <a href="{{ route('admin.users.profile.form', $user->id) }}"
            class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M12 20h9" />
              <path d="m16.5 3.5 4 4L7 21H3v-4L16.5 3.5Z" />
            </svg>
            Ubah Data
          </a>
        </div>

        <div class="mb-3 grid grid-cols-1 gap-3 sm:grid-cols-2">
          <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Name</p>
            <p class="mt-1 text-sm font-medium text-slate-900">{{ $displayName }}</p>
          </div>
          <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Email</p>
            <p class="mt-1 text-sm font-medium text-slate-900">{{ $user->email }}</p>
          </div>
          <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Ref Code</p>
            <p class="mt-1 text-sm font-medium text-slate-900">{{ $user->ref_code ?: '-' }}</p>
          </div>
          <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Status</p>
            @if ($profile)
              <span
                class="mt-1 inline-flex rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">
                Completed
              </span>
            @else
              <span
                class="mt-1 inline-flex rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700">
                Incomplete
              </span>
            @endif
          </div>
        </div>

        <div class="mb-3 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
          <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Bio</p>
          <p class="mt-1 whitespace-pre-line text-sm text-slate-700">
            {{ $bioText ?: 'No data provided.' }}
          </p>
        </div>

        @if ($profile)
          <div class="grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-3">
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
              <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Full Name</p>
              <p class="mt-1 text-sm text-slate-900">{{ $profile->full_name }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
              <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Furigana Name</p>
              <p class="mt-1 text-sm text-slate-900">{{ $profile->furigana_name }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
              <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Birth Date</p>
              <p class="mt-1 text-sm text-slate-900">{{ $formatDate($profile->birth_date) }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
              <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Gender</p>
              <p class="mt-1 text-sm text-slate-900">{{ ucfirst($profile->gender) }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
              <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Height</p>
              <p class="mt-1 text-sm text-slate-900">{{ $profile->height }} cm</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
              <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Weight</p>
              <p class="mt-1 text-sm text-slate-900">{{ $profile->weight }} kg</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
              <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Marital Status</p>
              <p class="mt-1 text-sm text-slate-900">{{ ucfirst($profile->marital_status) }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
              <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Nationality</p>
              <p class="mt-1 text-sm text-slate-900">{{ $profile->nationality }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
              <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Place of Origin</p>
              <p class="mt-1 text-sm text-slate-900">{{ $profile->place_of_origin }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
              <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Religion</p>
              <p class="mt-1 text-sm text-slate-900">{{ $profile->religion }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
              <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Hijab</p>
              <p class="mt-1 text-sm text-slate-900">{{ $profile->is_wearing_hijab }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
              <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Current Visa Type</p>
              <p class="mt-1 text-sm text-slate-900">{{ $profile->current_visa_type }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
              <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Visa Expiry Date</p>
              <p class="mt-1 text-sm text-slate-900">{{ $formatDate($profile->visa_expiry_date) }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
              <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Entry Date</p>
              <p class="mt-1 text-sm text-slate-900">{{ $formatDate($profile->entry_date) }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
              <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">JLPT Level</p>
              <p class="mt-1 text-sm text-slate-900">{{ $profile->jlpt_level }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
              <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Has Driver License</p>
              <p class="mt-1 text-sm text-slate-900">{{ $profile->has_driver_license }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
              <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Work Start Date</p>
              <p class="mt-1 text-sm text-slate-900">{{ $formatDate($profile->work_start_date) }}</p>
            </div>
          </div>

          <div class="mt-3 grid grid-cols-1 gap-3">
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
              <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Current Address</p>
              <p class="mt-1 whitespace-pre-line text-sm text-slate-900">{{ $profile->current_address }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
              <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Prayer Requirement</p>
              <p class="mt-1 whitespace-pre-line text-sm text-slate-900">{{ $profile->prayer_requirement }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
              <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Pork Tolerance</p>
              <p class="mt-1 whitespace-pre-line text-sm text-slate-900">{{ $profile->pork_tolerance }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
              <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Alcohol Tolerance</p>
              <p class="mt-1 whitespace-pre-line text-sm text-slate-900">{{ $profile->alcohol_tolerance }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
              <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Technical Experience</p>
              <p class="mt-1 whitespace-pre-line text-sm text-slate-900">{{ $profile->technical_experience }}</p>
            </div>
          </div>
        @else
          <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 px-4 py-8 text-center text-sm text-slate-500">
            No data provided.
          </div>
        @endif
      </section>

      <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
          <h2 class="text-sm font-semibold uppercase tracking-wider text-slate-500">
            Education History
          </h2>
          <a href="{{ route('admin.users.education.index', $user->id) }}"
            class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M12 20h9" />
              <path d="m16.5 3.5 4 4L7 21H3v-4L16.5 3.5Z" />
            </svg>
            Ubah Data
          </a>
        </div>

        @if ($educationHistories->isNotEmpty())
          <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
              <thead class="bg-slate-50">
                <tr>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Education</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Institution</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Location</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Entry</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Graduation</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Dropped Out</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-200 bg-white text-slate-700">
                @foreach ($educationHistories as $educationHistory)
                  <tr>
                    <td class="whitespace-nowrap px-4 py-3">{{ $educationHistory->education }}</td>
                    <td class="whitespace-nowrap px-4 py-3">{{ $educationHistory->institution }}</td>
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

      <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
          <h2 class="text-sm font-semibold uppercase tracking-wider text-slate-500">
            Work Experience
          </h2>
          <a href="{{ route('admin.users.working-experience.index', $user->id) }}"
            class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M12 20h9" />
              <path d="m16.5 3.5 4 4L7 21H3v-4L16.5 3.5Z" />
            </svg>
            Ubah Data
          </a>
        </div>

        @if ($workExperiences->isNotEmpty())
          <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
              <thead class="bg-slate-50">
                <tr>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Field of Work</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Company Name</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Location</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Date of Join</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Date of Resign</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Employment Status</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Visa Type</th>
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
                    <td class="whitespace-nowrap px-4 py-3">{{ $workExperience->visa_type ?: '-' }}</td>
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
