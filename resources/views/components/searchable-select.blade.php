<div id="select-location"
    class="relative md:w-52 flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 active:ring-slate-300 focus-within:ring-2 focus-within:ring-slate-300 transition-all hover:bg-slate-50">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" class="text-slate-400">
        <path d="M12 22s7-4.4 7-11a7 7 0 1 0-14 0c0 6.6 7 11 7 11Z" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" />
        <path d="M12 11.5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
    </svg>
    <div class="w-full" id="japan-pref-wrapper">
        <input type="hidden" id="japan-pref-value" name="location" value="">
        <button type="button" id="japan-pref-toggle"
            class="flex w-full items-center justify-between gap-2 bg-transparent text-sm text-slate-900 focus:outline-none cursor-pointer"
            aria-haspopup="listbox" aria-expanded="false">
            <span id="japan-pref-label" class="text-slate-400">Semua prefektur</span>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" class="text-slate-400">
                <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
        </button>
    </div>
    <div id="japan-pref-panel"
        class="absolute left-0 right-0 top-full z-20 mt-2 hidden rounded-xl border border-slate-200 bg-white p-2 shadow-soft">
        <input id="japan-pref-search" type="text" placeholder="Cari prefektur..."
            class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200" />
        <ul id="japan-pref-list" class="mt-2 max-h-56 overflow-auto text-sm text-slate-900" role="listbox"
            aria-label="Daftar prefektur">
        </ul>
    </div>
</div>
