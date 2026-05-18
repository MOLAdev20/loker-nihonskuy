@extends('layouts.landing')

@section('header')
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Detail Lowongan — {{ $job->title }}</title>

  @vite('resources/css/app.css')
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

  @if ($additionalInformationDelta)
    <link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.bubble.css" rel="stylesheet">
  @endif

  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ["ui-sans-serif", "system-ui", "Inter", "Segoe UI", "Roboto", "Arial",
              "sans-serif"
            ],
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

@section('content')
  <section class="mx-auto max-w-6xl px-2 pb-14 pt-5 sm:px-6 sm:pt-14">
    <div class="flex flex-col gap-6">
      <div class="inline-flex items-center gap-2 text-xs text-slate-600">
        <a href="/"
          class="rounded-full border border-slate-200 bg-white px-3 py-1 shadow-sm hover:bg-slate-50">Beranda</a>
        <span class="text-slate-400">/</span>
        <span class="font-medium text-slate-700">Detail Lowongan</span>
      </div>

      @php
        $thumbnailUrl = $job->thumbnail_path ? asset('storage/' . $job->thumbnail_path) : null;
      @endphp
      <div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-100">
        @if ($thumbnailUrl)
          <img src="{{ $thumbnailUrl }}" alt="Banner {{ $job->title }}"
            class="aspect-auto w-full object-cover" />
        @else
          <div class="flex aspect-auto w-full items-center justify-center text-sm text-slate-400">
            No thumbnail available
          </div>
        @endif
      </div>

      <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="col-span-1 md:col-span-2">
          <div class="shadow-soft rounded-3xl border border-slate-200 bg-white p-6">
            <div class="flex flex-wrap items-start justify-between gap-4">
              <div>
                <div class="text-xs text-slate-500">{{ $job->job_code }}</div>
                <h1 class="mt-2 text-2xl font-semibold tracking-tight sm:text-3xl">{{ $job->title }}
                </h1>

                <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
                  <div class="flex items-start gap-4 rounded-lg">
                    <div class="rounded-full bg-green-200 p-2">
                      <x-icons.map size="17" />
                    </div>
                    <div>
                      <div>
                        <h3 class="font-bold">Penempatan</h3>
                        <p class="text-sm font-medium">
                          {{ $job->placement . ($job->placement_branch ? ' - ' . $job->placement_branch : '') }}
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="flex items-start gap-4 rounded-lg">
                    <div class="rounded-full bg-green-200 p-2">
                      <x-icons.briefcase size="15" />
                    </div>
                    <div>
                      <div>
                        <h3 class="text-sm font-bold">Bidang Kerja</h3>
                        <p class="text-xs font-medium">{{ $job->job_type }}</p>
                      </div>
                    </div>
                  </div>
                  <div class="flex items-start gap-4 rounded-lg">
                    <div class="rounded-full bg-green-200 p-2">
                      <x-icons.yen size="15" />
                    </div>
                    <div>
                      <div>
                        <h3 class="text-sm font-bold">Gaji</h3>
                        <p class="text-xs font-medium">{{ $job->salary_range }}</p>
                      </div>
                    </div>
                  </div>
                  <div class="flex items-start gap-4 rounded-lg">
                    <div class="rounded-full bg-green-200 p-2">
                      <x-icons.user size="15" />
                    </div>
                    <div>
                      <div>
                        <h3 class="text-sm font-bold">Persyaratan Gender</h3>
                        <p class="text-xs font-medium">{{ $job->gender }}</p>
                      </div>
                    </div>
                  </div>
                  <div class="flex items-start gap-4 rounded-lg">
                    <div class="rounded-full bg-green-200 p-2">
                      <x-icons.map size="15" />
                    </div>
                    <div>
                      <div>
                        <h3 class="text-sm font-bold">Persyaratan Domisili</h3>
                        <p class="text-xs font-medium">{{ $job->domicile }}</p>
                      </div>
                    </div>
                  </div>
                  @if($job->exp_requirement)
                  <div class="flex items-start gap-4 rounded-lg">
                    <div class="rounded-full bg-green-200 p-2">
                      <x-icons.briefcase size="15" />
                    </div>
                    <div>
                      <div>
                        <h3 class="text-sm font-bold">Minimal Pengalaman</h3>
                        <p class="text-xs font-medium">{{ $job->exp_requirement }}</p>
                      </div>
                    </div>
                  </div>
                  @endif
                  <div class="flex items-start gap-4 rounded-lg">
                    <div class="rounded-full bg-green-200 p-2">
                      <x-icons.verifiedCircle size="15" />
                    </div>
                    <div>
                      <div>
                        <h3 class="text-sm font-bold">Persyaratan JLPT</h3>
                        <p class="text-xs font-medium">{{ $job->jlpt_requirement_label }}</p>
                      </div>
                    </div>
                  </div>
                  <div class="flex items-start gap-4 rounded-lg">
                    <div class="rounded-full bg-green-200 p-2">
                      <x-icons.verifiedCircle size="15" />
                    </div>
                    <div>
                      <div>
                        <h3 class="text-sm font-bold">Level Kaiwa</h3>
                        <p class="text-xs font-medium">{{ $job->kaiwa_requirement_label }}</p>
                      </div>
                    </div>
                  </div>
                  <div class="flex items-start gap-4 rounded-lg">
                    <div class="rounded-full bg-green-200 p-2">
                      <x-icons.users size="15" />
                    </div>
                    <div>
                      <div>
                        <h3 class="text-sm font-bold">Jumlah Dibutuhkan</h3>
                        <p class="text-xs font-medium">{{ $job->qty }} Orang</p>
                      </div>
                    </div>
                  </div>
                  <div class="flex items-start gap-4 rounded-lg">
                    <div class="rounded-full bg-green-200 p-2">
                      <x-icons.calendar size="15" />
                    </div>
                    <div>
                      <div>
                        <h3 class="text-sm font-bold">Batas Akhir</h3>
                        <p class="text-xs font-medium">
                          {{ date('j F Y', strtotime($job->expired_at)) }}</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="mt-8 text-sm font-semibold">Benefit & Fasilitas</div>

                <div class="mt-3 flex flex-wrap gap-2" id="benefit">
                  @php
                    $benefits = $job->benefit ? array_filter(explode('|', $job->benefit)) : [];
                  @endphp
                  @if (count($benefits))
                    @foreach ($benefits as $benefit)
                      <span
                        class="inline-block rounded-full border border-slate-200 bg-white px-3 py-2 text-xs font-bold text-slate-600">
                        {{ $benefit }}
                      </span>
                    @endforeach
                  @else
                    <span class="text-xs text-slate-400">Benefit & fasilitas tidak dicantumkan</span>
                  @endif
                </div>
              </div>
            </div>
          </div>

          <div class="mt-6 rounded-xl border border-slate-200 bg-white p-5">
            <div class="font-medium text-slate-900">Informasi Tambahan</div>
            @if ($additionalInformationDelta)
              <div id="job-detail-description-viewer"
                class="mt-2 text-sm leading-relaxed text-slate-700"></div>
            @else
              <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-slate-700">
                {!! nl2br(e($job->additional_information)) !!}
              </p>
            @endif
          </div>

        </div>
        <aside class="col-span-1">
          <div class="shadow-soft rounded-3xl border border-slate-200 bg-white p-6">

            @php
              $whatsappNumber = preg_replace('/\D+/', '', $job->whatsapp_number ?? '');
              $whatsappLink = $whatsappNumber
                  ? 'https://wa.me/' .
                      $whatsappNumber .
                      '?text=' .
                      urlencode(
                          'Halo, saya berminat untuk apply job ' .
                              $job->title .
                              ' (' .
                              $job->job_code .
                              ')',
                      )
                  : '#';
            @endphp

            <div class="mt-6 grid gap-2">
              @if ($job->status)
                <a href="{{ $whatsappLink }}" target="_blank" rel="noopener"
                  class="rounded-xl bg-slate-900 px-4 py-2 text-center text-sm font-medium text-white hover:bg-slate-800">
                  Lamar Sekarang
                </a>
              @else
                <a href="#" rel="noopener"
                  class="rounded-xl bg-slate-400 px-4 py-2 text-center text-sm font-medium text-white hover:bg-slate-800">
                  Lowongan ini sudah tidak tersedia
                </a>
              @endif
              <a href="{{ $job->source ?: '/' }}"
                class="flex items-center justify-center gap-1 rounded-xl border border-blue-200 bg-blue-500 px-4 py-2 text-center text-sm font-medium text-white hover:bg-blue-800"
                @if ($job->source) target="_blank" rel="noopener noreferrer" title="{{ $job->source }}" @endif>
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round"
                  class="lucide lucide-link-icon lucide-link">
                  <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" />
                  <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" />
                </svg>
                <span>Sumber Original</span>
              </a>
            </div>

            {{-- <div class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-4">
              <div class="text-xs text-slate-500">Tips</div>
              <div class="mt-1 text-sm text-slate-700">
                Pastikan CV terbaru dan detail pengalaman relevan.
              </div>
            </div> --}}
          </div>
        </aside>
      </div>
  </section>
@endsection

@section('scripts')
  <script>
    const btn = document.getElementById("menuBtn");
    const menu = document.getElementById("mobileMenu");

    btn?.addEventListener("click", () => {
      const isOpen = !menu.classList.contains("hidden");
      menu.classList.toggle("hidden");
      btn.setAttribute("aria-expanded", String(!isOpen));
    });
  </script>

  @if ($additionalInformationDelta)
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
