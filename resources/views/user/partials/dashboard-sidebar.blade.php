<div id="userSidebarOverlay"
  class="fixed inset-0 z-40 hidden bg-slate-900/40 opacity-0 transition-opacity duration-300 lg:hidden"
  aria-hidden="true"></div>

<aside id="userSidebar"
  class="fixed inset-y-0 left-0 z-50 w-72 -translate-x-full border-r border-slate-700 bg-slate-800 text-white transition-transform duration-300 ease-out lg:translate-x-0"
  aria-label="Sidebar">
  <div class="flex h-16 items-center border-b border-slate-700 px-5">
    <div>
      <p class="text-sm font-semibold">User Dashboard</p>
      <p class="text-xs text-slate-300">Navigation Panel</p>
    </div>
  </div>

  <nav class="h-[calc(100%-4rem)] overflow-y-auto px-3 py-4">
    <div class="mb-5">
      
      <a href="{{ route('user.dashboard') }}"
        class="{{ request()->routeIs('user.dashboard') ? 'bg-slate-700 text-white' : 'text-slate-100 hover:bg-slate-700/80' }} flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition">
        <x-icons.layoutGrid size="18" /> CV
      </a>
    </div>

    <div class="mb-5">
      <p class="px-3 pb-2 text-xs font-semibold uppercase tracking-wider text-slate-300">Profil</p>
      <button type="button"
        class="flex w-full items-center justify-between rounded-xl px-3 py-2.5 text-sm font-medium text-slate-100 transition hover:bg-slate-700/80"
        data-submenu-toggle="profile-menu" aria-expanded="true">
        <span class="flex items-center gap-3">
          <x-icons.user size="18" />
          Data Pribadi
        </span>
        <span class="transition-transform duration-300" data-chevron>
          <x-icons.chevronDown size="16" />
        </span>
      </button>
      <div class="mt-2 overflow-hidden transition-all duration-300 ease-out"
        data-submenu="profile-menu">
        <div class="space-y-1 border-l border-slate-600 pl-5">
          <a href="{{ route('user.profile.form') }}"
            class="{{ request()->routeIs('user.profile.form') ? 'bg-slate-700 text-white' : 'text-slate-200 hover:bg-slate-700/70' }} block rounded-lg px-3 py-2 text-sm transition">Profil
            Saya</a>
          <a href="{{ route('user.document') }}"
            class="{{ request()->routeIs('user.document*') ? 'bg-slate-700 text-white' : 'text-slate-200 hover:bg-slate-700/70' }} block rounded-lg px-3 py-2 text-sm transition">Dokumen</a>
          <a href="{{ route('user.certificate') }}"
            class="{{ request()->routeIs('user.certificate*') ? 'bg-slate-700 text-white' : 'text-slate-200 hover:bg-slate-700/70' }} block rounded-lg px-3 py-2 text-sm transition">Sertifikat</a>
        </div>
      </div>
    </div>

    <div class="">
      </p>
      <a href="{{ route('logout') }}" onclick="return confirm('Keluar?')"
        class="text-slate-100 hover:bg-slate-700/80 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition">
        <x-icons.logout size="18" />
        Logout
      </a>

    
      {{-- <p class="px-3 pb-2 text-xs font-semibold uppercase tracking-wider text-slate-300">Lamaran</p>
      <button type="button"
        class="flex w-full items-center justify-between rounded-xl px-3 py-2.5 text-sm font-medium text-slate-100 transition hover:bg-slate-700/80"
        data-submenu-toggle="application-menu" aria-expanded="false">
        <span class="flex items-center gap-3">
          <x-icons.send size="18" />
          Aktivitas Lamaran
        </span>
        <span class="transition-transform duration-300" data-chevron>
          <x-icons.chevronDown size="16" />
        </span>
      </button>
      <div class="overflow-hidden transition-all duration-300 ease-out"
        data-submenu="application-menu">
        <div class="space-y-1 border-l border-slate-600 pl-5 pt-2">
          <a href="#"
            class="block rounded-lg px-3 py-2 text-sm text-slate-200 transition hover:bg-slate-700/70">Lamaran
            Terkirim</a>
          <a href="#"
            class="block rounded-lg px-3 py-2 text-sm text-slate-200 transition hover:bg-slate-700/70">Proses
            Interview</a>
          <a href="#"
            class="block rounded-lg px-3 py-2 text-sm text-slate-200 transition hover:bg-slate-700/70">Riwayat
            Hasil</a>
          <a href="#"
            class="block rounded-lg px-3 py-2 text-sm text-slate-200 transition hover:bg-slate-700/70">Progress
            Berkas</a>
          <a href="#"
            class="block rounded-lg px-3 py-2 text-sm text-slate-200 transition hover:bg-slate-700/70">Jadwal
            Keberangkatan</a>
        </div>
      </div> --}}
    </div>

    {{-- <div class="mb-5">
      <p class="px-3 pb-2 text-xs font-semibold uppercase tracking-wider text-slate-300">Pengaturan
      </p>
      <a href="#"
        class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-100 transition hover:bg-slate-700/80">
        <x-icons.bell size="18" />
        Notifikasi
      </a>
      <a href="#"
        class="mt-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-100 transition hover:bg-slate-700/80">
        <x-icons.shield size="18" />
        Keamanan Akun
      </a>
      <a href="#"
        class="mt-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-100 transition hover:bg-slate-700/80">
        <x-icons.circleHelp size="18" />
        Bantuan
      </a>
    </div> --}}
  </nav>
</aside>
