@extends('layouts.admin')

@push('title')
  <title>NihonSkuy - Data Loker</title>
@endpush

@section('content')
  @php
    $quickFilterValue = $quickFilter ?? null;
    $selectedFilters = request()->query('filter', []);
    $selectedFilters = is_array($selectedFilters) ? $selectedFilters : [];

    $visaOptions = [
        'Tokutei Ginou 1' => 'Tokutei Ginou 1',
        'Tokutei Ginou 2' => 'Tokutei Ginou 2',
        'Kaigo Visa' => 'Kaigo Visa',
        'GIjinkoku' => 'Gijinkoku',
    ];
    $genderOptions = ['l' => 'Laki-laki', 'p' => 'Perempuan', 'a' => 'Laki-laki & Perempuan'];
    $domicileOptions = [
        'kokunai' => 'Khusus Jepang',
        'kokugai' => 'Bebas (Di Luar Jepang)',
        'kokunai-to-kokugai' => 'Domisili Luar & Dalam Jepang',
    ];
    $jlptOptions = ['n5' => 'N5', 'n4' => 'N4', 'n3' => 'N3', 'n2' => 'N2', 'n1' => 'N1', 'all' => 'Bebas'];
    $kaiwaOptions = ['n5' => 'N5', 'n4' => 'N4', 'n3' => 'N3', 'n2' => 'N2', 'n1' => 'N1'];
    $statusOptions = ['1' => 'Aktif', '0' => 'Nonaktif'];
    $selectedSort = (string) request()->query('sort', '');
  @endphp

  <div class="mb-5">
    <nav class="mb-4 text-sm" aria-label="Breadcrumb">
      <ol class="flex items-center gap-2 text-slate-500">
        <li>
          <a href="#" class="hover:text-slate-700">Dashboard</a>
        </li>
        <li class="flex items-center gap-2">
          <span class="text-slate-400">/</span>
          <span class="font-medium text-slate-700">Loker</span>
        </li>
      </ol>
    </nav>
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Lowongan Kerja</h1>
        <p class="mt-2 text-sm text-slate-500">Kelola semua lowongan kerja</p>
      </div>
      <div>
        <a href="/admin/vacancy/create"
          class="inline-flex items-center justify-center rounded bg-slate-500 px-4 py-2 text-sm font-medium text-white hover:bg-slate-600">
          Tambah Job
        </a>
      </div>
    </div>
  </div>

  @if (!empty($hasInvalidFilterQuery))
    <div class="mb-4 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
      Parameter filter atau sorting tidak valid. Data ditampilkan dengan pengaturan default.
    </div>
  @endif

  <div class="grid grid-cols-1 gap-2 lg:grid-cols-4 lg:gap-5">
    <div class="relative rounded-2xl border border-slate-100 bg-white p-6 shadow-sm transition-shadow duration-300 hover:bg-slate-50 hover:shadow-md">
      <div
        class="{{ $quickFilterValue ? 'hidden' : '' }} absolute right-2 top-2 h-3 w-3 animate-ping rounded-full border border-green-500 bg-green-200">
      </div>
      <p class="mb-1 text-sm font-medium text-slate-500">Jumlah Loker</p>
      <p class="text-3xl font-extrabold tracking-tight text-slate-950">{{ $totalJobs }}</p>
      <p class="mt-1 text-xs text-slate-400">Seluruh lowongan kerja</p>
      <a href="{{ route('admin.vacancies') }}" class="absolute inset-0 z-10 opacity-0"></a>
    </div>
    <div class="relative rounded-2xl border border-slate-100 bg-white p-6 shadow-sm transition-shadow duration-300 hover:bg-slate-50 hover:shadow-md">
      <div
        class="{{ $quickFilterValue !== 'active' ? 'hidden' : '' }} absolute right-2 top-2 h-3 w-3 animate-ping rounded-full border border-green-500 bg-green-200">
      </div>
      <p class="mb-1 text-sm font-medium text-slate-500">Jumlah Loker Aktif</p>
      <p class="text-3xl font-extrabold tracking-tight text-green-700">{{ $totalActiveJobs }}</p>
      <p class="mt-1 text-xs text-slate-400">Seluruh lowongan kerja</p>
      <a href="{{ route('admin.vacancies', ['quick_filter' => 'active']) }}" class="absolute inset-0 z-10 opacity-0"></a>
    </div>
    <div class="relative rounded-2xl border border-slate-100 bg-white p-6 shadow-sm transition-shadow duration-300 hover:bg-slate-50 hover:shadow-md">
      <div
        class="{{ $quickFilterValue !== 'inactive' ? 'hidden' : '' }} absolute right-2 top-2 h-3 w-3 animate-ping rounded-full border border-green-500 bg-green-200">
      </div>
      <p class="mb-1 text-sm font-medium text-slate-500">Jumlah Loker Nonaktif</p>
      <p class="text-3xl font-extrabold tracking-tight text-red-600">{{ $totalInactiveJobs }}</p>
      <p class="mt-1 text-xs text-slate-400">Seluruh lowongan kerja</p>
      <a href="{{ route('admin.vacancies', ['quick_filter' => 'inactive']) }}" class="absolute inset-0 z-10 opacity-0"></a>
    </div>
    <div class="relative cursor-pointer rounded-2xl border border-slate-100 bg-white p-6 shadow-sm transition-shadow duration-300 hover:bg-slate-50 hover:shadow-md">
      <div
        class="{{ $quickFilterValue !== 'on-going-expired' ? 'hidden' : '' }} absolute right-2 top-2 h-3 w-3 animate-ping rounded-full border border-green-500 bg-green-200">
      </div>
      <p class="mb-1 text-sm font-medium text-slate-500">Mendekati Tenggat</p>
      <p class="text-3xl font-extrabold tracking-tight text-slate-950">{{ $onGoingExpired }}</p>
      <p class="mt-1 text-xs text-slate-400">Loker yang mendekati tenggat</p>
      <a href="{{ route('admin.vacancies', ['quick_filter' => 'on-going-expired']) }}" class="absolute inset-0 z-10 opacity-0"></a>
    </div>
  </div>

  <div class="mt-5 rounded-lg border border-slate-200 p-3">
    <div class="mt-2 grid grid-cols-1 gap-2">
      <div class="flex w-full flex-col gap-2 sm:flex-row sm:items-center">
        <form method="GET" action="{{ route('admin.vacancies') }}" class="relative w-full sm:max-w-md">
          @if ($quickFilterValue)
            <input type="hidden" name="quick_filter" value="{{ $quickFilterValue }}">
          @endif
          @if ($selectedSort !== '')
            <input type="hidden" name="sort" value="{{ $selectedSort }}">
          @endif
          @foreach ($selectedFilters as $filterName => $filterValue)
            @if ($filterValue !== null && $filterValue !== '')
              <input type="hidden" name="filter[{{ $filterName }}]" value="{{ $filterValue }}">
            @endif
          @endforeach
          <label class="relative block">
            <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
              <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="7" />
                <path d="M21 21l-4.3-4.3" />
              </svg>
            </span>
            <input
              class="w-full rounded-xl border border-slate-200 bg-white px-10 py-2 text-sm outline-none placeholder:text-slate-400 focus:border-slate-300 focus:ring-4 focus:ring-slate-100"
              placeholder="Cari..." name="q" value="{{ request('q') }}" type="text" />
          </label>
          <a href="{{ route('admin.vacancies') }}"
            class="{{ !request('q') ? 'hidden' : '' }} absolute inset-y-0 right-3 flex items-center text-slate-400">
            <x-icons.close />
          </a>
        </form>

        <button type="button" id="open-advanced-filter"
          class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 transition hover:border-slate-300 hover:text-slate-800"
          aria-label="Buka advanced filter">
          <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M4 6h16" />
            <path d="M7 12h10" />
            <path d="M10 18h4" />
          </svg>
        </button>
      </div>

      @forelse ($jobs as $job)
        <div
          class="{{ $job->days_left > 0 ? 'bg-white hover:bg-slate-50' : 'bg-red-50 hover:bg-red-100' }} relative rounded-md border border-slate-200 px-3 py-2 transition-colors">
          <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <div class="min-w-0">
              <div class="text-xs text-slate-500">{{ $job->job_code }}</div>
              <h3 class="truncate text-sm font-semibold text-slate-900">{{ $job->title }}</h3>
              <p class="truncate text-xs text-slate-600">
                {{ $job->placement . ($job->placement_branch ? ' - ' . $job->placement_branch : '') }}
              </p>
              @if ($job->days_left > 0)
                <p class="truncate text-xs text-green-600">{{ $job->days_left }} hari lagi sebelum ditutup</p>
              @else
                <p class="truncate text-xs text-red-600">Lowongan ini melewati tenggat waktu</p>
              @endif
            </div>
            <div class="mt-1 text-lg font-bold text-slate-600 sm:mt-0">{{ $job->salary_range }}</div>
          </div>

          <div class="mt-2 flex flex-wrap gap-1 text-[11px] text-slate-600">
            <span class="rounded bg-slate-100 px-2 py-0.5">{{ $job->job_type }}</span>
            <span class="rounded bg-slate-100 px-2 py-0.5">{{ $job->gender_requirement == 'p' ? 'Perempuan' : 'Laki-laki' }}</span>
            <span class="rounded bg-slate-100 px-2 py-0.5">{{ $job->domicile }}</span>
            <span class="rounded bg-slate-100 px-2 py-0.5">JLPT {{ $job->jlpt_requirement_label }}</span>
            <span class="rounded bg-slate-100 px-2 py-0.5">{{ $job->qty }} Orang</span>
          </div>

          <div class="relative z-20 mt-2">
            <a href="{{ route('admin.vacancy.detail', $job->job_code) }}" class="text-xs font-medium text-slate-600 hover:text-slate-800">Detail</a>
            <span class="mx-1 text-slate-300">•</span>
            <a href="{{ route('admin.vacancy.edit', $job->job_code) }}" class="text-xs font-medium text-slate-600 hover:text-slate-800">Edit</a>
            <span class="mx-1 text-slate-300">•</span>
            <form method="post" id="delete-vacancy-{{ $job->job_code }}" action="{{ route('admin.vacancy.delete', $job->job_code) }}" class="hidden">
              @csrf
              @method('DELETE')
            </form>
            <button type="button" onclick="confirmDelete('delete-vacancy-{{ $job->job_code }}')"
              class="cursor-pointer text-xs font-medium text-red-600 hover:text-red-800">
              Hapus
            </button>
          </div>

          <a href="{{ route('admin.vacancy.detail', $job->job_code) }}" class="absolute inset-0 opacity-0"></a>
        </div>
      @empty
        <div class="rounded-md border border-dashed border-slate-200 px-3 py-6 text-center text-sm text-slate-500">
          Belum ada loker
        </div>
      @endforelse

      @if ($jobs->hasPages())
        <div class="pt-2">
          {{ $jobs->links() }}
        </div>
      @endif
    </div>
  </div>

  <div id="advanced-filter-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/40" data-close-advanced-filter></div>
    <div class="absolute right-0 top-0 h-full w-full max-w-lg overflow-y-auto bg-white shadow-xl">
      <div class="sticky top-0 flex items-center justify-between border-b border-slate-200 bg-white px-5 py-4">
        <div>
          <h2 class="text-base font-semibold text-slate-900">Advanced Filter</h2>
          <p class="text-xs text-slate-500">Atur sorting dan filter lowongan kerja</p>
        </div>
        <button type="button" data-close-advanced-filter
          class="inline-flex h-8 w-8 items-center justify-center rounded-md text-slate-500 hover:bg-slate-100 hover:text-slate-700">
          <x-icons.close />
        </button>
      </div>

      <form method="GET" action="{{ route('admin.vacancies') }}" class="space-y-5 px-5 py-5" id="advanced-filter-form">
        @if (request()->filled('q'))
          <input type="hidden" name="q" value="{{ request('q') }}">
        @endif
        @if ($quickFilterValue)
          <input type="hidden" name="quick_filter" value="{{ $quickFilterValue }}">
        @endif

        <div class="space-y-2 rounded-lg border border-slate-200 p-4">
          <div class="flex items-center justify-between">
            <label for="sort-field" class="text-sm font-medium text-slate-700">Sorting Kode Loker</label>
            <button type="button" data-remove-target="#sort-field" class="text-xs text-red-500 hover:text-red-600">Hapus</button>
          </div>
          <select id="sort-field" name="sort" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 outline-none focus:border-slate-300 focus:ring-4 focus:ring-slate-100">
            <option value="">Default</option>
            <option value="job_code" @selected($selectedSort === 'job_code')>A to Z</option>
            <option value="-job_code" @selected($selectedSort === '-job_code')>Z to A</option>
          </select>
        </div>

        <div class="space-y-2 rounded-lg border border-slate-200 p-4">
          <div class="flex items-center justify-between">
            <label for="filter-visa-type" class="text-sm font-medium text-slate-700">Jenis Visa</label>
            <button type="button" data-remove-target="#filter-visa-type" class="text-xs text-red-500 hover:text-red-600">Hapus</button>
          </div>
          <select id="filter-visa-type" name="filter[visa_type]" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 outline-none focus:border-slate-300 focus:ring-4 focus:ring-slate-100">
            <option value="">Semua</option>
            @foreach ($visaOptions as $visaValue => $visaLabel)
              <option value="{{ $visaValue }}" @selected(($selectedFilters['visa_type'] ?? '') === $visaValue)>{{ $visaLabel }}</option>
            @endforeach
          </select>
        </div>

        <div class="space-y-2 rounded-lg border border-slate-200 p-4">
          <div class="flex items-center justify-between">
            <label for="filter-placement" class="text-sm font-medium text-slate-700">Penempatan</label>
            <button type="button" data-remove-target="#filter-placement" class="text-xs text-red-500 hover:text-red-600">Hapus</button>
          </div>
          <select id="filter-placement" name="filter[placement]" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 outline-none focus:border-slate-300 focus:ring-4 focus:ring-slate-100">
            <option value="">Semua prefektur</option>
            @foreach ($prefectures as $prefecture)
              <option value="{{ $prefecture }}" @selected(($selectedFilters['placement'] ?? '') === $prefecture)>{{ $prefecture }}</option>
            @endforeach
          </select>
        </div>

        <div class="space-y-2 rounded-lg border border-slate-200 p-4">
          <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-slate-700">Syarat Jenis Kelamin</p>
            <button type="button" data-remove-group="filter[gender_requirement]" class="text-xs text-red-500 hover:text-red-600">Hapus</button>
          </div>
          <div class="space-y-2">
            @foreach ($genderOptions as $genderValue => $genderLabel)
              <label class="flex items-center gap-2 text-sm text-slate-700">
                <input type="radio" name="filter[gender_requirement]" value="{{ $genderValue }}" class="h-4 w-4 border-slate-300 text-slate-700 focus:ring-slate-300" @checked(($selectedFilters['gender_requirement'] ?? '') === $genderValue)>
                <span>{{ $genderLabel }}</span>
              </label>
            @endforeach
          </div>
        </div>

        <div class="space-y-2 rounded-lg border border-slate-200 p-4">
          <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-slate-700">Syarat Domisili</p>
            <button type="button" data-remove-group="filter[domicile_requirement]" class="text-xs text-red-500 hover:text-red-600">Hapus</button>
          </div>
          <div class="space-y-2">
            @foreach ($domicileOptions as $domicileValue => $domicileLabel)
              <label class="flex items-center gap-2 text-sm text-slate-700">
                <input type="radio" name="filter[domicile_requirement]" value="{{ $domicileValue }}" class="h-4 w-4 border-slate-300 text-slate-700 focus:ring-slate-300" @checked(($selectedFilters['domicile_requirement'] ?? '') === $domicileValue)>
                <span>{{ $domicileLabel }}</span>
              </label>
            @endforeach
          </div>
        </div>

        <div class="space-y-2 rounded-lg border border-slate-200 p-4">
          <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-slate-700">Syarat JLPT</p>
            <button type="button" data-remove-group="filter[jlpt_requirement]" class="text-xs text-red-500 hover:text-red-600">Hapus</button>
          </div>
          <div class="grid grid-cols-2 gap-2">
            @foreach ($jlptOptions as $jlptValue => $jlptLabel)
              <label class="flex items-center gap-2 text-sm text-slate-700">
                <input type="radio" name="filter[jlpt_requirement]" value="{{ $jlptValue }}" class="h-4 w-4 border-slate-300 text-slate-700 focus:ring-slate-300" @checked(($selectedFilters['jlpt_requirement'] ?? '') === $jlptValue)>
                <span>{{ $jlptLabel }}</span>
              </label>
            @endforeach
          </div>
        </div>

        <div class="space-y-2 rounded-lg border border-slate-200 p-4">
          <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-slate-700">Syarat Kaiwa</p>
            <button type="button" data-remove-group="filter[kaiwa_requirement]" class="text-xs text-red-500 hover:text-red-600">Hapus</button>
          </div>
          <div class="grid grid-cols-2 gap-2">
            @foreach ($kaiwaOptions as $kaiwaValue => $kaiwaLabel)
              <label class="flex items-center gap-2 text-sm text-slate-700">
                <input type="radio" name="filter[kaiwa_requirement]" value="{{ $kaiwaValue }}" class="h-4 w-4 border-slate-300 text-slate-700 focus:ring-slate-300" @checked(($selectedFilters['kaiwa_requirement'] ?? '') === $kaiwaValue)>
                <span>{{ $kaiwaLabel }}</span>
              </label>
            @endforeach
          </div>
        </div>

        <div class="space-y-2 rounded-lg border border-slate-200 p-4">
          <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-slate-700">Status</p>
            <button type="button" data-remove-group="filter[status]" class="text-xs text-red-500 hover:text-red-600">Hapus</button>
          </div>
          <div class="space-y-2">
            @foreach ($statusOptions as $statusValue => $statusLabel)
              <label class="flex items-center gap-2 text-sm text-slate-700">
                <input type="radio" name="filter[status]" value="{{ $statusValue }}" class="h-4 w-4 border-slate-300 text-slate-700 focus:ring-slate-300" @checked(($selectedFilters['status'] ?? '') === $statusValue)>
                <span>{{ $statusLabel }}</span>
              </label>
            @endforeach
          </div>
        </div>

        <div class="flex flex-wrap items-center gap-2 pt-2">
          <button type="submit"
            class="inline-flex items-center justify-center rounded-lg bg-slate-800 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-900">
            Terapkan Filter
          </button>
          <a href="{{ route('admin.vacancies', array_filter(['quick_filter' => $quickFilterValue, 'q' => request('q')], fn ($value) => $value !== null && $value !== '')) }}"
            class="inline-flex items-center justify-center rounded-lg border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
            Reset Semua
          </a>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('scripts')
  <script type="module">
    @if (session('msg'))
      const config = @js(session('msg'));
      Swal.fire(config[1], config[2], config[0]);
    @endif
  </script>
  <script>
    function confirmDelete(id) {
      Swal.fire({
        title: "Hapus Lowongan Ini?",
        text: "Data akan dihapus secara permanen",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, hapus",
        cancelButtonText: "Batal",
        confirmButtonColor: "#b91c1c",
        cancelButtonColor: "#64748b",
        reverseButtons: true,
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById(id).submit();
        }
      });
    }

    const filterModal = document.getElementById('advanced-filter-modal');
    const openFilterButton = document.getElementById('open-advanced-filter');
    const closeButtons = filterModal ? filterModal.querySelectorAll('[data-close-advanced-filter]') : [];

    const openFilterModal = () => {
      filterModal.classList.remove('hidden');
      document.body.classList.add('overflow-hidden');
    };

    const closeFilterModal = () => {
      filterModal.classList.add('hidden');
      document.body.classList.remove('overflow-hidden');
    };

    if (openFilterButton && filterModal) {
      openFilterButton.addEventListener('click', openFilterModal);
      closeButtons.forEach((button) => button.addEventListener('click', closeFilterModal));
      document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !filterModal.classList.contains('hidden')) {
          closeFilterModal();
        }
      });
    }

    const removeTargetButtons = document.querySelectorAll('[data-remove-target]');
    removeTargetButtons.forEach((button) => {
      button.addEventListener('click', () => {
        const targetSelector = button.getAttribute('data-remove-target');
        const targetInput = targetSelector ? document.querySelector(targetSelector) : null;
        if (!targetInput) {
          return;
        }

        if (targetInput.tagName === 'SELECT') {
          targetInput.value = '';
          return;
        }

        targetInput.value = '';
      });
    });

    const removeGroupButtons = document.querySelectorAll('[data-remove-group]');
    removeGroupButtons.forEach((button) => {
      button.addEventListener('click', () => {
        const groupName = button.getAttribute('data-remove-group');
        if (!groupName) {
          return;
        }

        document.querySelectorAll(`input[name="${groupName}"]`).forEach((radioInput) => {
          radioInput.checked = false;
        });
      });
    });
  </script>
@endsection
