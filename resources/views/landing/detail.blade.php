@extends("layouts/landing")

@section("header")

<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Detail Lowongan — {{ $job->title }}</title>

@vite("resources/css/app.css")
@php
$additionalInformationRaw = $job->additional_information;
$additionalInformationDelta = null;

if (is_string($additionalInformationRaw)) {
$decoded = json_decode($additionalInformationRaw, true);

if (is_array($decoded) && isset($decoded['ops']) && is_array($decoded['ops'])) {
$additionalInformationDelta = $decoded;
}
}
@endphp

@if($additionalInformationDelta)
<link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.bubble.css" rel="stylesheet">
@endif

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
<section class="mx-auto max-w-6xl px-4 pb-14 pt-10 sm:px-6 sm:pt-14">
  <div class="flex flex-col gap-6">
    <div class="inline-flex items-center gap-2 text-xs text-slate-600">
      <a href="/" class="rounded-full border border-slate-200 bg-white px-3 py-1 shadow-sm hover:bg-slate-50">Back to Jobs</a>
      <span class="text-slate-400">/</span>
      <span class="font-medium text-slate-700">Detail Job</span>
    </div>

    @php
    $thumbnailUrl = $job->thumbnail_path ? asset('storage/' . $job->thumbnail_path) : null;
    @endphp
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-100">
      @if($thumbnailUrl)
      <img
        src="{{ $thumbnailUrl }}"
        alt="Banner {{ $job->title }}"
        class="h-56 w-full object-cover sm:h-72">
      @else
      <div class="flex h-56 items-center justify-center text-sm text-slate-400 sm:h-72">
        No thumbnail available
      </div>
      @endif
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
      <div class="lg:col-span-2">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-soft">
          <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
              <div class="text-xs text-slate-500">{{ $job->job_code }}</div>
              <h1 class="mt-2 text-2xl font-semibold tracking-tight sm:text-3xl">{{ $job->title }}</h1>
              <p class="mt-1 text-sm text-slate-600">{{ $job->company_name }} • {{ $job->placement }}</p>
            </div>
            <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700">{{ $job->job_type }}</span>
          </div>

          <div class="mt-6 grid gap-3 sm:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
              <div class="text-xs text-slate-500">Gaji</div>
              <div class="mt-1 text-base font-semibold">{{ $formatYen($job->salary) }}</div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
              <div class="text-xs text-slate-500">Kuantitas</div>
              <div class="mt-1 text-base font-semibold">{{ $job->qty }} orang</div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
              <div class="text-xs text-slate-500">Domisili</div>
              <div class="mt-1 text-base font-semibold">
                {{ $job->domicile_requirement === 'kokunai' ? 'Khusus Jepang' : 'Bebas (Di Luar Jepang)' }}
              </div>
            </div>
          </div>

          <div class="mt-5 rounded-2xl border border-slate-200 bg-white p-5">
            <div class="text-sm font-semibold text-slate-900">Informasi Tambahan</div>
            @if($additionalInformationDelta)
            <div id="job-detail-description-viewer" class="mt-2 text-sm leading-relaxed text-slate-700"></div>
            @else
            <p class="mt-2 text-sm leading-relaxed text-slate-700 whitespace-pre-line">
              {!! nl2br(e($job->additional_information)) !!}
            </p>
            @endif
          </div>
        </div>
      </div>

      <aside class="lg:col-span-1">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-soft">
          <div class="text-sm font-semibold">Ringkasan</div>
          <div class="mt-4 space-y-3">
            <div class="flex items-center justify-between text-sm">
              <span class="text-slate-500">Gender</span>
              <span class="font-medium">
                {{ $job->gender_requirement === 'l' ? 'Laki-laki' : 'Perempuan' }}
              </span>
            </div>
            <div class="flex items-center justify-between text-sm">
              <span class="text-slate-500">Penempatan</span>
              <span class="font-medium">{{ $job->placement }}</span>
            </div>
            <div class="flex items-center justify-between text-sm">
              <span class="text-slate-500">Jenis</span>
              <span class="font-medium">{{ $job->job_type }}</span>
            </div>
          </div>

          @php
          $whatsappNumber = preg_replace('/\D+/', '', $job->whatsapp_number ?? '');
          $whatsappLink = $whatsappNumber
          ? 'https://wa.me/' . $whatsappNumber . '?text=' . urlencode(
          'Halo, saya berminat untuk apply job ' . $job->title.' ('.$job->job_code.')'
          )
          : '#';
          @endphp

          <div class="mt-6 grid gap-2">
            <a href="{{ $whatsappLink }}" target="_blank" rel="noopener" class="rounded-xl bg-slate-900 px-4 py-2 text-center text-sm font-medium text-white hover:bg-slate-800">
              Lamar Sekarang
            </a>
            <a href="/" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-center text-sm font-medium text-slate-700 hover:bg-slate-50">
              Kembali ke daftar
            </a>
          </div>

          <div class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <div class="text-xs text-slate-500">Tips</div>
            <div class="mt-1 text-sm text-slate-700">
              Pastikan CV terbaru dan detail pengalaman relevan.
            </div>
          </div>
        </div>
      </aside>
    </div>
  </div>
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
</script>

@if($additionalInformationDelta)
<script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>
<script>
  const landingDetailViewerTarget = document.getElementById("job-detail-description-viewer");
  const landingDetailDelta = @json($additionalInformationDelta);

  const landingDetailQuill = new Quill(landingDetailViewerTarget, {
    theme: "bubble",
    readOnly: true,
    modules: {
      toolbar: false
    }
  });

  landingDetailQuill.setContents(landingDetailDelta);
</script>
@endif
@endsection