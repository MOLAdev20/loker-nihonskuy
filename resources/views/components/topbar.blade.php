<!-- Top gradient background -->
<div class="pointer-events-none fixed inset-0 -z-10">
  <div
    class="h-130 w-130 absolute -top-60 left-1/2 -translate-x-1/2 rounded-full bg-indigo-200/45 blur-3xl">
  </div>
  <div class="-right-50 top-30 h-150 w-150 absolute rounded-full bg-emerald-200/40 blur-3xl"></div>
</div>

<header class="sticky top-0 z-50 border-b border-slate-200/70 bg-white/70 backdrop-blur">
  <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3 sm:px-6">
    <a href="/#" class="flex items-center gap-2">
      <img src="/logo.png" width="20px" alt="logo">
      <span class="text-lg font-semibold tracking-tight">NihonSkuy</span>
    </a>

    <nav class="hidden items-center gap-6 md:flex">
      <a href="/#jobs" class="text-slate-600 hover:text-slate-900">Info Loker</a>
      <a href="/#about" class="text-slate-600 hover:text-slate-900">Tentang</a>
      <a href="/matching-job" class="text-slate-600 hover:text-slate-900">Matching Job</a>
      <a href="/#testimonials" class="text-slate-600 hover:text-slate-900">Testimoni</a>
      <a href="/#footer" class="text-slate-600 hover:text-slate-900">Kontak</a>
    </nav>


    @guest
      <div class="hidden items-center gap-2 md:flex">
        <a href="/login"
          class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Masuk</a>
        <a href="/register"
          class="rounded-xl bg-slate-900 px-3 py-2 text-sm font-medium text-white hover:bg-slate-800">Daftar</a>
      </div>
    @endguest

    @auth
      @php
        $currentUser = auth()->user();
        $displayName = trim($currentUser->name ?? '');
        $sourceName = $displayName !== '' ? $displayName : $currentUser->email ?? 'User';
        $initialParts = preg_split('/\s+/', $sourceName, -1, PREG_SPLIT_NO_EMPTY) ?: [];
        $avatarInitial = collect(array_slice($initialParts, 0, 2))
            ->map(fn($part) => strtoupper(substr($part, 0, 1)))
            ->implode('');
      @endphp
      <div class="hidden items-center gap-3 md:flex">
        <div
          class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-900 text-sm font-semibold tracking-wide text-white">
          {{ $avatarInitial !== '' ? $avatarInitial : 'U' }}
        </div>
        <div class="text-right leading-tight">
          <a href={{ route('user.dashboard') }}
            class="max-w-48 truncate text-lg font-medium text-slate-800">{{ $currentUser->email }}
          </a>
        </div>
      </div>
    @endauth

    <button id="menu-btn"
      class="inline-flex cursor-pointer items-center justify-center rounded-xl border border-slate-200 bg-white p-2 text-slate-700 hover:bg-slate-50 active:bg-slate-100 md:hidden"
      aria-label="Buka menu" aria-expanded="false">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
        <path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="2"
          stroke-linecap="round" />
      </svg>
    </button>
  </div>

  <!-- Mobile menu -->
  <div id="mobile-menu" data-state="closed"
    class="pointer-events-none absolute hidden max-h-0 w-full origin-top -translate-y-1 scale-95 overflow-hidden border-t border-slate-200 bg-white opacity-0 transition-all duration-200 ease-out md:hidden">
    <div class="mx-auto flex max-w-6xl flex-col gap-2 px-4 py-3 sm:px-6">
      <a href="#jobs" class="rounded-lg px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">Info
        Loker</a>
      <a href="#about"
        class="rounded-lg px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">Tentang</a>
      <a href="#about"
        class="rounded-lg px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">Kelas Matching Job</a>
      <a href="#testimonials"
        class="rounded-lg px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">Testimoni</a>
      <a href="#footer"
        class="rounded-lg px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">Kontak</a>

      @guest
        <div class="mt-2 grid grid-cols-2 gap-2">
          <a href="/login"
            class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-center text-sm font-medium text-slate-700 hover:bg-slate-50">Masuk</a>
          <a href="/register"
            class="rounded-xl bg-slate-900 px-3 py-2 text-center text-sm font-medium text-white hover:bg-slate-800">Daftar</a>
        </div>
      @endguest

      @auth
        <div
          class="flex cursor-pointer items-center gap-3 rounded px-3 py-2 hover:bg-slate-50 md:hidden">
          <div
            class="flex h-7 w-7 items-center justify-center rounded-full bg-slate-900 text-xs font-semibold tracking-wide text-white">
            {{ $avatarInitial !== '' ? $avatarInitial : 'U' }}
          </div>
          <div class="text-right leading-tight">
            <p class="max-w-48 truncate font-medium text-slate-800">{{ $currentUser->email }}
            </p>
          </div>
        </div>
      @endauth
    </div>
  </div>
</header>
