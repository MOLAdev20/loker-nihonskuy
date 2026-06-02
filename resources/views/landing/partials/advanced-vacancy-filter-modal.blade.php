@php
  $visaOptions = $advancedFilterOptions['visaTypes'] ?? [];
  $jlptOptions = $advancedFilterOptions['jlptLevels'] ?? [];
  $kaiwaOptions = $advancedFilterOptions['kaiwaLevels'] ?? [];
  $experienceOptions = $advancedFilterOptions['experienceRequirements'] ?? [];
  $domicileOptions = $advancedFilterOptions['domicileRequirements'] ?? [];
  $genderOptions = $advancedFilterOptions['genderRequirements'] ?? [];
  $qtyOptions = $advancedFilterOptions['qtyRanges'] ?? [];
  $benefitOptions = $advancedFilterOptions['benefits'] ?? [];
@endphp

<div id="advanced-filter-modal" class="fixed inset-0 z-50 hidden" aria-hidden="true">
  <div
    class="absolute inset-0 bg-slate-900/40 opacity-0 transition-opacity duration-200"
    data-close-advanced-filter
    data-advanced-filter-overlay></div>
  <div class="relative flex min-h-full items-center justify-center p-4 sm:p-6">
    <div
      class="flex max-h-[90vh] w-full max-w-3xl translate-y-4 scale-95 flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white opacity-0 shadow-2xl transition duration-200 ease-out"
      data-advanced-filter-dialog
      role="dialog" aria-modal="true" aria-labelledby="advanced-filter-title">
    <div class="flex items-center justify-between border-b border-slate-200 bg-white px-5 py-4">
      <div>
        <h2 id="advanced-filter-title" class="text-base font-semibold text-slate-900">Cari Preferensi Kerjamu</h2>
        <p class="text-xs text-slate-500">Atur filter lowongan kerja sesuai preferensimu</p>
      </div>
      <button type="button" data-close-advanced-filter
        class="inline-flex h-8 w-8 items-center justify-center rounded-md text-slate-500 hover:bg-slate-100 hover:text-slate-700"
        aria-label="Tutup filter">
        <x-icons.close />
      </button>
    </div>

    <form method="GET" action="{{ route('vacancies') }}" class="space-y-5 overflow-y-auto px-5 py-5"
      id="advanced-filter-form" data-sync-search-form="#{{ $searchFormId }}">
      <input type="hidden" name="q" value="{{ request('q') }}" data-sync-field="q">
      <input type="hidden" name="location" value="{{ request('location') }}" data-sync-field="location">

      <div class="space-y-2 rounded-lg border border-slate-200 p-4">
        <div class="flex items-center justify-between">
          <label for="filter-placement" class="text-sm font-medium text-slate-700">Penempatan / Lokasi Kerja</label>
          <button type="button" data-remove-target="#filter-placement" class="text-xs text-red-500 hover:text-red-600">Hapus</button>
        </div>
        <input id="filter-placement" name="placement" type="text" value="{{ $advancedFilterState['placement'] }}"
          class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 outline-none placeholder:text-slate-400 focus:border-slate-300 focus:ring-4 focus:ring-slate-100"
          placeholder="Contoh: Tokyo, Osaka, Fukuoka" />
      </div>

      <div class="space-y-2 rounded-lg border border-slate-200 p-4">
        <div class="flex items-center justify-between">
          <label for="filter-visa-type" class="text-sm font-medium text-slate-700">Jenis VISA</label>
          <button type="button" data-remove-target="#filter-visa-type" class="text-xs text-red-500 hover:text-red-600">Hapus</button>
        </div>
        <select id="filter-visa-type" name="visa_type"
          class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 outline-none focus:border-slate-300 focus:ring-4 focus:ring-slate-100">
          <option value="">Semua jenis visa</option>
          @foreach ($visaOptions as $visaValue => $visaLabel)
            <option value="{{ $visaValue }}" @selected($advancedFilterState['visa_type'] === $visaValue)>{{ $visaLabel }}</option>
          @endforeach
        </select>
      </div>

      <div class="space-y-2 rounded-lg border border-slate-200 p-4">
        <div class="flex items-center justify-between">
          <label for="filter-salary" class="text-sm font-medium text-slate-700">Gaji</label>
          <button type="button" data-remove-target="#filter-salary" class="text-xs text-red-500 hover:text-red-600">Hapus</button>
        </div>
        <input id="filter-salary" name="salary" type="text" value="{{ $advancedFilterState['salary'] }}"
          class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 outline-none placeholder:text-slate-400 focus:border-slate-300 focus:ring-4 focus:ring-slate-100"
          placeholder="Contoh: 200000 atau 250000" />
      </div>

      <div class="space-y-2 rounded-lg border border-slate-200 p-4">
        <div class="flex items-center justify-between">
          <label for="filter-jlpt" class="text-sm font-medium text-slate-700">Level JLPT</label>
          <button type="button" data-remove-target="#filter-jlpt" class="text-xs text-red-500 hover:text-red-600">Hapus</button>
        </div>
        <select id="filter-jlpt" name="jlpt_requirement"
          class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 outline-none focus:border-slate-300 focus:ring-4 focus:ring-slate-100">
          <option value="">Semua level JLPT</option>
          @foreach ($jlptOptions as $jlptValue => $jlptLabel)
            <option value="{{ $jlptValue }}" @selected($advancedFilterState['jlpt_requirement'] === $jlptValue)>{{ $jlptLabel }}</option>
          @endforeach
        </select>
      </div>

      <div class="space-y-2 rounded-lg border border-slate-200 p-4">
        <div class="flex items-center justify-between">
          <label for="filter-kaiwa" class="text-sm font-medium text-slate-700">Level Kaiwa</label>
          <button type="button" data-remove-target="#filter-kaiwa" class="text-xs text-red-500 hover:text-red-600">Hapus</button>
        </div>
        <select id="filter-kaiwa" name="kaiwa_requirement"
          class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 outline-none focus:border-slate-300 focus:ring-4 focus:ring-slate-100">
          <option value="">Semua level kaiwa</option>
          @foreach ($kaiwaOptions as $kaiwaValue => $kaiwaLabel)
            <option value="{{ $kaiwaValue }}" @selected($advancedFilterState['kaiwa_requirement'] === $kaiwaValue)>{{ $kaiwaLabel }}</option>
          @endforeach
        </select>
      </div>

      <div class="space-y-2 rounded-lg border border-slate-200 p-4">
        <div class="flex items-center justify-between">
          <label for="filter-exp" class="text-sm font-medium text-slate-700">Persyaratan Pengalaman</label>
          <button type="button" data-remove-target="#filter-exp" class="text-xs text-red-500 hover:text-red-600">Hapus</button>
        </div>
        <select id="filter-exp" name="exp_requirement"
          class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 outline-none focus:border-slate-300 focus:ring-4 focus:ring-slate-100">
          <option value="">Semua pengalaman</option>
          @foreach ($experienceOptions as $experienceValue => $experienceLabel)
            <option value="{{ $experienceValue }}" @selected($advancedFilterState['exp_requirement'] === $experienceValue)>{{ $experienceLabel }}</option>
          @endforeach
        </select>
      </div>

      <div class="space-y-2 rounded-lg border border-slate-200 p-4">
        <div class="flex items-center justify-between">
          <label for="filter-domicile" class="text-sm font-medium text-slate-700">Syarat Domisili</label>
          <button type="button" data-remove-target="#filter-domicile" class="text-xs text-red-500 hover:text-red-600">Hapus</button>
        </div>
        <select id="filter-domicile" name="domicile_requirement"
          class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 outline-none focus:border-slate-300 focus:ring-4 focus:ring-slate-100">
          <option value="">Semua domisili</option>
          @foreach ($domicileOptions as $domicileValue => $domicileLabel)
            <option value="{{ $domicileValue }}" @selected($advancedFilterState['domicile_requirement'] === $domicileValue)>{{ $domicileLabel }}</option>
          @endforeach
        </select>
      </div>

      <div class="space-y-2 rounded-lg border border-slate-200 p-4">
        <div class="flex items-center justify-between">
          <p class="text-sm font-medium text-slate-700">Syarat Jenis Kelamin</p>
          <button type="button" data-remove-group="gender_requirement" class="text-xs text-red-500 hover:text-red-600">Hapus</button>
        </div>
        <div class="space-y-2">
          @foreach ($genderOptions as $genderValue => $genderLabel)
            <label class="flex items-center gap-2 text-sm text-slate-700">
              <input type="radio" name="gender_requirement" value="{{ $genderValue }}"
                class="h-4 w-4 border-slate-300 text-slate-700 focus:ring-slate-300"
                @checked($advancedFilterState['gender_requirement'] === $genderValue)>
              <span>{{ $genderLabel }}</span>
            </label>
          @endforeach
        </div>
      </div>

      <div class="space-y-2 rounded-lg border border-slate-200 p-4">
        <div class="flex items-center justify-between">
          <p class="text-sm font-medium text-slate-700">Kuota Dibutuhkan</p>
          <button type="button" data-remove-group="qty" class="text-xs text-red-500 hover:text-red-600">Hapus</button>
        </div>
        <div class="grid grid-cols-2 gap-2">
          @foreach ($qtyOptions as $qtyValue => $qtyLabel)
            <label class="flex items-center gap-2 text-sm text-slate-700">
              <input type="radio" name="qty" value="{{ $qtyValue }}"
                class="h-4 w-4 border-slate-300 text-slate-700 focus:ring-slate-300"
                @checked($advancedFilterState['qty'] === $qtyValue)>
              <span>{{ $qtyLabel }}</span>
            </label>
          @endforeach
        </div>
      </div>

      <div class="space-y-2 rounded-lg border border-slate-200 p-4">
        <div class="flex items-center justify-between">
          <p class="text-sm font-medium text-slate-700">Benefit</p>
          <button type="button" data-remove-group="benefit[]" class="text-xs text-red-500 hover:text-red-600">Hapus</button>
        </div>
        <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
          @foreach ($benefitOptions as $benefitValue)
            <label class="flex items-center gap-2 text-sm text-slate-700">
              <input type="checkbox" name="benefit[]" value="{{ $benefitValue }}"
                class="h-4 w-4 rounded border-slate-300 text-slate-700 focus:ring-slate-300"
                @checked(in_array($benefitValue, $advancedFilterState['benefit'], true))>
              <span>{{ $benefitValue }}</span>
            </label>
          @endforeach
        </div>
      </div>

      <div class="flex flex-wrap items-center gap-2 pt-2">
        <button type="submit"
          class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-800">
          Terapkan Filter
        </button>
        <a href="{{ route('vacancies', array_filter(['q' => request('q'), 'location' => request('location')], fn ($value) => $value !== null && $value !== '')) }}"
          class="inline-flex items-center justify-center rounded-lg border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
          Reset Semua
        </a>
      </div>
    </form>
    </div>
  </div>
</div>
