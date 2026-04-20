@extends('layouts.admin')

@push('title')
  <title>NihonSkuy - Riwayat Pendidikan User</title>
@endpush

@section('content')
  @php
    $inputClass =
        'mt-2 block w-full rounded-xl border bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm placeholder:text-slate-400 focus:outline-none focus:ring-2';
    $labelClass = 'text-sm font-medium text-slate-700';
    $educationLevels = ['SMP', 'SMK', 'SMA', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'];
    $statusOptions = [
        'graduated' => 'Lulus',
        'studying' => 'Masih Sekolah/Berkuliah',
        'droppedOut' => 'Mengundurkan Diri',
    ];

    $hasValidationError = $errors->any();
    $shouldOpenCreateModal = $hasValidationError && old('formMode') === 'create';
    $canGoNext = $educationHistories->isNotEmpty();
    $displayName = $profile?->full_name ?? $user->name;
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
          <a href="{{ route('admin.users.detail', $user->id) }}" class="hover:text-slate-700">
            Detail User
          </a>
        </li>
        <li class="flex items-center gap-2">
          <span class="text-slate-400">/</span>
          <span class="font-medium text-slate-700">
            Riwayat Pendidikan
          </span>
        </li>
      </ol>
    </nav>
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
          Riwayat Pendidikan User
        </h1>
        <p class="mt-2 text-sm text-slate-500">
          Kelola data pendidikan untuk {{ $displayName }}.
        </p>
      </div>
      <a href="{{ route('admin.users.detail', $user->id) }}"
        class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
        Kembali ke detail user
      </a>
    </div>
  </div>

  @if (session('status'))
    <div
      class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
      {{ session('status') }}
    </div>
  @endif

  <x-form-wizard :steps="$wizardSteps" />

  <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
    <header
      class="flex flex-col gap-3 border-b border-slate-200 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
      <div>
        <h2 class="text-base font-semibold text-slate-900">Daftar Riwayat Pendidikan</h2>
        <p class="text-sm text-slate-500">Anda dapat menambah, mengubah, dan menghapus data pendidikan
          per baris.</p>
      </div>
      <button type="button"
        onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'education-history-create-modal' }))"
        class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
        Tambah Riwayat Pendidikan
      </button>
    </header>

    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
          <tr>
            <th
              class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 sm:px-6">
              Jenjang
            </th>
            <th
              class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 sm:px-6">
              Institusi
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
              class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500 sm:px-6">
              Aksi
            </th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 bg-white">
          @forelse ($educationHistories as $educationHistory)
            <tr>
              <td class="whitespace-nowrap px-4 py-4 text-sm font-medium text-slate-900 sm:px-6">
                {{ $educationHistory->education }}
              </td>
              <td class="px-4 py-4 text-sm text-slate-700 sm:px-6">
                {{ $educationHistory->institution }}</td>
              <td class="px-4 py-4 text-sm text-slate-700 sm:px-6">{{ $educationHistory->location }}
              </td>
              <td class="px-4 py-4 text-sm text-slate-700 sm:px-6">
                <div>
                  <p>{{ optional($educationHistory->date_of_entry)->format('d M Y') }}</p>
                  <p class="text-xs text-slate-500">
                    Lulus:
                    {{ optional($educationHistory->date_of_graduation)->format('d M Y') ?? '-' }}
                  </p>
                  <p class="text-xs text-slate-500">
                    Berhenti:
                    {{ optional($educationHistory->date_of_dropped_out)->format('d M Y') ?? '-' }}
                  </p>
                </div>
              </td>
              <td class="px-4 py-4 text-sm text-slate-700 sm:px-6">
                {{ $statusOptions[$educationHistory->status] ?? $educationHistory->status }}
              </td>
              <td class="px-4 py-4 sm:px-6">
                <div class="flex justify-end gap-2">
                  <button type="button"
                    onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'education-history-edit-{{ $educationHistory->id }}' }))"
                    class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-3 py-2 text-xs font-medium text-slate-700 transition hover:bg-slate-50">
                    Edit
                  </button>

                  <form method="POST"
                    action="{{ route('admin.users.education.destroy', ['id' => $user->id, 'educationHistoryId' => $educationHistory->id]) }}"
                    onsubmit="return confirm('Yakin ingin menghapus data riwayat pendidikan ini?');">
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
                Belum ada data riwayat pendidikan. Tambahkan data pertama Anda.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </section>

  <div
    class="mt-4 flex flex-col-reverse gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:flex-row sm:justify-between sm:p-5">
    <a href="{{ route('admin.users.profile.form', $user->id) }}"
      class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
      Sebelumnya: Informasi Pribadi
    </a>
    @if ($canGoNext)
      <a href="{{ route('admin.users.working-experience.index', $user->id) }}"
        class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
        Selanjutnya: Riwayat Pekerjaan
      </a>
    @else
      <button type="button" disabled
        class="inline-flex cursor-not-allowed items-center justify-center rounded-xl bg-slate-300 px-4 py-2.5 text-sm font-semibold text-white">
        Selanjutnya: Riwayat Pekerjaan
      </button>
    @endif
  </div>

  <x-modal name="education-history-create-modal" :show="$shouldOpenCreateModal" maxWidth="2xl" focusable>
    <div class="p-5 sm:p-6">
      <div class="mb-4">
        <h3 class="text-base font-semibold text-slate-900">Tambah Riwayat Pendidikan</h3>
        <p class="text-sm text-slate-500">Isi data pendidikan baru, lalu simpan untuk menambahkan ke
          daftar.</p>
      </div>

      <form method="POST" action="{{ route('admin.users.education.store', $user->id) }}">
        @csrf
        <input type="hidden" name="formMode" value="create">

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
          <div>
            <label class="{{ $labelClass }}" for="create_education">Jenjang Pendidikan <span
                class="text-red-600">*</span></label>
            <select id="create_education" name="education"
              class="{{ $inputClass }} @error('education') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror">
              <option value="">Pilih Jenjang Pendidikan</option>
              @foreach ($educationLevels as $educationLevel)
                <option value="{{ $educationLevel }}" @selected(old('formMode') === 'create' && old('education') === $educationLevel)>
                  {{ $educationLevel }}
                </option>
              @endforeach
            </select>
            @error('education')
              <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="{{ $labelClass }}" for="create_institution">Nama
              Institusi/Sekolah/Perguruan <span class="text-red-600">*</span></label>
            <input id="create_institution" name="institution" type="text"
              value="{{ old('formMode') === 'create' ? old('institution') : '' }}"
              class="{{ $inputClass }} @error('institution') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror"
              placeholder="Masukkan nama institusi/sekolah/perguruan">
            @error('institution')
              <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="{{ $labelClass }}" for="create_location">Lokasi
              Institusi/Sekolah/Perguruan <span class="text-red-600">*</span></label>
            <input id="create_location" name="location" type="text"
              value="{{ old('formMode') === 'create' ? old('location') : '' }}"
              class="{{ $inputClass }} @error('location') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror"
              placeholder="Masukkan lokasi institusi/sekolah/perguruan">
            @error('location')
              <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="{{ $labelClass }}" for="create_dateOfEntry">Tanggal Masuk <span
                class="text-red-600">*</span></label>
            <input id="create_dateOfEntry" name="dateOfEntry" type="date"
              value="{{ old('formMode') === 'create' ? old('dateOfEntry') : '' }}"
              class="{{ $inputClass }} @error('dateOfEntry') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror">
            @error('dateOfEntry')
              <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="{{ $labelClass }}" for="create_dateOfGraduation">Tanggal Lulus</label>
            <input id="create_dateOfGraduation" name="dateOfGraduation" type="date"
              value="{{ old('formMode') === 'create' ? old('dateOfGraduation') : '' }}"
              class="{{ $inputClass }} @error('dateOfGraduation') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror">
            @error('dateOfGraduation')
              <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="{{ $labelClass }}" for="create_dateOfDroppedOut">Tanggal Berhenti/Putus
              Sekolah
              (Jika ada)</label>
            <input id="create_dateOfDroppedOut" name="dateOfDroppedOut" type="date"
              value="{{ old('formMode') === 'create' ? old('dateOfDroppedOut') : '' }}"
              class="{{ $inputClass }} @error('dateOfDroppedOut') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror">
            @error('dateOfDroppedOut')
              <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div class="md:col-span-2">
            <p class="{{ $labelClass }}">Status <span class="text-red-600">*</span></p>
            <div
              class="@error('status') border-red-500 @else border-slate-300 @enderror mt-2 flex flex-wrap items-center gap-4 rounded-xl border px-3 py-2.5">
              @foreach ($statusOptions as $statusValue => $statusLabel)
                <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                  <input type="radio" name="status" value="{{ $statusValue }}"
                    class="h-4 w-4 border-slate-300 text-slate-800 focus:ring-slate-300"
                    @checked(old('formMode') === 'create' && old('status') === $statusValue)>
                  {{ $statusLabel }}
                </label>
              @endforeach
            </div>
            @error('status')
              <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <div class="mt-6 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
          <button type="button"
            onclick="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'education-history-create-modal' }))"
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

  @foreach ($educationHistories as $educationHistory)
    @php
      $isCurrentEditModal =
          $hasValidationError &&
          old('formMode') === 'edit' &&
          (int) old('educationHistoryId') === $educationHistory->id;
      $editModalName = 'education-history-edit-' . $educationHistory->id;
      $editEducationValue = $isCurrentEditModal ? old('education') : $educationHistory->education;
      $editInstitutionValue = $isCurrentEditModal
          ? old('institution')
          : $educationHistory->institution;
      $editLocationValue = $isCurrentEditModal ? old('location') : $educationHistory->location;
      $editDateOfEntryValue = $isCurrentEditModal
          ? old('dateOfEntry')
          : optional($educationHistory->date_of_entry)->format('Y-m-d');
      $editDateOfGraduationValue = $isCurrentEditModal
          ? old('dateOfGraduation')
          : optional($educationHistory->date_of_graduation)->format('Y-m-d');
      $editDateOfDroppedOutValue = $isCurrentEditModal
          ? old('dateOfDroppedOut')
          : optional($educationHistory->date_of_dropped_out)->format('Y-m-d');
      $editStatusValue = $isCurrentEditModal ? old('status') : $educationHistory->status;
    @endphp

    <x-modal :name="$editModalName" :show="$isCurrentEditModal" maxWidth="2xl" focusable>
      <div class="p-5 sm:p-6">
        <div class="mb-4">
          <h3 class="text-base font-semibold text-slate-900">Edit Riwayat Pendidikan</h3>
          <p class="text-sm text-slate-500">Perbarui data pendidikan pada baris yang dipilih.</p>
        </div>

        <form method="POST"
          action="{{ route('admin.users.education.update', ['id' => $user->id, 'educationHistoryId' => $educationHistory->id]) }}">
          @csrf
          @method('PUT')
          <input type="hidden" name="formMode" value="edit">
          <input type="hidden" name="educationHistoryId" value="{{ $educationHistory->id }}">

          <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
              <label class="{{ $labelClass }}"
                for="edit_education_{{ $educationHistory->id }}">Jenjang
                Pendidikan <span class="text-red-600">*</span></label>
              <select id="edit_education_{{ $educationHistory->id }}" name="education"
                class="{{ $inputClass }} @error('education') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror">
                <option value="">Pilih Jenjang Pendidikan</option>
                @foreach ($educationLevels as $educationLevel)
                  <option value="{{ $educationLevel }}" @selected($editEducationValue === $educationLevel)>
                    {{ $educationLevel }}
                  </option>
                @endforeach
              </select>
              @error('education')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label class="{{ $labelClass }}"
                for="edit_institution_{{ $educationHistory->id }}">Nama Institusi/Sekolah/Perguruan
                <span class="text-red-600">*</span></label>
              <input id="edit_institution_{{ $educationHistory->id }}" name="institution"
                type="text" value="{{ $editInstitutionValue }}"
                class="{{ $inputClass }} @error('institution') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror"
                placeholder="Masukkan nama institusi/sekolah/perguruan">
              @error('institution')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label class="{{ $labelClass }}"
                for="edit_location_{{ $educationHistory->id }}">Lokasi
                Institusi/Sekolah/Perguruan <span class="text-red-600">*</span></label>
              <input id="edit_location_{{ $educationHistory->id }}" name="location" type="text"
                value="{{ $editLocationValue }}"
                class="{{ $inputClass }} @error('location') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror"
                placeholder="Masukkan lokasi institusi/sekolah/perguruan">
              @error('location')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label class="{{ $labelClass }}"
                for="edit_dateOfEntry_{{ $educationHistory->id }}">Tanggal
                Masuk <span class="text-red-600">*</span></label>
              <input id="edit_dateOfEntry_{{ $educationHistory->id }}" name="dateOfEntry"
                type="date" value="{{ $editDateOfEntryValue }}"
                class="{{ $inputClass }} @error('dateOfEntry') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror">
              @error('dateOfEntry')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label class="{{ $labelClass }}"
                for="edit_dateOfGraduation_{{ $educationHistory->id }}">Tanggal Lulus</label>
              <input id="edit_dateOfGraduation_{{ $educationHistory->id }}" name="dateOfGraduation"
                type="date" value="{{ $editDateOfGraduationValue }}"
                class="{{ $inputClass }} @error('dateOfGraduation') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror">
              @error('dateOfGraduation')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label class="{{ $labelClass }}"
                for="edit_dateOfDroppedOut_{{ $educationHistory->id }}">Tanggal Berhenti/Putus
                Sekolah
                (Jika ada)</label>
              <input id="edit_dateOfDroppedOut_{{ $educationHistory->id }}" name="dateOfDroppedOut"
                type="date" value="{{ $editDateOfDroppedOutValue }}"
                class="{{ $inputClass }} @error('dateOfDroppedOut') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror">
              @error('dateOfDroppedOut')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div class="md:col-span-2">
              <p class="{{ $labelClass }}">Status <span class="text-red-600">*</span></p>
              <div
                class="@error('status') border-red-500 @else border-slate-300 @enderror mt-2 flex flex-wrap items-center gap-4 rounded-xl border px-3 py-2.5">
                @foreach ($statusOptions as $statusValue => $statusLabel)
                  <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                    <input type="radio" name="status" value="{{ $statusValue }}"
                      class="h-4 w-4 border-slate-300 text-slate-800 focus:ring-slate-300"
                      @checked($editStatusValue === $statusValue)>
                    {{ $statusLabel }}
                  </label>
                @endforeach
              </div>
              @error('status')
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

@section('scripts')
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection
