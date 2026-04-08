@extends("layouts.landing")

@section("header")
<title>Semua Lowongan | NihonSkuy</title>
@endsection

@section("content")
<section class="mx-auto max-w-6xl px-4 pb-8 pt-10 sm:px-6 sm:pt-14">
  <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-soft sm:p-8">
    <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
      <div>
        <p class="text-xs font-medium uppercase tracking-[0.2em] text-slate-500">Explore Jobs</p>
        <h1 class="mt-2 text-3xl font-semibold tracking-tight sm:text-4xl">Semua Info Lowongan Kerja Jepang</h1>
        <p class="mt-2 text-sm text-slate-600">Temukan lowongan yang cocok berdasarkan posisi, tipe visa, tipe kerja, dan lokasi.</p>
      </div>
    </div>

    <form method="GET" action="{{ route('vacancies') }}" class="mt-6 grid gap-1 md:grid-cols-[1fr_220px_120px]">
      <label class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" class="text-slate-400">
          <path d="M21 21l-4.3-4.3m1.8-5.2a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
        </svg>
        <input
          name="q"
          value="{{ request('q') }}"
          class="w-full bg-transparent text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none"
          placeholder="Cari posisi, tipe visa, tipe kerja..."
          type="text" />
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
    <x-job-card :dataJob="$job" />
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