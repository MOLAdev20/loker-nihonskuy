@extends("layouts/landing")

@push("header")
<title>NihonSkuy - Raih Pekerjaan Impianmu di Jepang!</title>
@endpush

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
        <form method="GET" action="/jobs" class="flex flex-col sm:flex-row justify-center gap-2">

          <label>
            <span class="sr-only">Kata kunci</span>
            <div class="flex items-cente md:w-52 gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 active:ring-2 active:ring-slate-300 focus-within:ring-2 focus-within:ring-slate-300 transition-all">
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
            <div id="select-location" class="relative md:w-52 flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 active:ring-slate-300 focus-within:ring-2 focus-within:ring-slate-300 transition-all hover:bg-slate-50">
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
              <div class="w-full" id="japan-pref-wrapper">
                <input type="hidden" id="japan-pref-value" name="location" value="">
                <button
                  type="button"
                  id="japan-pref-toggle"
                  class="flex w-full items-center justify-between gap-2 bg-transparent text-sm text-slate-900 focus:outline-none cursor-pointer"
                  aria-haspopup="listbox"
                  aria-expanded="false">
                  <span id="japan-pref-label" class="text-slate-400">Semua prefektur</span>
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" class="text-slate-400">
                    <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                  </svg>
                </button>
              </div>
              <div
                id="japan-pref-panel"
                class="absolute left-0 right-0 top-full z-20 mt-2 hidden rounded-xl border border-slate-200 bg-white p-2 shadow-soft">
                <input
                  id="japan-pref-search"
                  type="text"
                  placeholder="Cari prefektur..."
                  class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200" />
                <ul
                  id="japan-pref-list"
                  class="mt-2 max-h-56 overflow-auto text-sm text-slate-900"
                  role="listbox"
                  aria-label="Daftar prefektur">
                </ul>
              </div>
            </div>
          </label>

          <label>
            <button
              type="submit"
              class="flex sm:w-auto w-full items-center justify-center gap-2 rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800 active:ring-slate-300 focus-within:ring-2 focus-within:ring-slate-300 transition-all cursor-pointer">
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
      <div class="mt-6 hidden md:grid grid-cols-3 gap-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
          <div class="text-xs text-slate-500">Telah Dipercaya</div>
          <div class="mt-1 text-lg font-semibold">30+</div>
          <div class="text-xs text-slate-500">Perusahaan & TSK Jepang</div>
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
          <p class="mt-1 text-sm text-slate-600 flex items-center gap-2"><x-icons.map size="15" />{{ $job->placement }}</p>
          <p class="mt-1 text-sm text-slate-600 flex items-center gap-2"><x-icons.folderInput size="15" />{{ $job->visa_type }}</p>
        </div>
      </div>
      <div class="border-t border-dashed border-slate-300 mt-3">
        <div class="mt-1">
          <p class="text-xs text-slate-600">Syarat & Benefit</p>
          <div class="flex flex-wrap gap-2 mt-2">
            <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">
              {{ $job->domicile_requirement == "kokunai" ? "Domisili Jepang" : "Domisili Indonesia" }}
            </span>
            <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">
              {{ $job->gender_requirement == "p" ? "Perempuan" : ($job->gender_requirement == "a" ? "Semua Gender" : "Laki-laki") }}
            </span>
            <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">
              {{ $job->qty }} orang
            </span>
          </div>
        </div>
        @php
        $benefits = $job->benefit ? array_filter(explode('|', $job->benefit)) : [];
        @endphp
        @if (count($benefits))
        <ul class="mt-3">
          @foreach ($benefits as $benefit)
          <li class="text-xs text-slate-600 ml-3 list-disc">
            {{ $benefit }}
          </li>
          @endforeach
        </ul>
        @endif
      </div>
      <div class="mt-4 flex items-center justify-between">
        <div class="text-sm font-semibold">{{ \App\Support\Currency::yen($job->salary) }}</div>
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
  <h2 class="text-2xl font-semibold tracking-tight">Tentang Kami</h2>
  <div class="grid items-start gap-10 lg:grid-cols-2">
    <div class="rounded-3xl p-6 shadow-soft">
      <img src="./artwork.png" alt="">
    </div>
    <div>
      <p class="mt-2 leading-relaxed text-slate-600 text-justify">
        <span class="font-bold">NihonSkuy</span> adalah portal lowongan kerja yang berfokus membantu pencari kerja di Indonesia menemukan peluang karier di Jepang. Kami percaya proses mencari kerja seharusnya mudah, cepat, dan transparan. Melalui lowongan yang telah dikurasi dengan informasi lengkap mulai dari gaji, lokasi, hingga persyaratan domisili serta fitur filter yang memudahkan pencarian, kami menghadirkan pengalaman yang lebih efisien dan terarah. Dengan demikian, Anda dapat lebih fokus mempersiapkan diri untuk meraih karier impian di Jepang.
      </p>

      <div class="mt-6 space-y-3">
        <div class="flex gap-3">
          <div class="mt-0.5 grid h-8 w-8 place-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check-icon lucide-badge-check">
              <path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z" />
              <path d="m9 12 2 2 4-4" />
            </svg>
          </div>
          <div>
            <div class="text-sm font-semibold">Lowongan Kerja Aman & Terpercaya</div>
            <div class="text-sm text-slate-600">Info loker sudah dicek dan diverifikasi keasliannya oleh tim Minskuy</div>
          </div>
        </div>

        <div class="flex gap-3">
          <div class="mt-0.5 grid h-8 w-8 place-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-headset-icon lucide-headset">
              <path d="M3 11h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-5Zm0 0a9 9 0 1 1 18 0m0 0v5a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3Z" />
              <path d="M21 16v2a4 4 0 0 1-4 4h-5" />
            </svg>
          </div>
          <div>
            <div class="text-sm font-semibold">Dukungan dari Tim Nihonskuy 24/7</div>
            <div class="text-sm text-slate-600">Butuh bantuan atau sekedar tanya-tanya? Minskuy siap membantu</div>
          </div>
        </div>

        <div class="flex gap-3">
          <div class="mt-0.5 grid h-8 w-8 place-items-center">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="text-slate-900">
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
            <div class="text-sm font-semibold">Mudah & Cepat</div>
            <div class="text-sm text-slate-600">Lamar kerja cukup klik sekali, dan Minskuy akan mengubungi kamu</div>
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
  fetch('/japan.json')
    .then(response => response.json())
    .then(data => {
      const wrapper = document.getElementById('select-location');
      const toggle = document.getElementById('japan-pref-toggle');
      const panel = document.getElementById('japan-pref-panel');
      const search = document.getElementById('japan-pref-search');
      const list = document.getElementById('japan-pref-list');
      const valueInput = document.getElementById('japan-pref-value');
      const label = document.getElementById('japan-pref-label');
      const allPrefectures = Array.isArray(data.japan_prefectures) ? data.japan_prefectures : [];

      const renderOptions = (items) => {
        list.innerHTML = '';
        const allItem = document.createElement('button');
        allItem.type = 'button';
        allItem.className = 'w-full text-left cursor-pointer rounded-lg px-3 py-2 hover:bg-slate-100';
        allItem.textContent = 'Semua prefektur';
        allItem.dataset.value = '';
        list.appendChild(allItem);

        items.forEach(prefecture => {
          const item = document.createElement('button');
          item.type = 'button';
          item.className = 'w-full text-left cursor-pointer rounded-lg px-3 py-2 hover:bg-slate-100';
          item.textContent = prefecture;
          item.dataset.value = prefecture;
          list.appendChild(item);
        });
      };

      renderOptions(allPrefectures);

      search.addEventListener('input', () => {
        const query = search.value.trim().toLowerCase();
        if (!query) {
          renderOptions(allPrefectures);
          return;
        }
        const filtered = allPrefectures.filter((prefecture) =>
          String(prefecture).toLowerCase().includes(query)
        );
        renderOptions(filtered);
      });

      const openPanel = () => {
        panel.classList.remove('hidden');
        toggle.setAttribute('aria-expanded', 'true');
        search.focus();
      };

      const closePanel = () => {
        panel.classList.add('hidden');
        toggle.setAttribute('aria-expanded', 'false');
        search.value = '';
        renderOptions(allPrefectures);
      };

      toggle.addEventListener('click', (event) => {
        event.stopPropagation();
        if (panel.classList.contains('hidden')) {
          openPanel();
        } else {
          closePanel();
        }
      });

      list.addEventListener('click', (event) => {
        event.preventDefault();
        event.stopPropagation();
        const target = event.target.closest('button');
        if (!target) return;
        const value = target.dataset.value || '';
        valueInput.value = value;
        label.textContent = value || 'Semua prefektur';
        label.classList.toggle('text-slate-400', !value);
        label.classList.toggle('text-slate-900', !!value);
        closePanel();
      });

      document.addEventListener('click', (event) => {
        if (!wrapper.contains(event.target)) {
          closePanel();
        }
      });
    });

  // Footer year
  document.getElementById("year").textContent = new Date().getFullYear();
</script>
@endsection