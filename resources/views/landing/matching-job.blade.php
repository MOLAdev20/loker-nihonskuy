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
        <h1 class="mt-4 text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl">
          Buka Peluang Kerja di Jepang dengan Strategi yang Tepat
        </h1>
        <p class="mt-4 text-sm leading-relaxed text-slate-600 sm:text-base">
          Sukses menembus pasar kerja Jepang butuh strategi yang tepat. Dapatkan pendampingan menyeluruh untuk mengoptimalkan profil profesional Anda agar menonjol di mata rekruter, menemukan loker yang tepat sasaran, serta menguasai teknik seleksi khas perusahaan Jepang. Kami pastikan setiap langkah persiapan Anda terarah untuk memaksimalkan peluang diterimanya kontrak kerja (Naite) Anda.
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
      <p class="mt-2 text-sm text-slate-600 sm:text-base">Apa itu program kelas Matching Job?</p>
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

  {{-- Rundowns --}}
  <section class="bg-white py-14">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
      <div class="max-w-2xl">
        <h2 class="text-2xl font-semibold tracking-tight text-slate-900">Rundown Kegiatan Konsultasi</h2>
        <p class="mt-2 text-sm text-slate-600 sm:text-base">Alur kegiatan inti selama program berjalan, disusun berurutan untuk memudahkan peserta mengikuti proses.</p>
      </div>

      @php
        $rundowns = [
            [
                'day' => 'Hari 1',
                'title' => 'Japan Job Market & TSK Ecosystem',
                'items' => [
                    'Edukasi jenis-jenis loker di Jepang (SSW, Magang, Engineering).',
                    'Bedah ekosistem TSK (Registered Support Organization) dan hak pekerja.',
                ],
            ],
            [
                'day' => 'Hari 2',
                'title' => 'TSK Database & Market Research',
                'items' => [
                    'Akses ke Informasi Database 12.000 TSK Jepang.',
                    'Teknik memfilter TSK berdasarkan prefektur dan bidang pekerjaan.',
                ],
            ],
            [
                'day' => 'Hari 3',
                'title' => 'Japanese Standard CV Workshop',
                'items' => [
                    'Edukasi pembuatan CV & Rirekisho standar industri Jepang.',
                    'Workshop digitalisasi dan pemeliharaan dokumen agar siap kirim.',
                ],
            ],
            [
                'day' => 'Hari 4',
                'title' => 'Time Management & Professional Correspondence',
                'items' => [
                    'Sesi Mind Mapping Time & Email: Mengatur jadwal apply dan template email profesional.',
                    'Dukungan konsultasi email (Copywriting lamaran agar dilirik HR).',
                ],
            ],
            [
                'day' => 'Hari 5',
                'title' => 'Interview Etiquette & Mindset',
                'items' => [
                    'Edukasi etika interview (aisatsu, ojigi) dan mindset menjawab pertanyaan user Jepang.',
                ],
            ],
            [
                'day' => 'Hari 6',
                'title' => 'Mock Interview I: Self-Introduction',
                'items' => [
                    'Latihan interview profesional ke-1 (Perkenalan diri & motivasi).',
                    'Feedback langsung dan perbaikan kelemahan.',
                ],
            ],
            [
                'day' => 'Hari 7',
                'title' => 'Mock Interview II & III: Technical Q&A',
                'items' => [
                    'Latihan interview profesional ke-2 & ke-3 (Studi kasus dan pertanyaan teknis).',
                    'Optimasi jawaban berdasarkan pengalaman kerja peserta.',
                ],
            ],
            [
                'day' => 'Hari 8',
                'title' => 'Mock Interview IV & V: Final Assessment',
                'items' => [
                    'Latihan interview profesional ke-4 & ke-5 (Simulasi final).',
                    'Konsultasi khusus mengenai kendala spesifik peserta.',
                ],
            ],
            [
                'day' => 'Hari 9',
                'title' => 'Active Job Application & TSK Consultation',
                'items' => [
                    'Praktik kirim lamaran masif ke database TSK yang sudah dipilih.',
                    'Dukungan konsultasi TSK: Cara berkomunikasi efektif dengan staf TSK di Jepang.',
                ],
            ],
            [
                'day' => 'Hari 10',
                'title' => 'Follow-up Strategy & Progress Tracking',
                'items' => [
                    'Edukasi teknik Follow up lamaran yang sudah dikirim ke TSK agar tidak "ghosting".',
                    'Final Review: Pemeriksaan seluruh kesiapan mental dan administrasi sebelum masuk ke fase rekrutmen nyata.',
                ],
            ],
        ];
      @endphp

      <div class="rundown-swiper swiper mt-8">
        <div class="swiper-wrapper pb-2">
          @foreach ($rundowns as $rundown)
            <div class="swiper-slide h-auto">
              <article class="relative h-full pt-9">
                <div
                  class="absolute top-3 h-0.5 bg-slate-300 {{ $loop->first ? 'left-1/2 right-0' : ($loop->last ? 'left-0 right-1/2' : 'left-0 right-0') }}">
                </div>
                <div
                  class="absolute left-1/2 top-3 h-4 w-4 -translate-x-1/2 -translate-y-1/2 rounded-full border-2 border-white bg-slate-900 shadow-sm animate-pulse">
                </div>

                <div class="mx-2 flex h-full flex-col rounded-2xl border border-slate-200 bg-slate-50 p-5">
                  <div
                    class="inline-flex w-fit rounded-full border border-slate-300 bg-white px-3 py-1 text-xs font-semibold text-slate-700">
                    {{ $rundown['day'] }}
                  </div>
                  <h3 class="mt-3 text-base font-semibold tracking-tight text-slate-900">{{ $rundown['title'] }}</h3>
                  <ul class="mt-4 space-y-3 text-sm leading-relaxed text-slate-600">
                    @foreach ($rundown['items'] as $item)
                      <li class="flex items-start gap-2">
                        <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-slate-400"></span>
                        <span>{{ $item }}</span>
                      </li>
                    @endforeach
                  </ul>
                </div>
              </article>
            </div>
          @endforeach
        </div>
      </div>

      <div class="mt-5 flex items-center justify-between">
        <div class="rundown-swiper-pagination"></div>
        <div class="flex items-center gap-2">
          <button type="button"
            class="rundown-swiper-prev inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 transition hover:bg-slate-50"
            aria-label="Slide sebelumnya">
            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor"
              stroke-width="2">
              <path d="M15 18l-6-6 6-6" />
            </svg>
          </button>
          <button type="button"
            class="rundown-swiper-next inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 transition hover:bg-slate-50"
            aria-label="Slide berikutnya">
            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor"
              stroke-width="2">
              <path d="M9 18l6-6-6-6" />
            </svg>
          </button>
        </div>
      </div>
    </div>
  </section>
  {{-- End of Rundowns --}}

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
