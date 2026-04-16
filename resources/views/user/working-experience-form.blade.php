@extends('layouts.user-dashboard')

@section('title', 'Riwayat Pekerjaan')

@section('content_header', 'Riwayat Pekerjaan')

@section('content_subheader', 'Kelola data pengalaman kerja Anda untuk melengkapi profil.')

@section('content')
  @php
    $inputClass =
        'mt-2 block w-full rounded-xl border bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm placeholder:text-slate-400 focus:outline-none focus:ring-2';
    $labelClass = 'text-sm font-medium text-slate-700';
    $employmentStatusOptions = [
        'permanent' => 'Karyawan Tetap',
        'contract' => 'Karyawan Kontrak',
        'fullTime' => 'Full Time',
        'partTime' => 'Part Time',
        'freelance' => 'Freelance',
    ];
    $visaTypeOptions = [
        'tokuteiGinou' => 'Tokutei Ginou',
        'gijinkoku' => 'Gijinkoku',
        'magang' => 'Magang',
    ];

    $isProfileCompleted = (bool) $profile;
    $isEducationCompleted = $educationHistories->isNotEmpty();
    $isWorkingExperienceCompleted = $workExperiences->isNotEmpty();
    $wizardSteps = [
        [
            'number' => 1,
            'label' => 'Informasi Pribadi',
            'route' => route('user.profile.form'),
            'isActive' => request()->routeIs('user.profile.form'),
            'isCompleted' => $isProfileCompleted,
        ],
        [
            'number' => 2,
            'label' => 'Riwayat Pendidikan',
            'route' => route('user.education-history'),
            'isActive' => request()->routeIs('user.education-history'),
            'isCompleted' => $isEducationCompleted,
        ],
        [
            'number' => 3,
            'label' => 'Riwayat Pekerjaan',
            'route' => route('user.working-experience'),
            'isActive' => request()->routeIs('user.working-experience'),
            'isCompleted' => $isWorkingExperienceCompleted,
        ],
    ];

    $hasValidationError = $errors->any();
    $shouldOpenCreateModal = $hasValidationError && old('formMode') === 'create';
  @endphp

  @if (session('status'))
    <div
      class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
      {{ session('status') }}
    </div>
  @endif

  <nav aria-label="Progress form profile"
    class="mb-5 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
    <ol class="grid grid-cols-1 gap-3 sm:grid-cols-3">
      @foreach ($wizardSteps as $step)
        @php
          $circleClass = 'border-slate-300 text-slate-500';
          $stepLabelClass = 'text-slate-500';

          if ($step['isCompleted']) {
              $circleClass = 'border-emerald-500 bg-emerald-500 text-white';
              $stepLabelClass = 'text-emerald-700';
          } elseif ($step['isActive']) {
              $circleClass = 'border-emerald-500 text-emerald-600';
              $stepLabelClass = 'text-emerald-700';
          }
        @endphp
        <li>
          <a href="{{ $step['route'] }}"
            class="group flex items-center gap-3 rounded-xl border border-transparent px-2 py-2 transition hover:border-slate-200 hover:bg-slate-50">
            <span
              class="{{ $circleClass }} inline-flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full border-2 text-sm font-semibold">
              {{ $step['number'] }}
            </span>
            <span class="{{ $stepLabelClass }} text-sm font-medium">{{ $step['label'] }}</span>
          </a>
        </li>
      @endforeach
    </ol>
  </nav>

  <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
    <header
      class="flex flex-col gap-3 border-b border-slate-200 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
      <div>
        <h2 class="text-base font-semibold text-slate-900">Daftar Riwayat Pekerjaan</h2>
        <p class="text-sm text-slate-500">Anda dapat menambah, mengubah, dan menghapus data pengalaman
          kerja per baris.</p>
      </div>
      <button type="button"
        onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'work-experience-create-modal' }))"
        class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
        Tambah Riwayat Pekerjaan
      </button>
    </header>

    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
          <tr>
            <th
              class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 sm:px-6">
              Bidang Pekerjaan
            </th>
            <th
              class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 sm:px-6">
              Nama Perusahaan
            </th>
            <th
              class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 sm:px-6">
              Lokasi
            </th>
            <th
              class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 sm:px-6">
              Periode
            </th>
            <th
              class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 sm:px-6">
              Status
            </th>
            <th
              class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 sm:px-6">
              Visa
            </th>
            <th
              class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500 sm:px-6">
              Aksi
            </th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 bg-white">
          @forelse ($workExperiences as $workExperience)
            <tr>
              <td class="px-4 py-4 text-sm font-medium text-slate-900 sm:px-6">
                {{ $workExperience->field_of_work }}
              </td>
              <td class="px-4 py-4 text-sm font-medium text-slate-900 sm:px-6">
                {{ $workExperience->company_name }}
              </td>
              <td class="px-4 py-4 text-sm text-slate-700 sm:px-6">{{ $workExperience->location }}
              </td>
              <td class="px-4 py-4 text-sm text-slate-700 sm:px-6">
                <p>{{ optional($workExperience->date_of_join)->format('d M Y') }}</p>
                <p class="text-xs text-slate-500">
                  Resign: {{ optional($workExperience->date_of_resign)->format('d M Y') ?? '-' }}
                </p>
              </td>
              <td class="px-4 py-4 text-sm text-slate-700 sm:px-6">
                {{ $employmentStatusOptions[$workExperience->employment_status] ?? $workExperience->employment_status }}
              </td>
              <td class="px-4 py-4 text-sm text-slate-700 sm:px-6">
                {{ $visaTypeOptions[$workExperience->visa_type] ?? '-' }}
              </td>
              <td class="px-4 py-4 sm:px-6">
                <div class="flex justify-end gap-2">
                  <button type="button"
                    onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'work-experience-edit-{{ $workExperience->id }}' }))"
                    class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-3 py-2 text-xs font-medium text-slate-700 transition hover:bg-slate-50">
                    Edit
                  </button>
                  <form method="POST"
                    action="{{ route('user.working-experience.destroy', $workExperience->id) }}"
                    onsubmit="return confirm('Yakin ingin menghapus data riwayat pekerjaan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                      class="inline-flex items-center justify-center rounded-lg border border-red-300 px-3 py-2 text-xs font-medium text-red-600 transition hover:bg-red-50">
                      Hapus
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="px-4 py-8 text-center text-sm text-slate-500 sm:px-6">
                Belum ada data riwayat pekerjaan. Tambahkan data pertama Anda.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </section>

  <x-modal name="work-experience-create-modal" :show="$shouldOpenCreateModal" maxWidth="2xl" focusable>
    <div class="p-5 sm:p-6">
      <div class="mb-4">
        <h3 class="text-base font-semibold text-slate-900">Tambah Riwayat Pekerjaan</h3>
        <p class="text-sm text-slate-500">Isi data pengalaman kerja baru, lalu simpan untuk
          menambahkan
          ke daftar.</p>
      </div>

      <form method="POST" action="{{ route('user.working-experience.store') }}">
        @csrf
        <input type="hidden" name="formMode" value="create">

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
          <div>
            <label class="{{ $labelClass }}" for="create_fieldOfWork">Bidang Pekerjaan <span
                class="text-red-600">*</span></label>
            <input id="create_fieldOfWork" name="fieldOfWork" type="text"
              value="{{ old('formMode') === 'create' ? old('fieldOfWork') : '' }}"
              class="{{ $inputClass }} @error('fieldOfWork') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror"
              placeholder="Cth: Industri Textile, Pendidikan, Migas, Pertanian">
            @error('fieldOfWork')
              <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="{{ $labelClass }}" for="create_companyName">Nama Perusahaan <span
                class="text-red-600">*</span></label>
            <input id="create_companyName" name="companyName" type="text"
              value="{{ old('formMode') === 'create' ? old('companyName') : '' }}"
              class="{{ $inputClass }} @error('companyName') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror"
              placeholder="">
            @error('companyName')
              <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="{{ $labelClass }}" for="create_location">Lokasi Kerja/Perusahaan <span
                class="text-red-600">*</span></label>
            <input id="create_location" name="location" type="text"
              value="{{ old('formMode') === 'create' ? old('location') : '' }}"
              class="{{ $inputClass }} @error('location') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror"
              placeholder="Masukkan lokasi kerja/perusahaan">
            @error('location')
              <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="{{ $labelClass }}" for="create_visaType">Jenis Visa</label>
            <select id="create_visaType" name="visaType"
              class="{{ $inputClass }} @error('visaType') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror">
              <option value="">Pilih Jenis Visa</option>
              @foreach ($visaTypeOptions as $visaTypeValue => $visaTypeLabel)
                <option value="{{ $visaTypeValue }}" @selected(old('formMode') === 'create' && old('visaType') === $visaTypeValue)>
                  {{ $visaTypeLabel }}
                </option>
              @endforeach
            </select>
            @error('visaType')
              <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="{{ $labelClass }}" for="create_dateOfJoin">Tanggal Bergabung <span
                class="text-red-600">*</span></label>
            <input id="create_dateOfJoin" name="dateOfJoin" type="date"
              value="{{ old('formMode') === 'create' ? old('dateOfJoin') : '' }}"
              class="{{ $inputClass }} @error('dateOfJoin') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror">
            @error('dateOfJoin')
              <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="{{ $labelClass }}" for="create_dateOfResign">Tanggal
              Resign/Berhenti</label>
            <input id="create_dateOfResign" name="dateOfResign" type="date"
              value="{{ old('formMode') === 'create' ? old('dateOfResign') : '' }}"
              class="{{ $inputClass }} @error('dateOfResign') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror">
            @error('dateOfResign')
              <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div class="md:col-span-2">
            <p class="{{ $labelClass }}">Status Kepegawaian <span class="text-red-600">*</span>
            </p>
            <div
              class="@error('employmentStatus') border-red-500 @else border-slate-300 @enderror mt-2 flex flex-wrap items-center gap-4 rounded-xl border px-3 py-2.5">
              @foreach ($employmentStatusOptions as $employmentStatusValue => $employmentStatusLabel)
                <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                  <input type="radio" name="employmentStatus"
                    value="{{ $employmentStatusValue }}"
                    class="h-4 w-4 border-slate-300 text-slate-800 focus:ring-slate-300"
                    @checked(old('formMode') === 'create' && old('employmentStatus') === $employmentStatusValue)>
                  {{ $employmentStatusLabel }}
                </label>
              @endforeach
            </div>
            @error('employmentStatus')
              <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <div class="mt-6 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
          <button type="button"
            onclick="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'work-experience-create-modal' }))"
            class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
            Batal
          </button>
          <button type="submit"
            class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
            Simpan
          </button>
        </div>
      </form>
    </div>
  </x-modal>

  @foreach ($workExperiences as $workExperience)
    @php
      $isCurrentEditModal =
          $hasValidationError &&
          old('formMode') === 'edit' &&
          (int) old('workExperienceId') === $workExperience->id;
      $editModalName = 'work-experience-edit-' . $workExperience->id;
      $editFieldOfWorkValue = $isCurrentEditModal
          ? old('fieldOfWork')
          : $workExperience->field_of_work;
      $editLocationValue = $isCurrentEditModal ? old('location') : $workExperience->location;
      $editDateOfJoinValue = $isCurrentEditModal
          ? old('dateOfJoin')
          : optional($workExperience->date_of_join)->format('Y-m-d');
      $editDateOfResignValue = $isCurrentEditModal
          ? old('dateOfResign')
          : optional($workExperience->date_of_resign)->format('Y-m-d');
      $editEmploymentStatusValue = $isCurrentEditModal
          ? old('employmentStatus')
          : $workExperience->employment_status;
      $editVisaTypeValue = $isCurrentEditModal ? old('visaType') : $workExperience->visa_type;
    @endphp

    <x-modal :name="$editModalName" :show="$isCurrentEditModal" maxWidth="2xl" focusable>
      <div class="p-5 sm:p-6">
        <div class="mb-4">
          <h3 class="text-base font-semibold text-slate-900">Edit Riwayat Pekerjaan</h3>
          <p class="text-sm text-slate-500">Perbarui data pekerjaan pada baris yang dipilih.</p>
        </div>

        <form method="POST"
          action="{{ route('user.working-experience.update', $workExperience->id) }}">
          @csrf
          @method('PUT')
          <input type="hidden" name="formMode" value="edit">
          <input type="hidden" name="workExperienceId" value="{{ $workExperience->id }}">

          <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="md:col-span-2">
              <label class="{{ $labelClass }}"
                for="edit_fieldOfWork_{{ $workExperience->id }}">Bidang
                Pekerjaan <span class="text-red-600">*</span></label>
              <input id="edit_fieldOfWork_{{ $workExperience->id }}" name="fieldOfWork"
                type="text" value="{{ $editFieldOfWorkValue }}"
                class="{{ $inputClass }} @error('fieldOfWork') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror"
                placeholder="Cth: Industri Textile, Pendidikan, Migas, Pertanian">
              @error('fieldOfWork')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label class="{{ $labelClass }}"
                for="edit_location_{{ $workExperience->id }}">Lokasi
                Kerja/Perusahaan <span class="text-red-600">*</span></label>
              <input id="edit_location_{{ $workExperience->id }}" name="location" type="text"
                value="{{ $editLocationValue }}"
                class="{{ $inputClass }} @error('location') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror"
                placeholder="Masukkan lokasi kerja/perusahaan">
              @error('location')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label class="{{ $labelClass }}"
                for="edit_visaType_{{ $workExperience->id }}">Jenis
                Visa</label>
              <select id="edit_visaType_{{ $workExperience->id }}" name="visaType"
                class="{{ $inputClass }} @error('visaType') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror">
                <option value="">Pilih Jenis Visa</option>
                @foreach ($visaTypeOptions as $visaTypeValue => $visaTypeLabel)
                  <option value="{{ $visaTypeValue }}" @selected($editVisaTypeValue === $visaTypeValue)>
                    {{ $visaTypeLabel }}
                  </option>
                @endforeach
              </select>
              @error('visaType')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label class="{{ $labelClass }}"
                for="edit_dateOfJoin_{{ $workExperience->id }}">Tanggal
                Bergabung <span class="text-red-600">*</span></label>
              <input id="edit_dateOfJoin_{{ $workExperience->id }}" name="dateOfJoin"
                type="date" value="{{ $editDateOfJoinValue }}"
                class="{{ $inputClass }} @error('dateOfJoin') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror">
              @error('dateOfJoin')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label class="{{ $labelClass }}"
                for="edit_dateOfResign_{{ $workExperience->id }}">Tanggal
                Resign/Berhenti</label>
              <input id="edit_dateOfResign_{{ $workExperience->id }}" name="dateOfResign"
                type="date" value="{{ $editDateOfResignValue }}"
                class="{{ $inputClass }} @error('dateOfResign') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror">
              @error('dateOfResign')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div class="md:col-span-2">
              <p class="{{ $labelClass }}">Status Kepegawaian <span class="text-red-600">*</span>
              </p>
              <div
                class="@error('employmentStatus') border-red-500 @else border-slate-300 @enderror mt-2 flex flex-wrap items-center gap-4 rounded-xl border px-3 py-2.5">
                @foreach ($employmentStatusOptions as $employmentStatusValue => $employmentStatusLabel)
                  <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                    <input type="radio" name="employmentStatus"
                      value="{{ $employmentStatusValue }}"
                      class="h-4 w-4 border-slate-300 text-slate-800 focus:ring-slate-300"
                      @checked($editEmploymentStatusValue === $employmentStatusValue)>
                    {{ $employmentStatusLabel }}
                  </label>
                @endforeach
              </div>
              @error('employmentStatus')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <div class="mt-6 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
            <button type="button"
              onclick="window.dispatchEvent(new CustomEvent('close-modal', { detail: '{{ $editModalName }}' }))"
              class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
              Batal
            </button>
            <button type="submit"
              class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
              Simpan Perubahan
            </button>
          </div>
        </form>
      </div>
    </x-modal>
  @endforeach
@endsection

@push('scripts')
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
