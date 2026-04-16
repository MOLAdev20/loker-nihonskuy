@extends('layouts.user-dashboard')

@section('title', 'Dashboard User')

@section('content_header', 'Dashboard User')

@section('content_subheader', 'Ringkasan profil, aktivitas lamaran, dan pengaturan akun Anda.')

@section('content')
  <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
      <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Status Profil</p>
      <p class="mt-3 text-2xl font-semibold text-slate-900">{{ empty($profile) ? '0%' : '85%' }}</p>
      <p class="mt-1 text-sm text-slate-500">Kelengkapan data diri</p>
    </article>

    <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
      <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Lamaran Aktif</p>
      <p class="mt-3 text-2xl font-semibold text-slate-900">2</p>
      <p class="mt-1 text-sm text-slate-500">Sedang diproses</p>
    </article>

    <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
      <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Interview</p>
      <p class="mt-3 text-2xl font-semibold text-slate-900">1</p>
      <p class="mt-1 text-sm text-slate-500">Terjadwal minggu ini</p>
    </article>

    <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
      <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Notifikasi</p>
      <p class="mt-3 text-2xl font-semibold text-slate-900">3</p>
      <p class="mt-1 text-sm text-slate-500">Perlu tindak lanjut</p>
    </article>
  </div>

  <div class="mt-6 rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div
      class="flex flex-wrap items-start justify-between gap-3 border-b border-slate-200 px-4 py-4 sm:px-6">
      <div>
        <h2 class="text-base font-semibold text-slate-900">Data Diri</h2>
        <p class="text-sm text-slate-500">Informasi utama user ditampilkan di area konten yang
          fleksibel.</p>
      </div>

      <button type="button"
        class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-800"
        data-modal-open="profile-modal">
        <x-icons.fileText size="16" />
        Buka Modal Data Diri
      </button>
    </div>

    <div class="grid grid-cols-1 gap-4 p-4 sm:grid-cols-2 sm:p-6 lg:grid-cols-4">
      <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Nama Lengkap</p>
        <p class="mt-1 text-sm text-slate-900">{{ $profile->nama_lengkap ?? '-' }}</p>
      </div>
      <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Furigana</p>
        <p class="mt-1 text-sm text-slate-900">{{ $profile->furigana ?? '-' }}</p>
      </div>
      <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Jenis Kelamin</p>
        <p class="mt-1 text-sm text-slate-900">{{ $profile->jenis_kelamin ?? '-' }}</p>
      </div>
      <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Status Pernikahan</p>
        <p class="mt-1 text-sm text-slate-900">{{ $profile->status_pernikahan ?? '-' }}</p>
      </div>
    </div>
  </div>

  <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
    <h3 class="text-base font-semibold text-slate-900">Area Konten Dinamis</h3>
    <p class="mt-1 text-sm text-slate-500">Bagian ini disiapkan untuk isi bebas seperti tabel, card,
      atau form lanjutan.</p>

    <div
      class="mt-4 rounded-xl border border-dashed border-slate-300 bg-slate-50 p-5 text-sm text-slate-500">
      Konten placeholder: siap diisi sesuai kebutuhan fitur berikutnya.
    </div>
  </div>
@endsection
