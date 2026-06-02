@props([
    'value' => '',
    'name' => 'location',
    'idPrefix' => 'japan-pref',
])

@php
    $selectedValue = (string) $value;
    $labelClass = $selectedValue !== '' ? 'text-slate-900' : 'text-slate-400';
    $labelText = $selectedValue !== '' ? $selectedValue : 'Semua prefektur';
@endphp

<div data-searchable-select
    data-searchable-select-prefix="{{ $idPrefix }}"
    class="relative flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 transition-all hover:bg-slate-50 active:ring-slate-300 focus-within:ring-2 focus-within:ring-slate-300 md:w-52">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" class="text-slate-400">
        <path d="M12 22s7-4.4 7-11a7 7 0 1 0-14 0c0 6.6 7 11 7 11Z" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" />
        <path d="M12 11.5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
    </svg>
    <div class="w-full">
        <input type="hidden" data-searchable-select-value name="{{ $name }}" value="{{ $selectedValue }}">
        <button type="button" data-searchable-select-toggle
            class="flex w-full cursor-pointer items-center justify-between gap-2 bg-transparent text-sm text-slate-900 focus:outline-none"
            aria-haspopup="listbox" aria-expanded="false">
            <span data-searchable-select-label class="{{ $labelClass }}">{{ $labelText }}</span>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" class="text-slate-400">
                <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
        </button>
    </div>
    <div data-searchable-select-panel
        class="absolute left-0 right-0 top-full z-20 mt-2 hidden rounded-xl border border-slate-200 bg-white p-2 shadow-soft">
        <input data-searchable-select-search type="text" placeholder="Cari prefektur..."
            class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200" />
        <ul data-searchable-select-list class="mt-2 max-h-56 overflow-auto text-sm text-slate-900" role="listbox"
            aria-label="Daftar prefektur">
        </ul>
    </div>
</div>
