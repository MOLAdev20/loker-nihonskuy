@extends('layouts.landing')

@push('header')
  <title>NihonSkuy - Kelas Konsultasi Matching Job Jepang</title>
@endpush

@section('content')
  <section class="relative overflow-hidden px-4 pb-14 pt-10 sm:px-6 sm:pt-14">
    <div class="pointer-events-none absolute inset-0 -z-10">
      <div class="absolute -left-20 top-0 h-56 w-56 rounded-full bg-slate-200/60 blur-3xl"></div>
      <div class="absolute -right-24 bottom-0 h-72 w-72 rounded-full bg-emerald-100/70 blur-3xl"></div>
    </div>

    <div class="mx-auto grid max-w-6xl items-center gap-8 lg:grid-cols-2">
      <div>
        <p class="inline-flex rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-emerald-700">
          Kelas Konsultasi Matching Job Jepang
        </p>
        <h1 class="mt-4 text-3xl font-semibold tracking-tight text-slate-900 sm:text-5xl">
          Buka Peluang Kerja di Jepang dengan Strategi yang Tepat
        </h1>
        <p class="mt-4 text-sm leading-relaxed text-slate-600 sm:text-base">
          Dapatkan pendampingan terarah untuk menyiapkan profil, memilih lowongan yang sesuai, dan meningkatkan peluang lolos seleksi perusahaan Jepang.
        </p>

        <div class="mt-7 flex flex-col gap-3 sm:flex-row">
          <a href="{{ $whatsappUrl }}"
            class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
            Konsultasi via WhatsApp
          </a>
          <a href="#pricing"
            class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
            Lihat Paket
          </a>
        </div>
      </div>

      <div class="relative mx-auto w-full max-w-md lg:max-w-lg">
        <div class="pointer-events-none absolute inset-x-10 bottom-0 h-24 rounded-full bg-slate-300/50 blur-2xl"></div>
        <img
          src="{{ asset('mj.png') }}"
          alt="Model profesional untuk ilustrasi kelas konsultasi kerja di Jepang"
          class="relative z-10 mx-auto w-full object-contain mix-blend-multiply"
          loading="lazy" />
      </div>
    </div>
  </section>

  <section class="mx-auto max-w-6xl px-4 py-14 sm:px-6">
    <div class="max-w-2xl">
      <h2 class="text-2xl font-semibold tracking-tight text-slate-900">Informasi Program</h2>
      <p class="mt-2 text-sm text-slate-600 sm:text-base">Rangkuman materi penting agar peserta memahami arah konsultasi sejak awal.</p>
    </div>
    <p class="mt-6 max-w-4xl text-sm leading-relaxed text-slate-600 sm:text-base">
      {{ $programIntroduction }}
    </p>

    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
      @foreach ($infoSections as $infoSection)
        <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
          <h3 class="text-lg font-semibold tracking-tight text-slate-900">{{ $infoSection['title'] }}</h3>
          <p class="mt-3 text-sm leading-relaxed text-slate-600">{{ $infoSection['description'] }}</p>
        </article>
      @endforeach
    </div>
  </section>

  <section class="bg-white py-14">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
      <div class="max-w-2xl">
        <h2 class="text-2xl font-semibold tracking-tight text-slate-900">Rundown Kegiatan Konsultasi</h2>
        <p class="mt-2 text-sm text-slate-600 sm:text-base">Alur kegiatan inti selama program berjalan, disusun berurutan untuk memudahkan peserta mengikuti proses.</p>
      </div>

      <div class="mt-8 overflow-x-auto pb-2">
        <div class="relative min-w-[920px] px-2">
          <div class="absolute left-16 right-16 top-5 h-0.5 bg-slate-300"></div>
          <div class="grid grid-cols-4 gap-5">
            @foreach ($timelines as $timeline)
              <article class="relative pt-10">
                <div class="absolute left-1/2 top-2 h-6 w-6 -translate-x-1/2 rounded-full border-4 border-white bg-slate-900 shadow-sm"></div>
                <div class="h-full rounded-2xl border border-slate-200 bg-slate-50 p-5">
                  <h3 class="text-sm font-semibold text-slate-900 sm:text-base">{{ $timeline['title'] }}</h3>
                  <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $timeline['description'] }}</p>
                </div>
              </article>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="pricing" class="mx-auto max-w-6xl px-4 py-14 sm:px-6">
    <div class="text-center">
      <h2 class="text-2xl font-semibold tracking-tight text-slate-900">Pilih Paket Konsultasi</h2>
      <p class="mx-auto mt-2 max-w-2xl text-sm text-slate-600 sm:text-base">Tiga pilihan paket untuk menyesuaikan kebutuhan pendampingan kerja di Jepang.</p>
    </div>

    <div class="mt-8 grid gap-4 lg:grid-cols-3">
      @foreach ($packages as $package)
        <article class="relative overflow-hidden rounded-3xl border bg-white p-6 shadow-sm {{ $package['highlight'] ? 'border-slate-900' : 'border-slate-200' }}">
          @if ($package['badge'])
            <div class="absolute inset-x-0 top-0 bg-slate-900 py-2 text-center text-xs font-semibold uppercase tracking-wider text-white">
              {{ $package['badge'] }}
            </div>
          @endif

          <div class="{{ $package['badge'] ? 'pt-8' : '' }}">
            <h3 class="text-2xl font-semibold tracking-tight text-slate-900">{{ $package['name'] }}</h3>
            <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $package['description'] }}</p>
            <p class="mt-6 text-3xl font-semibold tracking-tight text-slate-900">{{ $package['price'] }}</p>
          </div>

          <a href="{{ $whatsappUrl }}"
            class="mt-6 inline-flex w-full items-center justify-center rounded-full bg-slate-900 px-4 py-2.5 text-xl font-semibold tracking-wide text-white transition hover:bg-slate-800">
            {{ $package['ctaLabel'] }}
          </a>

          <ul class="mt-5 space-y-3 text-sm text-slate-700">
            @foreach ($package['benefits'] as $benefit)
              <li class="flex items-start gap-2">
                <svg viewBox="0 0 24 24" class="mt-0.5 h-4 w-4 shrink-0 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M20 6 9 17l-5-5" />
                </svg>
                <span>{{ $benefit }}</span>
              </li>
            @endforeach
          </ul>

          @if ($package['promoNote'])
            <p class="mt-8 text-center text-sm font-semibold text-slate-900">{{ $package['promoNote'] }}</p>
          @endif

          @if (count($package['disclaimerLines']) > 0)
            <div class="mt-6 rounded-3xl border border-slate-300 bg-slate-50 p-4 text-sm leading-relaxed text-slate-700">
              @foreach ($package['disclaimerLines'] as $disclaimerLine)
                <p>{{ $loop->last ? $disclaimerLine : '* ' . $disclaimerLine }}</p>
              @endforeach
            </div>
          @endif
        </article>
      @endforeach
    </div>
  </section>

  <section class="mx-auto max-w-4xl px-4 py-14 sm:px-6">
    <div class="text-center">
      <h2 class="text-2xl font-semibold tracking-tight text-slate-900">FAQ</h2>
      <p class="mt-2 text-sm text-slate-600 sm:text-base">Pertanyaan yang paling sering ditanyakan sebelum mengikuti kelas konsultasi.</p>
    </div>

    <div class="mt-8 space-y-3">
      @foreach ($faqs as $faq)
        <details class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
          <summary class="flex cursor-pointer list-none items-start justify-between gap-4 text-left text-sm font-semibold text-slate-900 sm:text-base">
            <span>{{ $faq['question'] }}</span>
            <span class="mt-0.5 text-slate-500 transition group-open:rotate-45">+</span>
          </summary>
          <p class="mt-3 text-sm leading-relaxed text-slate-600">
            {{ $faq['answer'] }}
          </p>
        </details>
      @endforeach
    </div>
  </section>

  <section class="pb-16">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
      <div class="rounded-3xl bg-slate-900 p-8 text-center sm:p-10">
        <h2 class="text-2xl font-semibold tracking-tight text-white">Siap Mulai Persiapan Karier di Jepang?</h2>
        <p class="mx-auto mt-3 max-w-2xl text-sm leading-relaxed text-slate-200 sm:text-base">
          Hubungi tim NihonSkuy melalui WhatsApp untuk diskusi kebutuhanmu dan pilih paket konsultasi yang paling sesuai.
        </p>
        <a href="{{ $whatsappUrl }}"
          class="mt-6 inline-flex items-center justify-center rounded-xl bg-white px-6 py-3 text-sm font-semibold text-slate-900 transition hover:bg-slate-100">
          Chat WhatsApp Sekarang
        </a>
      </div>
    </div>
  </section>
@endsection
