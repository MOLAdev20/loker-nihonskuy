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
      <a href="{{ route('jp.company') }}" class="text-slate-600 hover:text-slate-900">Perusahaan</a>
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
      @endphp
      <div class="relative hidden md:block" data-avatar-menu-root>
        <button type="button" data-avatar-menu-button aria-expanded="false"
          aria-label="Buka menu profil kandidat"
          class="flex h-12 w-12 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-700 transition hover:bg-slate-50">
          <span
            class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-900 text-white transition duration-200">
            <x-icons.user size="18" />
          </span>
        </button>

        <div data-avatar-menu
          class="pointer-events-none absolute right-0 mt-3 hidden w-56 origin-top-right overflow-hidden rounded-2xl border border-slate-200 bg-white p-2 shadow-lg opacity-0 translate-y-2 scale-95 transition-all duration-200 ease-out">
          <a href="{{ route('user.dashboard') }}"
            class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-900 text-white">
              <x-icons.user size="16" />
            </span>
            <span class="flex flex-col leading-tight">
              <span class="font-semibold text-slate-900">Profil</span>
              <span class="text-xs text-slate-500">Dashboard kandidat</span>
            </span>
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
      <a href="{{ route('jp.company') }}"
        class="rounded-lg px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">Perusahaan</a>
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
        <a href="{{ route('user.dashboard') }}"
          class="flex items-center gap-3 rounded-xl px-3 py-2 hover:bg-slate-50 md:hidden">
          <div
            class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-900 text-white">
            <x-icons.user size="16" />
          </div>
          <div class="text-left leading-tight">
            <p class="font-medium text-slate-800">Dashboard Kandidat</p>
            <p class="text-xs text-slate-500">Buka profil Anda</p>
          </div>
        </a>
      @endauth
    </div>
  </div>
</header>

@auth
  <script>
    (() => {
      const root = document.querySelector('[data-avatar-menu-root]');
      if (!root) return;

      const button = root.querySelector('[data-avatar-menu-button]');
      const menu = root.querySelector('[data-avatar-menu]');
      let menuOpen = false;

      const openMenu = () => {
        if (menuOpen) return;

        menu.classList.remove('hidden');
        window.requestAnimationFrame(() => {
          menu.classList.remove('opacity-0', 'translate-y-2', 'scale-95', 'pointer-events-none');
        });
        button.setAttribute('aria-expanded', 'true');
        menuOpen = true;
      };

      const closeMenu = () => {
        if (!menuOpen) return;

        menu.classList.add('opacity-0', 'translate-y-2', 'scale-95', 'pointer-events-none');
        button.setAttribute('aria-expanded', 'false');
        menuOpen = false;

        window.setTimeout(() => {
          if (!menuOpen) {
            menu.classList.add('hidden');
          }
        }, 200);
      };

      button.addEventListener('click', (event) => {
        event.stopPropagation();

        if (menu.classList.contains('hidden')) {
          openMenu();
        } else {
          closeMenu();
        }
      });

      document.addEventListener('click', (event) => {
        if (!root.contains(event.target)) {
          closeMenu();
        }
      });

      document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
          closeMenu();
        }
      });
    })();
  </script>
@endauth
