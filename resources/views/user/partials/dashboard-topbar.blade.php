@php
    $currentUser = auth()->user();
    $avatarInitial = strtoupper(substr($currentUser->name ?? $currentUser->email ?? 'U', 0, 1));
@endphp

<header class="fixed inset-x-0 top-0 z-30 border-b border-slate-200 bg-white shadow-sm lg:pl-[18rem]">
    <div class="mx-auto flex h-16 w-full items-center justify-between gap-3 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3">
            <button
                type="button"
                id="userSidebarToggle"
                class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 transition hover:bg-slate-50 lg:hidden"
                aria-label="Buka sidebar"
                aria-controls="userSidebar"
                aria-expanded="false">
                <x-icons.menu size="18" />
            </button>

            <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2">
                <img src="/logo.png" alt="NihonSkuy" class="h-8 w-8 rounded-lg bg-slate-100 object-contain p-1">
                <span class="text-sm font-semibold tracking-wide text-slate-900 sm:text-base">NihonSkuy</span>
            </a>
        </div>

        <div class="flex items-center gap-3">
            <div class="hidden text-right sm:block">
                <p class="truncate text-sm font-medium text-slate-800">{{ $currentUser->email }}</p>
                <p class="text-xs text-slate-500">Calon pekerja di Jepang</p>
            </div>

            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-200 text-sm font-semibold text-slate-700">
                {{ $avatarInitial }}
            </div>
        </div>
    </div>
</header>
