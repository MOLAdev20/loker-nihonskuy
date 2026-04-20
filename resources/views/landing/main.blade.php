@extends('layouts.landing')

@push('header')
  <title>NihonSkuy - Raih Pekerjaan Impianmu di Jepang!</title>
@endpush

<!-- Hero -->
@section('content')
  <section class="px-4 pb-14 pt-10 sm:px-6 sm:pt-14">
    <div class="flex justify-center gap-8 text-center">
      <div class="items-center">
        <h1 class="text-3xl font-semibold tracking-tight text-slate-900 sm:text-5xl">
          Siap Berkarir di Jepang?
          <div class="mt-3 text-2xl text-slate-500">Temukan lebih dari 1000+ lowongan kerja di Jepang
          </div>
        </h1>

        <!-- Search box -->
        <div class="shadow-soft mt-6 rounded-2xl border border-slate-200 bg-white p-3">
          <form method="GET" action="{{ route('vacancies') }}"
            class="flex flex-col justify-center gap-2 sm:flex-row">
            <label>
              <span class="sr-only">Kata kunci</span>
              <div
                class="items-cente flex gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 transition-all focus-within:ring-2 focus-within:ring-slate-300 active:ring-2 active:ring-slate-300 md:w-52">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                  class="text-slate-400">
                  <path d="M21 21l-4.3-4.3m1.8-5.2a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                </svg>
                <input name="q"
                  class="w-full bg-transparent text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none"
                  placeholder="Cari Pekerjaan Apa?" type="text" />
              </div>
            </label>

            <label>
              <x-searchable-select />
            </label>

            <label>
              <button type="submit"
                class="flex w-full cursor-pointer items-center justify-center gap-2 rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white transition-all focus-within:ring-2 focus-within:ring-slate-300 hover:bg-slate-800 active:ring-slate-300 sm:w-auto">
                Cari
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                  <path d="M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                  <path d="M13 6l6 6-6 6" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" />
                </svg>
              </button>
            </label>
          </form>
        </div>

        <!-- Stats -->
        <div class="mt-6 hidden grid-cols-3 gap-3 md:grid">
          <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="text-xs text-slate-500">Kerja Sama Dengan</div>
            <div class="my-2 text-2xl font-semibold">30+</div>
            <div class="text-xs text-slate-500">Perusahaan & TSK Jepang</div>
          </div>
          <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="text-xs text-slate-500">Total Pelamar</div>
            <div class="my-2 text-2xl font-semibold">500+</div>
            <div class="text-xs text-slate-500">Untuk jobseeker</div>
          </div>
          <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="text-xs text-slate-500">Support</div>
            <div class="my-2 text-2xl font-semibold">Full</div>
            <div class="text-xs text-slate-500">CV • Interview</div>
          </div>
        </div>
      </div>

    </div>
  </section>

  @if ($urgentJobs->isNotEmpty())
    <section class="sm:mt-15 mx-auto max-w-6xl px-4 pb-14 sm:px-6">
      <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-center">
        <div class="text-center">
          <h2 class="text-2xl font-semibold tracking-tight">🔥 Dibutuhkan Segera</h2>
          <p class="mt-1 text-sm text-slate-600">Perusahaan ini sedang secepatnya membutuhkan
            kandidat!</p>
        </div>
      </div>

      <div class="urgent-jobs-swiper swiper mt-6">
        <div class="swiper-wrapper pb-2">
          @foreach ($urgentJobs as $urgentJob)
            <div class="swiper-slide h-auto">
              <x-job-card :dataJob="$urgentJob" />
            </div>
          @endforeach
        </div>
      </div>

      <div class="mt-5 flex items-center justify-between">
        <div class="urgent-jobs-swiper-pagination"></div>
        <div class="flex items-center gap-2">
          <button type="button"
            class="urgent-jobs-swiper-prev inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 transition hover:bg-slate-50"
            aria-label="Slide sebelumnya">
            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor"
              stroke-width="2">
              <path d="M15 18l-6-6 6-6" />
            </svg>
          </button>
          <button type="button"
            class="urgent-jobs-swiper-next inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 transition hover:bg-slate-50"
            aria-label="Slide berikutnya">
            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor"
              stroke-width="2">
              <path d="M9 18l6-6-6-6" />
            </svg>
          </button>
        </div>
      </div>
    </section>
  @endif

  <!-- Top 6 Jobs -->
  <section id="jobs" class="mx-auto max-w-6xl px-4 py-14 sm:px-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-center">
      <div class="text-center">
        <h2 class="text-2xl font-semibold tracking-tight">Paling Banyak di Lamar</h2>
        <p class="mt-1 text-sm text-slate-600">Loker yang paling banyak diminati oleh pengguna</p>
      </div>
    </div>

    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
      @forelse ($jobs as $job)
        <x-job-card :dataJob="$job" />
      @empty
        <div
          class="rounded-3xl border border-dashed border-slate-300 bg-white p-6 text-center text-sm text-slate-600 sm:col-span-2 lg:col-span-3">
          Belum ada job yang tersedia.
        </div>
      @endforelse
    </div>
    @if ($jobs->count() > 0)
      <div class="mt-8 flex justify-center">
        <a href="{{ route('vacancies') }}"
          class="rounded-xl bg-slate-900 px-4 py-2 text-center text-sm font-medium text-white hover:bg-slate-800">
          Lihat semua lowongan
        </a>
      </div>
    @endif
  </section>

  <!-- About Us -->
  <section id="about" class="mx-auto max-w-6xl px-4 py-14 sm:px-6">
    <h2 class="text-2xl font-semibold tracking-tight">Tentang Kami</h2>
    <div class="grid items-start gap-10 lg:grid-cols-2">
      <div class="shadow-soft rounded-3xl p-6">
        <img src="./artwork.png" alt="">
      </div>
      <div>
        <p class="mt-2 text-justify leading-relaxed text-slate-600">
          <span class="font-bold">NihonSkuy</span> adalah portal lowongan kerja yang berfokus membantu
          pencari
          kerja di Indonesia menemukan peluang karier di Jepang. Kami percaya proses mencari kerja
          seharusnya
          mudah, cepat, dan transparan. Melalui lowongan yang telah dikurasi dengan informasi lengkap
          mulai dari
          gaji, lokasi, hingga persyaratan domisili serta fitur filter yang memudahkan pencarian, kami
          menghadirkan pengalaman yang lebih efisien dan terarah. Dengan demikian, Anda dapat lebih
          fokus
          mempersiapkan diri untuk meraih karier impian di Jepang.
        </p>

        <div class="mt-6 space-y-3">
          <div class="flex gap-3">
            <div class="mt-0.5 grid h-8 w-8 place-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-badge-check-icon lucide-badge-check">
                <path
                  d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z" />
                <path d="m9 12 2 2 4-4" />
              </svg>
            </div>
            <div>
              <div class="text-sm font-semibold">Lowongan Kerja Aman & Terpercaya</div>
              <div class="text-sm text-slate-600">Info loker sudah dicek dan diverifikasi keasliannya
                oleh tim
                Minskuy</div>
            </div>
          </div>

          <div class="flex gap-3">
            <div class="mt-0.5 grid h-8 w-8 place-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-headset-icon lucide-headset">
                <path
                  d="M3 11h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-5Zm0 0a9 9 0 1 1 18 0m0 0v5a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3Z" />
                <path d="M21 16v2a4 4 0 0 1-4 4h-5" />
              </svg>
            </div>
            <div>
              <div class="text-sm font-semibold">Dukungan dari Tim Nihonskuy 24/7</div>
              <div class="text-sm text-slate-600">Butuh bantuan atau sekedar tanya-tanya? Minskuy
                siap
                membantu</div>
            </div>
          </div>

          <div class="flex gap-3">
            <div class="mt-0.5 grid h-8 w-8 place-items-center">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                class="text-slate-900">
                <path d="M12 8v4l3 3" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round" />
                <path d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" stroke="currentColor"
                  stroke-width="2" stroke-linecap="round" />
              </svg>
            </div>
            <div>
              <div class="text-sm font-semibold">Mudah & Cepat</div>
              <div class="text-sm text-slate-600">Lamar kerja cukup klik sekali, dan Minskuy akan
                mengubungi
                kamu</div>
            </div>
          </div>
        </div>

        <div class="mt-7 flex flex-col gap-2 sm:flex-row">
          <a href="#jobs"
            class="rounded-xl bg-slate-900 px-4 py-2 text-center text-sm font-medium text-white hover:bg-slate-800">
            Mulai cari kerja
          </a>
          <a href="#footer"
            class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-center text-sm font-medium text-slate-700 hover:bg-slate-50">
            Hubungi kami
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section id="testimonials" class="mx-auto max-w-6xl px-4 py-14 sm:px-6">
    <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
      <div>
        <h2 class="text-2xl font-semibold tracking-tight">Testimoni</h2>
        <p class="mt-1 text-sm text-slate-600">Bukan cuma “keren”, tapi beneran ngebantu proses cari
          kerja.</p>
      </div>
      <div class="text-xs text-slate-500">★ 4.8/5 dari 1,200+ review</div>
    </div>

    <div class="mt-8 grid gap-4 md:grid-cols-3">
      <figure class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <blockquote class="text-sm leading-relaxed text-slate-700">
          “Info lowongan Jepang-nya lengkap dan jelas. Dari lokasi, gaji, sampai syarat domisili,
          semuanya kebaca
          tanpa ribet.”
        </blockquote>
        <figcaption class="mt-4 flex items-center justify-between">
          <div>
            <div class="text-sm font-semibold">Rina</div>
            <div class="text-xs text-slate-500">Caregiver Applicant</div>
          </div>
          <span
            class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs text-slate-700">Applied</span>
        </figcaption>
      </figure>

      <figure class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <blockquote class="text-sm leading-relaxed text-slate-700">
          “Portal ini bantu banget buat nyari kerja di Jepang. Bisa bandingin lowongan dari beberapa
          perusahaan
          dengan cepat.”
        </blockquote>
        <figcaption class="mt-4 flex items-center justify-between">
          <div>
            <div class="text-sm font-semibold">Dimas</div>
            <div class="text-xs text-slate-500">Factory Worker Applicant</div>
          </div>
          <span
            class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs text-slate-700">Interview</span>
        </figcaption>
      </figure>

      <figure class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <blockquote class="text-sm leading-relaxed text-slate-700">
          “Proses cari kerja ke Jepang jadi lebih terarah. Ada ringkasan job type, kuota, dan
          penempatan jadi
          gampang milih.”
        </blockquote>
        <figcaption class="mt-4 flex items-center justify-between">
          <div>
            <div class="text-sm font-semibold">Siti</div>
            <div class="text-xs text-slate-500">Restaurant Staff Applicant</div>
          </div>
          <span
            class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs text-slate-700">Hired</span>
        </figcaption>
      </figure>
    </div>
  </section>
@endsection

@section('scripts')
  <script>
    document.getElementById("year").textContent = new Date().getFullYear();
  </script>
@endsection
