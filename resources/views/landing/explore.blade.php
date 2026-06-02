@extends('layouts.landing')

@section('header')
  <title>Semua Lowongan | NihonSkuy</title>
@endsection

@section('content')
  @php
    $searchFormId = 'landing-explore-search-form';
  @endphp
  <section class="mx-auto max-w-6xl px-4 pb-8 pt-10 sm:px-6 sm:pt-14">
    <div class="shadow-soft rounded-3xl border border-slate-200 bg-white p-6 sm:p-8">
      <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
        <div>
          <p class="text-xs font-medium uppercase tracking-[0.2em] text-slate-500">Explore Jobs</p>
          <h1 class="mt-2 text-3xl font-semibold tracking-tight sm:text-4xl">Semua Info Lowongan Kerja
            Jepang</h1>
          <p class="mt-2 text-sm text-slate-600">Temukan lowongan yang cocok berdasarkan posisi, tipe
            visa, tipe kerja, dan lokasi.</p>
        </div>
      </div>

      <form method="GET" action="{{ route('vacancies') }}" id="{{ $searchFormId }}"
        class="mt-6 grid gap-2 md:grid-cols-[1fr_220px_120px_auto]">
        @include('landing.partials.advanced-filter-hidden-inputs')
        <label class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
            class="text-slate-400">
            <path d="M21 21l-4.3-4.3m1.8-5.2a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" stroke="currentColor"
              stroke-width="2" stroke-linecap="round" />
          </svg>
          <input name="q" value="{{ request('q') }}"
            class="w-full bg-transparent text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none"
            placeholder="Cari posisi, tipe visa, tipe kerja..." type="text" />
        </label>

        <label>
          <span class="sr-only">Lokasi</span>
          <x-searchable-select :value="request('location')" />
        </label>

        <button type="submit"
          class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">
          Cari
        </button>

        <button type="button" id="open-advanced-filter"
          class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
            <path d="M4 6h16" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            <path d="M7 12h10" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            <path d="M10 18h4" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
          </svg>
          Cari Preferensi Kerjamu
        </button>
      </form>
    </div>
  </section>

  @include('landing.partials.advanced-vacancy-filter-modal', ['searchFormId' => $searchFormId])

  <section id="jobs" class="mx-auto max-w-6xl px-4 pb-14 sm:px-6">
    <div class="mb-5 flex items-center justify-between">
      <h2 class="text-lg font-semibold tracking-tight">Daftar Lowongan</h2>
      <p class="text-xs text-slate-500">Menampilkan {{ $jobs->count() }} dari
        {{ number_format($jobs->total()) }} hasil</p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
      @forelse ($jobs as $job)
        <x-job-card :dataJob="$job" />
      @empty
        <div
          class="rounded-3xl border border-dashed border-slate-300 bg-white p-6 text-center text-sm text-slate-600 sm:col-span-2 lg:col-span-3">
          Lowongan belum tersedia untuk filter yang dipilih.
        </div>
      @endforelse
    </div>

    @if ($jobs->hasPages())
      <div class="mt-8 rounded-2xl border border-slate-200 bg-white px-4 py-3">
        {{ $jobs->onEachSide(1)->links() }}
      </div>
    @endif
  </section>
@endsection

@section('scripts')
  <script>
    const footerYear = document.getElementById("year");
    if (footerYear) {
      footerYear.textContent = new Date().getFullYear();
    }
  </script>
@endsection
