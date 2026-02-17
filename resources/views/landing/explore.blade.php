@extends("layouts/landing")

@section("header")

<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Semua Lowongan | NihonSkuy</title>

@vite("resources/css/app.css")

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

@section("content")
<section class="mx-auto max-w-6xl px-4 pb-8 pt-10 sm:px-6 sm:pt-14">
  <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-soft sm:p-8">
    <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
      <div>
        <p class="text-xs font-medium uppercase tracking-[0.2em] text-slate-500">Explore Jobs</p>
        <h1 class="mt-2 text-3xl font-semibold tracking-tight sm:text-4xl">Semua Info Lowongan Kerja Jepang</h1>
        <p class="mt-2 text-sm text-slate-600">Temukan lowongan yang cocok berdasarkan posisi, perusahaan, tipe kerja, dan lokasi.</p>
      </div>

      <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700">
        Total lowongan aktif: <span class="font-semibold">{{ number_format($totalJobs) }}</span>
      </div>
    </div>

    <form method="GET" action="/jobs" class="mt-6 grid gap-3 md:grid-cols-[1fr_220px_120px]">
      <label class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" class="text-slate-400">
          <path d="M21 21l-4.3-4.3m1.8-5.2a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
        </svg>
        <input
          name="q"
          value="{{ request('q') }}"
          class="w-full bg-transparent text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none"
          placeholder="Cari posisi, company, tipe kerja..."
          type="text" />
      </label>

      <label class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" class="text-slate-400">
          <path d="M12 22s7-4.4 7-11a7 7 0 1 0-14 0c0 6.6 7 11 7 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
          <path d="M12 11.5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
        </svg>
        <input
          name="location"
          value="{{ request('location') }}"
          class="w-full bg-transparent text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none"
          placeholder="Lokasi (contoh: Tokyo)"
          type="text" />
      </label>

      <button
        type="submit"
        class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">
        Cari
      </button>
    </form>
  </div>
</section>

<section id="jobs" class="mx-auto max-w-6xl px-4 pb-14 sm:px-6">
  <div class="mb-5 flex items-center justify-between">
    <h2 class="text-lg font-semibold tracking-tight">Daftar Lowongan</h2>
    <p class="text-xs text-slate-500">Menampilkan {{ $jobs->count() }} dari {{ number_format($jobs->total()) }} hasil</p>
  </div>

  <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
    @forelse ($jobs as $job)
    <article class="group rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-soft">
      <div class="flex items-start justify-between gap-3">
        <div class="min-w-0">
          <h3 class="truncate text-base font-semibold"><a href="/jobs/{{ $job->job_code }}">{{ $job->title }}</a></h3>
          <p class="mt-1 text-sm text-slate-600">{{ $job->company_name }} • {{ $job->placement }}</p>
        </div>
        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-emerald-50 text-[11px] font-medium text-emerald-700">
          {{ collect(explode(' ', $job->job_type))->map(fn($word) => strtoupper($word[0]))->implode('') }}
        </span>
      </div>

      <div class="mt-3 flex flex-wrap gap-2">
        <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">Domisili: {{ $job->domicile_requirement }}</span>
        <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">Gender: {{ $job->gender_requirement }}</span>
        <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">Qty: {{ $job->qty }}</span>
      </div>

      <div class="mt-4 flex items-center justify-between">
        <div class="text-sm font-semibold">{{ $formatYen($job->salary) }}</div>
        <a href="/jobs/{{ $job->job_code }}" class="text-sm font-medium text-slate-900 underline-offset-4 hover:underline">Detail</a>
      </div>
    </article>
    @empty
    <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-6 text-center text-sm text-slate-600 sm:col-span-2 lg:col-span-3">
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

@section("scripts")
<script>
  const btn = document.getElementById("menuBtn");
  const menu = document.getElementById("mobileMenu");

  btn?.addEventListener("click", () => {
    const isOpen = !menu.classList.contains("hidden");
    menu.classList.toggle("hidden");
    btn.setAttribute("aria-expanded", String(!isOpen));
  });

  const footerYear = document.getElementById("year");
  if (footerYear) {
    footerYear.textContent = new Date().getFullYear();
  }
</script>
@endsection