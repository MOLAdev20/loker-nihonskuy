<!-- Top gradient background -->
<div class="pointer-events-none fixed inset-0 -z-10">
    <div class="absolute left-1/2 -top-60 h-130 w-[520px] -translate-x-1/2 rounded-full bg-indigo-200/45 blur-3xl"></div>
    <div class="absolute right-[-200px] top-[120px] h-[420px] w-[420px] rounded-full bg-emerald-200/40 blur-3xl"></div>
</div>

<header class="sticky top-0 z-50 border-b border-slate-200/70 bg-white/70 backdrop-blur">
    <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3 sm:px-6">
        <a href="/#" class="flex items-center gap-2">
            <img src="/logo.png" width="15px" alt="logo">
            <span class="text-sm font-semibold tracking-tight">NihonSkuy</span>
        </a>

        <nav class="hidden items-center gap-6 md:flex">
            <a href="/#jobs" class="text-sm text-slate-600 hover:text-slate-900">Jobs</a>
            <a href="/#about" class="text-sm text-slate-600 hover:text-slate-900">About</a>
            <a href="/#testimonials" class="text-sm text-slate-600 hover:text-slate-900">Testimoni</a>
            <a href="/#footer" class="text-sm text-slate-600 hover:text-slate-900">Kontak</a>
        </nav>

        <!-- <div class="hidden items-center gap-2 md:flex">
        <a
          href="#"
          class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Masuk</a>
        <a
          href="#"
          class="rounded-xl bg-slate-900 px-3 py-2 text-sm font-medium text-white hover:bg-slate-800">Post a Job</a>
      </div> -->

        <button
            id="menuBtn"
            class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white p-2 text-slate-700 hover:bg-slate-50 md:hidden"
            aria-label="Buka menu"
            aria-expanded="false">
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
                    class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-center text-sm font-medium text-slate-700 hover:bg-slate-50">Masuk</a>
                <a
                    href="#"
                    class="rounded-xl bg-slate-900 px-3 py-2 text-center text-sm font-medium text-white hover:bg-slate-800">Post a Job</a>
            </div>
        </div>
    </div>
</header>