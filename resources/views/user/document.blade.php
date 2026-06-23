@extends('layouts.user-dashboard')

@section('title', 'Dokumen')

@section('content_header', 'Dokumen')

@section('content_subheader', 'Kelola lampiran dokumen Anda di satu tempat.')

@section('content')
  @php
    $inputClass =
        'mt-2 block w-full rounded-xl border bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm placeholder:text-slate-400 focus:outline-none focus:ring-2';
    $labelClass = 'text-sm font-medium text-slate-700';
    $shouldOpenUploadModal = $errors->any() && old('formMode') === 'create';
    $totalDocuments = $documents->count();
  @endphp

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

  <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
    <header class="flex flex-col gap-3 border-b border-slate-200 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
      <div>
        <h2 class="text-base font-semibold text-slate-900">Lampiran Dokumen</h2>
        <p class="text-sm text-slate-500">
          Tambahkan dokumen KTP, KK, dan Akte Kelahiran sesuai kebutuhan.
        </p>
      </div>

      <button type="button"
        onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'document-upload-modal' }))"
        class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
        Tambah Dokumen
      </button>
    </header>

    <div class="px-4 py-4 sm:px-6">
      @if ($totalDocuments > 0)
        <div class="grid grid-cols-12 gap-4">
          @foreach ($documents as $document)
            @php
              $extension = strtoupper(pathinfo($document->file, PATHINFO_EXTENSION) ?: '-');
            @endphp

            <article
              class="col-span-12 overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 shadow-sm sm:col-span-6 xl:col-span-3">
              <a href="{{ route('user.document.show', $document->id) }}" target="_blank"
                rel="noopener noreferrer"
                class="block border-b border-slate-200 px-4 py-4 transition hover:bg-slate-100">
                <div class="flex items-start gap-3">
                  <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-slate-900 text-white">
                    <x-icons.fileText size="18" />
                  </div>

                  <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-slate-900">{{ $document->file_type_label }}</p>
                    <p class="mt-1 text-xs text-slate-500">Berkas siap dibuka</p>
                    <p class="mt-2 text-xs font-medium text-slate-600">Format: {{ $extension }}</p>
                  </div>
                </div>
              </a>

              <div class="flex items-center justify-between gap-3 px-4 py-3">
                <a href="{{ route('user.document.show', $document->id) }}" target="_blank"
                  rel="noopener noreferrer"
                  class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-3 py-2 text-xs font-medium text-slate-700 transition hover:bg-slate-100">
                  Lihat
                </a>

                <form method="POST" action="{{ route('user.document.destroy', $document->id) }}"
                  onsubmit="return confirm('Yakin ingin menghapus dokumen {{ $document->file_type_label }} ini?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit"
                    class="inline-flex items-center justify-center gap-1 rounded-lg border border-red-300 px-3 py-2 text-xs font-semibold text-red-600 transition hover:bg-red-50">
                    <x-icons.close size="14" />
                    Hapus
                  </button>
                </form>
              </div>
            </article>
          @endforeach
        </div>
      @else
        <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center">
          <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-900 text-white">
            <x-icons.fileText size="20" />
          </div>
          <h3 class="mt-4 text-base font-semibold text-slate-900">Belum ada dokumen</h3>
          <p class="mt-2 text-sm text-slate-500">
            Tambahkan dokumen pertama Anda menggunakan tombol di atas.
          </p>
        </div>
      @endif
    </div>
  </section>

  <x-modal name="document-upload-modal" :show="$shouldOpenUploadModal" maxWidth="2xl" focusable>
    <div class="p-5 sm:p-6">
      <div class="flex items-center justify-between border-b border-slate-200 pb-3">
        <div>
          <h3 class="text-base font-semibold text-slate-900">Tambah Dokumen</h3>
          <p class="text-sm text-slate-500">Pilih jenis dokumen dan unggah file pendukung.</p>
        </div>
        <button type="button"
          class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 transition hover:bg-slate-50"
          data-modal-close aria-label="Tutup modal">
          <x-icons.close />
        </button>
      </div>

      <form method="POST" action="{{ route('user.document.store') }}" enctype="multipart/form-data" class="mt-5 space-y-4">
        @csrf
        <input type="hidden" name="formMode" value="create">

        <div>
          <label class="{{ $labelClass }}" for="file_type">Jenis Dokumen <span class="text-red-600">*</span></label>
          <select id="file_type" name="file_type"
            class="{{ $inputClass }} @error('file_type') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror">
            <option value="">Pilih jenis dokumen</option>
            @foreach ($documentTypes as $typeValue => $typeLabel)
              <option value="{{ $typeValue }}" @selected(old('file_type') === $typeValue)>{{ $typeLabel }}</option>
            @endforeach
          </select>
          @error('file_type')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label class="{{ $labelClass }}" for="file">File Dokumen <span class="text-red-600">*</span></label>
          <input id="file" name="file" type="file" accept=".pdf,application/pdf"
            class="{{ $inputClass }} file:mr-4 file:rounded-lg file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-slate-800 @error('file') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror">
          <p class="mt-2 text-xs text-slate-500">Format file yang diperbolehkan: PDF.</p>
          @error('file')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-4 sm:flex-row sm:justify-end">
          <button type="button"
            class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
            data-modal-close>
            Batal
          </button>
          <button type="submit"
            class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
            Simpan Dokumen
          </button>
        </div>
      </form>
    </div>
  </x-modal>
@endsection

@push('scripts')
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
