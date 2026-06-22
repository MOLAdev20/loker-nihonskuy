@extends('layouts.landing')

@push('header')
  <title>NihonSkuy - {{ $company['name'] }}</title>
@endpush

@section('content')
  <section class="mx-auto max-w-6xl px-4 pb-14 pt-5 sm:px-6 sm:pt-14">
    <div class="flex flex-col gap-6">
      <div class="inline-flex items-center gap-2 text-xs text-slate-600">
        <a href="{{ route('home') }}"
          class="rounded-full border border-slate-200 bg-white px-3 py-1 shadow-sm hover:bg-slate-50">Beranda</a>
        <span class="text-slate-400">/</span>
        <a href="{{ route('jp.company') }}"
          class="rounded-full border border-slate-200 bg-white px-3 py-1 shadow-sm hover:bg-slate-50">Perusahaan</a>
        <span class="text-slate-400">/</span>
        <span class="font-medium text-slate-700">{{ $company['name'] }}</span>
      </div>

      <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div
          class="relative overflow-hidden px-6 py-8 sm:px-8 sm:py-10"
          style="background: linear-gradient(135deg, {{ $company['from'] }}15, {{ $company['to'] }}25);">
          <div class="absolute inset-0 opacity-50"
            style="background-image: radial-gradient(rgba(15,23,42,.08) 1px, transparent 1px); background-size: 18px 18px;"></div>

          <div class="relative flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div class="flex items-start gap-5">
              <div
                class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-full bg-white shadow-lg ring-8 ring-white/70">
                <img src="{{ asset($company['logo']) }}" alt="{{ $company['name'] }} logo"
                  class="h-full w-full object-cover">
              </div>
              <div>
                <div class="inline-flex items-center rounded-full border border-slate-200 bg-white px-3 py-1 text-xs font-medium text-slate-600 shadow-sm">
                  Partner Perusahaan Jepang
                </div>
                <h1 class="mt-4 text-3xl font-semibold tracking-tight text-slate-900 sm:text-5xl">
                  {{ $company['name'] }}
                </h1>
                <p class="mt-3 max-w-3xl text-sm leading-7 text-slate-600 sm:text-base">
                  {{ $company['overview'] }}
                </p>
              </div>
            </div>

            <div class="grid gap-3 sm:grid-cols-3 lg:min-w-[26rem] lg:grid-cols-1">
              <div class="rounded-2xl border border-slate-200 bg-white/90 p-4 shadow-sm backdrop-blur">
                <div class="text-xs text-slate-500">Lokasi</div>
                <div class="mt-1 text-sm font-semibold text-slate-900">{{ $company['location'] }}</div>
              </div>
              <div class="rounded-2xl border border-slate-200 bg-white/90 p-4 shadow-sm backdrop-blur">
                <div class="text-xs text-slate-500">Website</div>
                <div class="mt-1 text-sm font-semibold text-slate-900">{{ $company['website'] }}</div>
              </div>
              <div class="rounded-2xl border border-slate-200 bg-white/90 p-4 shadow-sm backdrop-blur">
                <div class="text-xs text-slate-500">Industri</div>
                <div class="mt-1 text-sm font-semibold text-slate-900">{{ $company['industry'] }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
          <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <h2 class="text-xl font-semibold tracking-tight text-slate-900">Profil Perusahaan</h2>
            <p class="mt-3 text-sm leading-7 text-slate-600">
              {{ $company['overview'] }}
            </p>

            <div class="mt-6 grid gap-4 sm:grid-cols-3">
              <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <div class="text-xs text-slate-500">Tahun Berdiri</div>
                <div class="mt-1 text-lg font-semibold text-slate-900">{{ $company['established'] }}</div>
              </div>
              <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <div class="text-xs text-slate-500">Jumlah Pegawai</div>
                <div class="mt-1 text-lg font-semibold text-slate-900">{{ $company['employees'] }}</div>
              </div>
              <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <div class="text-xs text-slate-500">Status</div>
                <div class="mt-1 text-lg font-semibold text-slate-900">Aktif</div>
              </div>
            </div>

            <div class="mt-8">
              <h3 class="text-base font-semibold text-slate-900">Bidang Utama</h3>
              <div class="mt-3 flex flex-wrap gap-2">
                @foreach ($company['specialties'] as $specialty)
                  <span
                    class="inline-flex items-center rounded-full border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600">
                    {{ $specialty }}
                  </span>
                @endforeach
              </div>
            </div>

            <div class="mt-8">
              <h3 class="text-base font-semibold text-slate-900">Fasilitas yang Umum Ditawarkan</h3>
              <div class="mt-3 flex flex-wrap gap-2">
                @foreach ($company['benefits'] as $benefit)
                  <span
                    class="inline-flex items-center rounded-full bg-slate-900 px-3 py-2 text-xs font-semibold text-white">
                    {{ $benefit }}
                  </span>
                @endforeach
              </div>
            </div>
          </div>
        </div>

        <aside class="space-y-6">
          <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="text-sm font-semibold text-slate-900">Ringkasan Cepat</div>
            <div class="mt-4 space-y-4">
              <div class="flex items-start justify-between gap-4">
                <span class="text-sm text-slate-500">Lokasi utama</span>
                <span class="text-right text-sm font-medium text-slate-900">{{ $company['location'] }}</span>
              </div>
              <div class="flex items-start justify-between gap-4">
                <span class="text-sm text-slate-500">Bidang</span>
                <span class="text-right text-sm font-medium text-slate-900">{{ $company['industry'] }}</span>
              </div>
              <div class="flex items-start justify-between gap-4">
                <span class="text-sm text-slate-500">Website</span>
                <span class="text-right text-sm font-medium text-slate-900">{{ $company['website'] }}</span>
              </div>
              <div class="flex items-start justify-between gap-4">
                <span class="text-sm text-slate-500">Tahun berdiri</span>
                <span class="text-right text-sm font-medium text-slate-900">{{ $company['established'] }}</span>
              </div>
            </div>
          </div>

          <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="text-sm font-semibold text-slate-900">Aksi</div>
            <p class="mt-2 text-sm leading-6 text-slate-600">
              Gunakan halaman ini sebagai referensi perusahaan, lalu lanjutkan ke daftar lowongan yang tersedia.
            </p>
            <div class="mt-5 grid gap-3">
              <a href="{{ route('vacancies') }}"
                class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
                Lihat Lowongan
              </a>
              <a href="{{ route('jp.company') }}"
                class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                Kembali ke Daftar Perusahaan
              </a>
            </div>
          </div>
        </aside>
      </div>
    </div>
  </section>
@endsection
