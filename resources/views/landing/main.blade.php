<!doctype html>
<html lang="id" class="scroll-smooth">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JobPortal — Temukan Kerja Impianmu</title>

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
      /* Biar background grain halus (opsional, masih minimal) */
      .noise {
        background-image: radial-gradient(rgba(15, 23, 42, 0.05) 1px, transparent 1px);
        background-size: 18px 18px;
      }
    </style>
  </head>

  <body class="bg-slate-50 text-slate-900 antialiased">
    <!-- Top gradient background -->
    <div class="pointer-events-none fixed inset-0 -z-10">
      <div class="absolute left-1/2 top-[-240px] h-[520px] w-[520px] -translate-x-1/2 rounded-full bg-indigo-200/45 blur-3xl"></div>
      <div class="absolute right-[-200px] top-[120px] h-[420px] w-[420px] rounded-full bg-emerald-200/40 blur-3xl"></div>
    </div>

    <!-- Header -->
    <header class="sticky top-0 z-50 border-b border-slate-200/70 bg-white/70 backdrop-blur">
      <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3 sm:px-6">
        <a href="#" class="flex items-center gap-2">
          <div
            class="grid h-9 w-9 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm"
            aria-hidden="true"
          >
            <!-- Minimal logo mark -->
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
              <path
                d="M7 20V10a2 2 0 0 1 2-2h10v12a2 2 0 0 1-2 2H7Z"
                stroke="currentColor"
                stroke-width="1.8"
                class="text-slate-900"
              />
              <path
                d="M5 6h10a2 2 0 0 1 2 2v0"
                stroke="currentColor"
                stroke-width="1.8"
                class="text-slate-900"
                opacity=".6"
              />
              <path
                d="M9 12h6M9 16h6"
                stroke="currentColor"
                stroke-width="1.8"
                class="text-slate-900"
                opacity=".7"
              />
            </svg>
          </div>
          <span class="text-sm font-semibold tracking-tight">JobPortal</span>
        </a>

        <nav class="hidden items-center gap-6 md:flex">
          <a href="#jobs" class="text-sm text-slate-600 hover:text-slate-900">Jobs</a>
          <a href="#about" class="text-sm text-slate-600 hover:text-slate-900">About</a>
          <a href="#testimonials" class="text-sm text-slate-600 hover:text-slate-900">Testimoni</a>
          <a href="#footer" class="text-sm text-slate-600 hover:text-slate-900">Kontak</a>
        </nav>

        <div class="hidden items-center gap-2 md:flex">
          <a
            href="#"
            class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"
            >Masuk</a
          >
          <a
            href="#"
            class="rounded-xl bg-slate-900 px-3 py-2 text-sm font-medium text-white hover:bg-slate-800"
            >Post a Job</a
          >
        </div>

        <button
          id="menuBtn"
          class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white p-2 text-slate-700 hover:bg-slate-50 md:hidden"
          aria-label="Buka menu"
          aria-expanded="false"
        >
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
            <path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
          </svg>
        </button>
      </div>

      <!-- Mobile menu -->
      <div id="mobileMenu" class="hidden border-t border-slate-200 bg-white md:hidden">
        <div class="mx-auto flex max-w-6xl flex-col gap-2 px-4 py-3 sm:px-6">
          <a href="#jobs" class="rounded-lg px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">Jobs</a>
          <a href="#about" class="rounded-lg px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">About</a>
          <a href="#testimonials" class="rounded-lg px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">Testimoni</a>
          <a href="#footer" class="rounded-lg px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">Kontak</a>
          <div class="mt-2 grid grid-cols-2 gap-2">
            <a
              href="#"
              class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-center text-sm font-medium text-slate-700 hover:bg-slate-50"
              >Masuk</a
            >
            <a
              href="#"
              class="rounded-xl bg-slate-900 px-3 py-2 text-center text-sm font-medium text-white hover:bg-slate-800"
              >Post a Job</a
            >
          </div>
        </div>
      </div>
    </header>

    <!-- Hero -->
    <main class="noise">
      <section class="mx-auto max-w-6xl px-4 pb-14 pt-10 sm:px-6 sm:pt-14">
        <div class="grid items-center gap-8 lg:grid-cols-2">
          <!-- Left -->
          <div>
            <div class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-1 text-xs text-slate-700 shadow-sm">
              <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
              <span>Hand-picked jobs • Update harian</span>
            </div>

            <h1 class="mt-4 text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl">
              Temukan kerja impianmu dengan cara yang <span class="text-slate-500">lebih simpel</span>.
            </h1>
            <p class="mt-3 max-w-xl text-base leading-relaxed text-slate-600">
              Job portal minimalis buat yang pengen cepat nemu role yang cocok. Filter jelas, job cards rapi, dan fokus ke hal penting:
              <span class="font-medium text-slate-800">job detail</span>.
            </p>

            <!-- Search box -->
            <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-3 shadow-soft">
              <form class="grid gap-3 sm:grid-cols-2" onsubmit="event.preventDefault();">
                <label class="block">
                  <span class="sr-only">Kata kunci</span>
                  <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" class="text-slate-400">
                      <path
                        d="M21 21l-4.3-4.3m1.8-5.2a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                      />
                    </svg>
                    <input
                      class="w-full bg-transparent text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none"
                      placeholder="Cari: Backend, UI/UX, Data..."
                      type="text"
                    />
                  </div>
                </label>

                <label class="block">
                  <span class="sr-only">Lokasi</span>
                  <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" class="text-slate-400">
                      <path
                        d="M12 22s7-4.4 7-11a7 7 0 1 0-14 0c0 6.6 7 11 7 11Z"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                      />
                      <path
                        d="M12 11.5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                      />
                    </svg>
                    <select class="w-full bg-transparent text-sm text-slate-900 focus:outline-none">
                      <option>Remote</option>
                      <option>Tokyo</option>
                      <option>Osaka</option>
                      <option>Jakarta</option>
                      <option>Hybrid</option>
                    </select>
                  </div>
                </label>

                <div class="sm:col-span-2 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                  <div class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs text-slate-700"
                      >No Japanese required</span
                    >
                    <span class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs text-slate-700"
                      >Apply from overseas</span
                    >
                    <span class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs text-slate-700"
                      >Top companies</span
                    >
                  </div>

                  <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800"
                  >
                    Search Jobs
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                      <path d="M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                      <path d="M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                  </button>
                </div>
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
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
          <div>
            <h2 class="text-2xl font-semibold tracking-tight">Top 6 Jobs</h2>
            <p class="mt-1 text-sm text-slate-600">Pilihan paling relevan minggu ini — rapi, jelas, dan gampang dipindai.</p>
          </div>
          <div class="flex gap-2">
            <button class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">
              Filter
            </button>
            <button class="rounded-xl bg-slate-900 px-3 py-2 text-sm font-medium text-white hover:bg-slate-800">
              Browse all
            </button>
          </div>
        </div>

        <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
          <!-- Job card template -->
          <article class="group rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-soft">
            <div class="flex items-start justify-between gap-3">
              <div class="min-w-0">
                <h3 class="truncate text-base font-semibold">Senior Backend Engineer</h3>
                <p class="mt-1 text-sm text-slate-600">Hikari Tech • Remote</p>
              </div>
              <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-medium text-emerald-700">Open</span>
            </div>
            <div class="mt-3 flex flex-wrap gap-2">
              <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">Go</span>
              <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">gRPC</span>
              <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">Full-time</span>
            </div>
            <div class="mt-4 flex items-center justify-between">
              <div class="text-sm font-semibold">Rp 25–35jt</div>
              <a href="#" class="text-sm font-medium text-slate-900 underline-offset-4 hover:underline">Detail</a>
            </div>
          </article>

          <article class="group rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-soft">
            <div class="flex items-start justify-between gap-3">
              <div class="min-w-0">
                <h3 class="truncate text-base font-semibold">Frontend Engineer</h3>
                <p class="mt-1 text-sm text-slate-600">Sakura Labs • Hybrid (Jakarta)</p>
              </div>
              <span class="rounded-full border border-slate-200 bg-slate-50 px-2.5 py-1 text-[11px] text-slate-700">Hybrid</span>
            </div>
            <div class="mt-3 flex flex-wrap gap-2">
              <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">React</span>
              <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">Tailwind</span>
              <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">Mid</span>
            </div>
            <div class="mt-4 flex items-center justify-between">
              <div class="text-sm font-semibold">Rp 18–28jt</div>
              <a href="#" class="text-sm font-medium text-slate-900 underline-offset-4 hover:underline">Detail</a>
            </div>
          </article>

          <article class="group rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-soft">
            <div class="flex items-start justify-between gap-3">
              <div class="min-w-0">
                <h3 class="truncate text-base font-semibold">UI/UX Designer</h3>
                <p class="mt-1 text-sm text-slate-600">Kumo Studio • Tokyo</p>
              </div>
              <span class="rounded-full bg-indigo-50 px-2.5 py-1 text-[11px] font-medium text-indigo-700">Top</span>
            </div>
            <div class="mt-3 flex flex-wrap gap-2">
              <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">Figma</span>
              <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">Research</span>
              <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">Senior</span>
            </div>
            <div class="mt-4 flex items-center justify-between">
              <div class="text-sm font-semibold">¥6–9M</div>
              <a href="#" class="text-sm font-medium text-slate-900 underline-offset-4 hover:underline">Detail</a>
            </div>
          </article>

          <article class="group rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-soft">
            <div class="flex items-start justify-between gap-3">
              <div class="min-w-0">
                <h3 class="truncate text-base font-semibold">DevOps Engineer</h3>
                <p class="mt-1 text-sm text-slate-600">NamiWorks • Remote</p>
              </div>
              <span class="rounded-full border border-slate-200 bg-slate-50 px-2.5 py-1 text-[11px] text-slate-700">Remote</span>
            </div>
            <div class="mt-3 flex flex-wrap gap-2">
              <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">AWS</span>
              <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">K8s</span>
              <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">SRE</span>
            </div>
            <div class="mt-4 flex items-center justify-between">
              <div class="text-sm font-semibold">Rp 22–32jt</div>
              <a href="#" class="text-sm font-medium text-slate-900 underline-offset-4 hover:underline">Detail</a>
            </div>
          </article>

          <article class="group rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-soft">
            <div class="flex items-start justify-between gap-3">
              <div class="min-w-0">
                <h3 class="truncate text-base font-semibold">Data Analyst</h3>
                <p class="mt-1 text-sm text-slate-600">Minato Corp • Jakarta</p>
              </div>
              <span class="rounded-full border border-slate-200 bg-slate-50 px-2.5 py-1 text-[11px] text-slate-700">Onsite</span>
            </div>
            <div class="mt-3 flex flex-wrap gap-2">
              <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">SQL</span>
              <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">BI</span>
              <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">Entry</span>
            </div>
            <div class="mt-4 flex items-center justify-between">
              <div class="text-sm font-semibold">Rp 9–14jt</div>
              <a href="#" class="text-sm font-medium text-slate-900 underline-offset-4 hover:underline">Detail</a>
            </div>
          </article>

          <article class="group rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-soft">
            <div class="flex items-start justify-between gap-3">
              <div class="min-w-0">
                <h3 class="truncate text-base font-semibold">QA Automation</h3>
                <p class="mt-1 text-sm text-slate-600">Aoi Systems • Osaka</p>
              </div>
              <span class="rounded-full bg-amber-50 px-2.5 py-1 text-[11px] font-medium text-amber-700">Hot</span>
            </div>
            <div class="mt-3 flex flex-wrap gap-2">
              <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">Playwright</span>
              <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">CI/CD</span>
              <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">Mid</span>
            </div>
            <div class="mt-4 flex items-center justify-between">
              <div class="text-sm font-semibold">¥4–7M</div>
              <a href="#" class="text-sm font-medium text-slate-900 underline-offset-4 hover:underline">Detail</a>
            </div>
          </article>
        </div>
      </section>

      <!-- About Us -->
      <section id="about" class="mx-auto max-w-6xl px-4 py-14 sm:px-6">
        <div class="grid items-start gap-10 lg:grid-cols-2">
          <div>
            <h2 class="text-2xl font-semibold tracking-tight">About Us</h2>
            <p class="mt-2 text-sm leading-relaxed text-slate-600">
              Kita ngebangun job portal yang fokus ke <span class="font-medium text-slate-800">clarity</span>:
              job card rapi, CTA jelas, dan trust signals yang gak berisik.
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
                      stroke-linejoin="round"
                    />
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
                      stroke-linecap="round"
                    />
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
                      stroke-linejoin="round"
                    />
                    <path
                      d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                    />
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
              “Gue suka banget karena job cards-nya clean. Scroll cepat, langsung kebayang role & stack-nya.”
            </blockquote>
            <figcaption class="mt-4 flex items-center justify-between">
              <div>
                <div class="text-sm font-semibold">Alya</div>
                <div class="text-xs text-slate-500">Frontend Engineer</div>
              </div>
              <span class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs text-slate-700">Hired</span>
            </figcaption>
          </figure>

          <figure class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <blockquote class="text-sm leading-relaxed text-slate-700">
              “Filter Remote/Hybrid + salary range bikin hemat waktu. Gak perlu buka 20 tab.”
            </blockquote>
            <figcaption class="mt-4 flex items-center justify-between">
              <div>
                <div class="text-sm font-semibold">Raka</div>
                <div class="text-xs text-slate-500">Backend (Go)</div>
              </div>
              <span class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs text-slate-700">Interview</span>
            </figcaption>
          </figure>

          <figure class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <blockquote class="text-sm leading-relaxed text-slate-700">
              “Gaya desainnya kalem, gak capek di mata. CTA-nya juga jelas dan gak maksa.”
            </blockquote>
            <figcaption class="mt-4 flex items-center justify-between">
              <div>
                <div class="text-sm font-semibold">Nadia</div>
                <div class="text-xs text-slate-500">Product Designer</div>
              </div>
              <span class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs text-slate-700">Saved</span>
            </figcaption>
          </figure>
        </div>
      </section>

      <!-- Footer -->
      <footer id="footer" class="border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6">
          <div class="grid gap-8 md:grid-cols-4">
            <div class="md:col-span-2">
              <div class="flex items-center gap-2">
                <div class="grid h-9 w-9 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm" aria-hidden="true">
                  <span class="text-sm font-semibold">JP</span>
                </div>
                <div>
                  <div class="text-sm font-semibold">JobPortal</div>
                  <div class="text-xs text-slate-500">Minimal job portal landing page</div>
                </div>
              </div>
              <p class="mt-4 max-w-md text-sm leading-relaxed text-slate-600">
                Build buat demo/portfolio. Tinggal sambungin ke backend/API buat data jobs beneran.
              </p>

              <form class="mt-5 flex max-w-md gap-2" onsubmit="event.preventDefault();">
                <input
                  type="email"
                  required
                  placeholder="Email untuk job alerts"
                  class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none placeholder:text-slate-400 focus:ring-2 focus:ring-slate-200"
                />
                <button class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">
                  Subscribe
                </button>
              </form>

              <div class="mt-4 flex flex-wrap gap-2 text-xs text-slate-500">
                <span class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1">No spam</span>
                <span class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1">Unsubscribe anytime</span>
              </div>
            </div>

            <div>
              <div class="text-sm font-semibold">Menu</div>
              <ul class="mt-3 space-y-2 text-sm text-slate-600">
                <li><a class="hover:text-slate-900" href="#jobs">Top Jobs</a></li>
                <li><a class="hover:text-slate-900" href="#about">About Us</a></li>
                <li><a class="hover:text-slate-900" href="#testimonials">Testimoni</a></li>
                <li><a class="hover:text-slate-900" href="#">FAQ</a></li>
              </ul>
            </div>

            <div>
              <div class="text-sm font-semibold">Contact</div>
              <ul class="mt-3 space-y-2 text-sm text-slate-600">
                <li><a class="hover:text-slate-900" href="#">hello@jobportal.dev</a></li>
                <li><a class="hover:text-slate-900" href="#">+62 812-0000-0000</a></li>
                <li class="pt-2">
                  <div class="text-xs text-slate-500">Social</div>
                  <div class="mt-2 flex gap-2">
                    <a
                      href="#"
                      class="rounded-xl border border-slate-200 bg-white p-2 text-slate-700 hover:bg-slate-50"
                      aria-label="Twitter"
                      title="Twitter"
                    >
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path
                          d="M20 7.5c-.6.3-1.3.5-2 .6.7-.4 1.2-1.1 1.4-1.9-.7.4-1.4.7-2.2.8A3.3 3.3 0 0 0 11.6 9c0 .3 0 .6.1.8-2.8-.1-5.2-1.5-6.8-3.6-.3.6-.5 1.2-.5 1.9 0 1.1.6 2.2 1.6 2.8-.5 0-1-.2-1.5-.4v.1c0 1.6 1.1 2.9 2.6 3.2-.3.1-.6.1-.9.1-.2 0-.4 0-.6-.1.4 1.4 1.8 2.4 3.3 2.4A6.7 6.7 0 0 1 4 18.5 9.4 9.4 0 0 0 9.1 20c6 0 9.3-5 9.3-9.3v-.4c.6-.5 1.2-1.1 1.6-1.8Z"
                          stroke="currentColor"
                          stroke-width="1.6"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                        />
                      </svg>
                    </a>

                    <a
                      href="#"
                      class="rounded-xl border border-slate-200 bg-white p-2 text-slate-700 hover:bg-slate-50"
                      aria-label="LinkedIn"
                      title="LinkedIn"
                    >
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path
                          d="M6.5 10.5V18M6.5 6.8v.1M10.5 18v-4.2c0-1.2 1-2.2 2.2-2.2 1.2 0 2.2 1 2.2 2.2V18M10.5 10.5V18"
                          stroke="currentColor"
                          stroke-width="1.6"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                        />
                        <path
                          d="M5 5h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z"
                          stroke="currentColor"
                          stroke-width="1.6"
                          stroke-linecap="round"
                        />
                      </svg>
                    </a>

                    <a
                      href="#"
                      class="rounded-xl border border-slate-200 bg-white p-2 text-slate-700 hover:bg-slate-50"
                      aria-label="GitHub"
                      title="GitHub"
                    >
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <path
                          d="M9 19c-4 1.5-4-2-5-2m10 4v-3.2c0-.9.3-1.4.7-1.8-2.2-.2-4.5-1.1-4.5-5 0-1.1.4-2 1-2.7-.1-.3-.4-1.3.1-2.7 0 0 .8-.3 2.7 1a9 9 0 0 1 4.9 0c1.9-1.3 2.7-1 2.7-1 .5 1.4.2 2.4.1 2.7.6.7 1 1.6 1 2.7 0 3.9-2.3 4.8-4.5 5 .4.4.8 1.1.8 2.2V21"
                          stroke="currentColor"
                          stroke-width="1.6"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                        />
                      </svg>
                    </a>
                  </div>
                </li>
              </ul>
            </div>
          </div>

          <div class="mt-10 flex flex-col gap-2 border-t border-slate-200 pt-6 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between">
            <div>© <span id="year"></span> JobPortal. All rights reserved.</div>
            <div class="flex gap-4">
              <a href="#" class="hover:text-slate-700">Privacy</a>
              <a href="#" class="hover:text-slate-700">Terms</a>
              <a href="#" class="hover:text-slate-700">Cookies</a>
            </div>
          </div>
        </div>
      </footer>
    </main>

    <script>
      // Mobile menu toggle
      const btn = document.getElementById("menuBtn");
      const menu = document.getElementById("mobileMenu");

      btn?.addEventListener("click", () => {
        const isOpen = !menu.classList.contains("hidden");
        menu.classList.toggle("hidden");
        btn.setAttribute("aria-expanded", String(!isOpen));
      });

      // Footer year
      document.getElementById("year").textContent = new Date().getFullYear();
    </script>
  </body>
</html>