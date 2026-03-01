<div
    id="overlay"
    class="fixed inset-0 z-40 hidden bg-slate-900/40 backdrop-blur-[1px] lg:hidden"
    aria-hidden="true">
</div>

<!-- Sidebar -->
<aside
    id="sidebar"
    class="fixed inset-y-0 left-0 z-50 w-64 -translate-x-full border-r border-slate-200 bg-white/90 backdrop-blur supports-backdrop-filter:bg-white/70 transition-transform duration-200 lg:translate-x-0"
    aria-label="Sidebar">
    <!-- Brand -->
    <div class="flex h-16 items-center gap-3 border-b border-slate-200 px-4">
        <div class="grid h-9 w-9 place-items-center rounded-xl bg-slate-900 text-white shadow-soft">
            <!-- simple logo -->
            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 3l8 5v8l-8 5-8-5V8l8-5Z" />
                <path d="M12 3v18" />
            </svg>
        </div>
        <div class="leading-tight">
            <p class="text-sm font-semibold">NihonSkuy Admin</p>
            <p class="text-xs text-slate-500">Admin Dashboard</p>
        </div>
    </div>

    <!-- Nav -->
    <nav class="px-3 py-4">
        <p class="px-3 pb-2 text-xs font-medium uppercase tracking-wider text-slate-400">Menu</p>

        <a href="/admin/jobs" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-slate-900">
            <x-icons.briefcase />Lowongan Kerja
        </a>
    </nav>

    <!-- Sidebar footer -->
    <div class="absolute bottom-0 left-0 right-0 border-t border-slate-200 p-4">
        <div class="flex items-center gap-3">
            <div class="h-9 w-9 rounded-full bg-slate-200"></div>
            <div class="min-w-0">
                <p class="truncate text-sm font-semibold">{{ auth('admin')->user()->name }}</p>
                <p class="truncate text-xs text-slate-500">{{ auth('admin')->user()->email }}</p>
            </div>
        </div>
    </div>
</aside>