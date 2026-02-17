<header class="fixed inset-x-0 top-0 z-30 h-16 border-b border-slate-200 bg-white/80 backdrop-blur supports-backdrop-filter:bg-white/60 lg:pl-64">
    <div class="mx-auto flex h-full max-w-screen-2xl items-center gap-3 px-4">
        <!-- Mobile: burger -->
        <button
            id="btnOpen"
            class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white hover:bg-slate-50 active:scale-[0.98] lg:hidden"
            aria-label="Open sidebar"
            aria-controls="sidebar"
            aria-expanded="false">
            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Page title -->
        <div class="flex items-center gap-2">
            <span class="hidden h-9 w-9 items-center justify-center rounded-xl bg-slate-900 text-white shadow-soft sm:inline-flex">
                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 5h16v14H4z" />
                    <path d="M8 9h8M8 13h5" />
                </svg>
            </span>
            <div class="leading-tight">
                <p class="text-sm font-semibold">Dashboard</p>
                <p class="hidden text-xs text-slate-500 sm:block">Overview & quick actions</p>
            </div>
        </div>

        <!-- Spacer -->
        <div class="flex-1"></div>

        <!-- Search (desktop-ish) -->
        <div class="hidden w-90 sm:block">
            <label class="relative block">
                <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="7" />
                        <path d="M21 21l-4.3-4.3" />
                    </svg>
                </span>
                <input
                    class="w-full rounded-xl border border-slate-200 bg-white px-10 py-2 text-sm outline-none placeholder:text-slate-400 focus:border-slate-300 focus:ring-4 focus:ring-slate-100"
                    placeholder="Search..."
                    type="text" />
            </label>
        </div>

        <!-- Right actions -->
        <div class="flex items-center gap-2">
            <button
                class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white hover:bg-slate-50 active:scale-[0.98]"
                aria-label="Notifications">
                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 7h18s-3 0-3-7" />
                    <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                </svg>
            </button>

            <form action="{{ route('admin.logout') }}" method="POST" class="inline js-logout-form">
                @csrf
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-medium hover:bg-slate-50 active:scale-[0.98]"
                    aria-label="Account">
                    <span class="hidden sm:inline">{{ auth('admin')->user()->name }}</span>
                    <span class="h-7 rounded-full bg-slate-200 px-2 py-1 text-xs font-semibold text-slate-700">Logout</span>
                </button>
            </form>
        </div>
    </div>
</header>
