@extends("layouts/landing")

@section("header")

<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>NihonSkuy - Raih Pekerjaan Impianmu di Jepang!</title>

<!-- Tailwind CDN -->
@vite("resources/css/app.css")

<!-- Tailwind config (opsional) -->
<script>
  tailwind.config = {
    theme: {
      extend: {
        fontFamily: {
          sans: ["ui-sans-serif", "system-ui", "Inter", "Segoe UI", "Roboto", "Arial", "sans-serif"],
        },
        boxShadow: {
          soft: "0 10px 30px rgba(2,6,23,.08)",
        },
      },
    },
  };
</script>

<style>
  .noise {
    background-image: radial-gradient(rgba(15, 23, 42, 0.05) 1px, transparent 1px);
    background-size: 18px 18px;
  }
</style>
@endsection


@php
$formatYen = function ($value) {
$value = (string) $value;
if (preg_match_all('/\d+/', $value, $matches) && count($matches[0]) > 1) {
$parts = array_map(function ($n) {
return '¥' . number_format((int) $n);
}, $matches[0]);
return implode('–', $parts);
}
$num = preg_replace('/\D+/', '', $value);
return $num !== '' ? '¥' . number_format((int) $num) : $value;
};
@endphp

<!-- Hero -->
@section("content")
<section class="px-4 pb-14 pt-10 sm:px-6 sm:pt-14">
  <div class="gap-8 flex justify-center text-center">
    <!-- Left -->
    <div class="items-center">
      <h1 class="text-3xl font-semibold tracking-tight text-slate-900 sm:text-5xl">
        Siap Berkarir di Jepang?
        <div class="text-slate-500 mt-3 text-2xl">Temukan lebih dari 1000+ lowongan kerja di Jepang</div>
      </h1>

      <!-- Search box -->
      <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-3 shadow-soft">
        <form method="GET" action="/jobs" class="flex justify-center gap-3">
          <label>
            <span class="sr-only">Kata kunci</span>
            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" class="text-slate-400">
                <path
                  d="M21 21l-4.3-4.3m1.8-5.2a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round" />
              </svg>
              <input
                name="q"
                class="w-full bg-transparent text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none"
                placeholder="Cari Pekerjaan Apa?"
                type="text" />
            </div>
          </label>

          <label>
            <span class="sr-only">Lokasi</span>
            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" class="text-slate-400">
                <path
                  d="M12 22s7-4.4 7-11a7 7 0 1 0-14 0c0 6.6 7 11 7 11Z"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round" />
                <path
                  d="M12 11.5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round" />
              </svg>
              <select id="japan-pref-filter" name="location" class="w-full bg-transparent text-sm text-slate-900 focus:outline-none">

              </select>
            </div>
          </label>

          <label>
            <button
              type="submit"
              class="flex items-center justify-center gap-2 rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">
              Cari
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                <path d="M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                <path d="M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
              </svg>
            </button>
          </label>
        </form>
      </div>

      <!-- Stats -->
      <div class="mt-6 grid grid-cols-3 gap-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
          <div class="text-xs text-slate-500">Trusted</div>
          <div class="mt-1 text-lg font-semibold">30+</div>
          <div class="text-xs text-slate-500">Company partners</div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
          <div class="text-xs text-slate-500">Biaya</div>
          <div class="mt-1 text-lg font-semibold">0</div>
          <div class="text-xs text-slate-500">Untuk jobseeker</div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
          <div class="text-xs text-slate-500">Support</div>
          <div class="mt-1 text-lg font-semibold">Full</div>
          <div class="text-xs text-slate-500">CV • Interview</div>
        </div>
      </div>
    </div>

  </div>
</section>

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
    <article class="group rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-soft">
      <div class="flex items-start justify-between gap-3">
        <div class="min-w-0">
          <h3 class="truncate text-base font-semibold"><a href="/jobs/{{ $job->job_code }}">{{ $job->title }}</a></h3>
          <p class="mt-1 text-sm text-slate-600">{{ $job->company_name }} • {{ $job->placement }}</p>
        </div>
        <span class="rounded-full flex justify-center items-center bg-emerald-50 h-7 w-7 text-[11px] font-medium text-emerald-700">
          {{ collect(explode(' ', $job->job_type))->map(fn($word) => strtoupper($word[0]))->implode('') }}
        </span>
      </div>
      <div class="mt-3 flex flex-wrap gap-2">
        <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">
          Domisili: {{ $job->domicile_requirement }}
        </span>
        <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">
          Gender: {{ $job->gender_requirement }}
        </span>
        <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">
          Qty: {{ $job->qty }}
        </span>
      </div>
      <div class="mt-4 flex items-center justify-between">
        <div class="text-sm font-semibold">{{ $formatYen($job->salary) }}</div>
        <a href="/jobs/{{ $job->job_code }}" class="text-sm font-medium text-slate-900 underline-offset-4 hover:underline">Detail</a>
      </div>
    </article>
    @empty
    <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-6 text-center text-sm text-slate-600 sm:col-span-2 lg:col-span-3">
      Belum ada job yang tersedia.
    </div>
    @endforelse
  </div>
  @if ($jobs->count() > 0)
  <div class="mt-8 flex justify-center">
    <a
      href="/jobs"
      class="rounded-xl bg-slate-900 px-4 py-2 text-center text-sm font-medium text-white hover:bg-slate-800">
      Lihat semua lowongan
    </a>
  </div>
  @endif
</section>

<!-- About Us -->
<section id="about" class="mx-auto max-w-6xl px-4 py-14 sm:px-6">
  <div class="grid items-start gap-10 lg:grid-cols-2">
    <div>
      <h2 class="text-2xl font-semibold tracking-tight">Tentang Kami</h2>
      <p class="mt-2 text-sm leading-relaxed text-slate-600">
        Layanan job seeker yang menghubungkan kamu dengan perusahaan penyedia lowongan kerja di Jepang.
        Lowongan kerja yang kami tampilkan sudah melalui proses seleksi agar sesuai dengan kebutuhan dan preferensi kamu.
      </p>

      <div class="mt-6 space-y-3">
        <div class="flex gap-3">
          <div class="mt-0.5 grid h-8 w-8 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" class="text-slate-900">
              <path
                d="M20 7l-8.5 10L4 12"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round" />
            </svg>
          </div>
          <div>
            <div class="text-sm font-semibold">Kurasi yang masuk akal</div>
            <div class="text-sm text-slate-600">Bukan sekadar banyak—tapi relevan & mudah dipindai.</div>
          </div>
        </div>

        <div class="flex gap-3">
          <div class="mt-0.5 grid h-8 w-8 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" class="text-slate-900">
              <path
                d="M12 22s7-4 7-11a7 7 0 1 0-14 0c0 7 7 11 7 11Z"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round" />
            </svg>
          </div>
          <div>
            <div class="text-sm font-semibold">Filter jelas</div>
            <div class="text-sm text-slate-600">Remote/Hybrid, level, stack, salary range, dan tipe kerja.</div>
          </div>
        </div>

        <div class="flex gap-3">
          <div class="mt-0.5 grid h-8 w-8 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" class="text-slate-900">
              <path
                d="M12 8v4l3 3"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round" />
              <path
                d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round" />
            </svg>
          </div>
          <div>
            <div class="text-sm font-semibold">Cepat</div>
            <div class="text-sm text-slate-600">Kamu bisa scroll 10–15 job dalam beberapa detik tanpa capek.</div>
          </div>
        </div>
      </div>

      <div class="mt-7 flex flex-col gap-2 sm:flex-row">
        <a href="#jobs" class="rounded-xl bg-slate-900 px-4 py-2 text-center text-sm font-medium text-white hover:bg-slate-800">
          Mulai cari kerja
        </a>
        <a href="#footer" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-center text-sm font-medium text-slate-700 hover:bg-slate-50">
          Hubungi kami
        </a>
      </div>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-soft">
      <div class="flex items-start justify-between gap-3">
        <div>
          <div class="text-xs font-medium text-slate-500">Pencapaian</div>
          <h3 class="mt-1 text-lg font-semibold">Angka yang bikin percaya diri</h3>
        </div>
        <span class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs text-slate-700">2026</span>
      </div>

      <div class="mt-5 grid gap-3 sm:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
          <div class="text-xs text-slate-500">Registered Candidates</div>
          <div class="mt-1 text-2xl font-semibold">12k+</div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
          <div class="text-xs text-slate-500">Hiring Partners</div>
          <div class="mt-1 text-2xl font-semibold">30+</div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
          <div class="text-xs text-slate-500">Interview Scheduled</div>
          <div class="mt-1 text-2xl font-semibold">4.2k+</div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
          <div class="text-xs text-slate-500">Offer Accepted</div>
          <div class="mt-1 text-2xl font-semibold">980+</div>
        </div>
      </div>

      <div class="mt-5 rounded-2xl border border-slate-200 bg-white p-4">
        <div class="flex items-center justify-between">
          <div class="text-sm font-semibold">Kenapa minimalis?</div>
          <div class="text-xs text-slate-500">Less noise, more signal</div>
        </div>
        <p class="mt-2 text-sm leading-relaxed text-slate-600">
          Banyak job portal itu berat karena kebanyakan elemen. Di sini kita fokus: headline jelas, trust badges, job cards rapi, CTA gampang.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- Testimonials -->
<section id="testimonials" class="mx-auto max-w-6xl px-4 py-14 sm:px-6">
  <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
    <div>
      <h2 class="text-2xl font-semibold tracking-tight">Testimoni</h2>
      <p class="mt-1 text-sm text-slate-600">Bukan cuma “keren”, tapi beneran ngebantu proses cari kerja.</p>
    </div>
    <div class="text-xs text-slate-500">★ 4.8/5 dari 1,200+ review</div>
  </div>

  <div class="mt-8 grid gap-4 md:grid-cols-3">
    <figure class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
      <blockquote class="text-sm leading-relaxed text-slate-700">
        “Info lowongan Jepang-nya lengkap dan jelas. Dari lokasi, gaji, sampai syarat domisili, semuanya kebaca tanpa ribet.”
      </blockquote>
      <figcaption class="mt-4 flex items-center justify-between">
        <div>
          <div class="text-sm font-semibold">Rina</div>
          <div class="text-xs text-slate-500">Caregiver Applicant</div>
        </div>
        <span class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs text-slate-700">Applied</span>
      </figcaption>
    </figure>

    <figure class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
      <blockquote class="text-sm leading-relaxed text-slate-700">
        “Portal ini bantu banget buat nyari kerja di Jepang. Bisa bandingin lowongan dari beberapa perusahaan dengan cepat.”
      </blockquote>
      <figcaption class="mt-4 flex items-center justify-between">
        <div>
          <div class="text-sm font-semibold">Dimas</div>
          <div class="text-xs text-slate-500">Factory Worker Applicant</div>
        </div>
        <span class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs text-slate-700">Interview</span>
      </figcaption>
    </figure>

    <figure class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
      <blockquote class="text-sm leading-relaxed text-slate-700">
        “Proses cari kerja ke Jepang jadi lebih terarah. Ada ringkasan job type, kuota, dan penempatan jadi gampang milih.”
      </blockquote>
      <figcaption class="mt-4 flex items-center justify-between">
        <div>
          <div class="text-sm font-semibold">Siti</div>
          <div class="text-xs text-slate-500">Restaurant Staff Applicant</div>
        </div>
        <span class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs text-slate-700">Hired</span>
      </figcaption>
    </figure>
  </div>
</section>
@endsection

@section("scripts")
<script>
  // Mobile menu toggle
  const btn = document.getElementById("menuBtn");
  const menu = document.getElementById("mobileMenu");

  btn?.addEventListener("click", () => {
    const isOpen = !menu.classList.contains("hidden");
    menu.classList.toggle("hidden");
    btn.setAttribute("aria-expanded", String(!isOpen));
  });

  fetch('/japan.json')
    .then(response => response.json())
    .then(data => {
      const select = document.getElementById('japan-pref-filter');
      data.japan_prefectures.forEach(prefecture => {
        const option = document.createElement('option');
        option.value = prefecture;
        option.textContent = prefecture;
        select.appendChild(option);
      });
    });

  // Footer year
  document.getElementById("year").textContent = new Date().getFullYear();
</script>
@endsection
