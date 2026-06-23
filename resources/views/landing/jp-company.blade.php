@extends('layouts.landing')

@push('header')
  <title>NihonSkuy - Daftar Perusahaan Jepang</title>
@endpush

@section('content')
  <section class="px-4 pb-14 pt-10 sm:px-6 sm:pt-14">
    <div class="mx-auto max-w-6xl">
      <div class="text-center">
        <h1 class="mt-5 text-3xl font-semibold tracking-tight text-slate-900 sm:text-5xl">
          Daftar Perusahaan Jepang
        </h1>
        <p class="mx-auto mt-4 max-w-3xl text-sm leading-7 text-slate-600 sm:text-base">
          Daftar perusahaan Jepang yang bekerja sama dengan kami
        </p>
      </div>

      <div class="mt-8 grid gap-3 sm:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
          <div class="text-xs text-slate-500">Perusahaan Terdaftar</div>
          <div class="mt-2 text-2xl font-semibold text-slate-900">{{ count($companies) }}</div>
          <div class="mt-1 text-xs text-slate-500">Perusahaan yang masih aktif bekerja sama</div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
          <div class="text-xs text-slate-500">Wilayah</div>
          <div class="mt-2 text-2xl font-semibold text-slate-900">6 Lokasi</div>
          <div class="mt-1 text-xs text-slate-500">Tokyo, Osaka, Aichi, dan lainnya</div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
          <div class="text-xs text-slate-500">Tampilan</div>
          <div class="mt-2 text-2xl font-semibold text-slate-900">Ringkas</div>
          <div class="mt-1 text-xs text-slate-500">Mudah dipindai dari mobile maupun desktop</div>
        </div>
      </div>
    </div>
  </section>

  <section class="mx-auto max-w-6xl px-4 pb-16 sm:px-6">
    <div class="mb-6 flex flex-col gap-2 text-center">
      <h2 class="text-2xl font-semibold tracking-tight text-slate-900">Perusahaan Tersedia</h2>
      <p class="text-sm text-slate-600">Card dibuat sederhana, rapi, dan mudah dipindai.</p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
      @foreach ($companies as $company)
        <a href="{{ route('jp.company.detail', $company['slug']) }}"
          class="group rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
          <article>
            <div class="flex items-center gap-4">
              <div
                class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-full bg-white shadow-md ring-4 ring-slate-50">
                <img src="{{ asset($company['logo']) }}" alt="{{ $company['name'] }} logo"
                  class="h-full w-full object-cover">
              </div>

              <div class="min-w-0">
                <h3 class="truncate text-lg font-semibold text-slate-900 group-hover:text-slate-700">
                  {{ $company['name'] }}
                </h3>
                <p class="mt-1 text-sm text-slate-500">
                  {{ $company['location'] }}
                </p>
              </div>
            </div>

            <div class="mt-5 flex items-center justify-between border-t border-slate-100 pt-4">
              <span
                class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">
                Detail perusahaan
              </span>
              <span class="text-sm font-medium text-slate-900 transition group-hover:text-slate-700">
                Buka
              </span>
            </div>
          </article>
        </a>
      @endforeach
    </div>
  </section>
@endsection
