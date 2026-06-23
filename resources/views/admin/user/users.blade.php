@extends('layouts.admin')

@push('title')
  <title>NihonSkuy - Data User</title>
@endpush

@section('content')
  @php
    $shouldOpenCreateModal = $errors->any() && old('formMode') === 'create';
  @endphp

  <div class="mb-5">
    <nav class="mb-4 text-sm" aria-label="Breadcrumb">
      <ol class="flex items-center gap-2 text-slate-500">
        <li>
          <a href="#" class="hover:text-slate-700">
            Dashboard
          </a>
        </li>

        <li class="flex items-center gap-2">
          <span class="text-slate-400">/</span>
          <span class="font-medium text-slate-700">
            Users
          </span>
        </li>
      </ol>
    </nav>

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
          Data Pengguna
        </h1>
        <p class="mt-2 text-sm text-slate-500">
          Kelola daftar akun dan status kelengkapan data pengguna.
        </p>
      </div>
    </div>
  </div>

  @if (session('status'))
    <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
      {{ session('status') }}
    </div>
  @endif

  <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
    <div
      class="mb-4 flex flex-col gap-3 border-b border-slate-100 pb-4 lg:flex-row lg:items-center lg:justify-between">
      <form method="GET" action="{{ route('admin.users') }}" class="relative w-full sm:max-w-md">
        <label class="relative block">
          <span
            class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
            <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor"
              stroke-width="2">
              <circle cx="11" cy="11" r="7" />
              <path d="M21 21l-4.3-4.3" />
            </svg>
          </span>
          <input
            class="w-full rounded-xl border border-slate-200 bg-white px-10 py-2 text-sm outline-none placeholder:text-slate-400 focus:border-slate-300 focus:ring-4 focus:ring-slate-100"
            placeholder="Cari nama lengkap..." name="q" value="{{ $queryFilter }}"
            type="text" />
        </label>

        <a href="{{ route('admin.users') }}"
          class="{{ $queryFilter === '' ? 'hidden' : '' }} absolute inset-y-0 right-3 flex items-center text-slate-400">
          <x-icons.close />
        </a>
      </form>

      <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
        <div class="text-sm text-slate-500 lg:text-right">
          Menampilkan {{ $users->total() }} akun
        </div>

        <button type="button"
          onclick="window.openCreateUserModal?.()"
          class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
          Tambah Akun
        </button>
      </div>
    </div>

    <div class="overflow-hidden rounded-xl border border-slate-200">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
          <thead class="bg-slate-50">
            <tr>
              <th
                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                Name
              </th>
              <th
                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                Email
              </th>
              <th
                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                Status
              </th>
              <th
                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                Action
              </th>
            </tr>
          </thead>

          <tbody class="divide-y divide-slate-200 bg-white">
            @forelse ($users as $user)
              <tr class="hover:bg-slate-50">
                <td class="px-4 py-4 text-sm font-medium text-slate-900">
                  <a href="{{ route('admin.users.detail', $user->id) }}"
                    class="hover:text-slate-700 hover:underline">
                    {{ $user->displayName }}
                  </a>
                </td>
                <td class="px-4 py-4 text-sm text-slate-600">
                  {{ $user->email }}
                </td>
                <td class="px-4 py-4 text-sm">
                  @if ($user->hasCompletedProfile)
                    <span
                      class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">
                      Completed
                    </span>
                  @else
                    <span
                      class="inline-flex items-center rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700">
                      Incomplete
                    </span>
                  @endif
                </td>
                <td class="px-4 py-4 text-sm">
                  <a href="{{ route('admin.users.detail', $user->id) }}"
                    class="inline-flex items-center rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                    Detail
                  </a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="px-4 py-8 text-center text-sm text-slate-500">
                  Tidak ada user yang sesuai dengan pencarian saat ini.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    @if ($users->hasPages())
      <div class="mt-4">
        {{ $users->links() }}
      </div>
    @endif
  </div>

  <div id="create-user-modal"
    class="fixed inset-0 z-50 {{ $shouldOpenCreateModal ? '' : 'hidden' }}"
    aria-hidden="{{ $shouldOpenCreateModal ? 'false' : 'true' }}">
    <div class="absolute inset-0 bg-slate-950/50" data-create-user-modal-backdrop></div>

    <div class="relative mx-auto flex min-h-full max-w-2xl items-center px-4 py-6 sm:px-6">
      <div class="w-full overflow-hidden rounded-2xl bg-white shadow-2xl">
        <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4 sm:px-6">
          <div>
            <h3 class="text-base font-semibold text-slate-900">Tambah Akun User</h3>
            <p class="mt-1 text-sm text-slate-500">
              Isi email user. Password default akan dibuat otomatis menjadi <span class="font-semibold text-slate-700">1234</span>.
            </p>
          </div>
          <button type="button"
            onclick="window.closeCreateUserModal()"
            class="inline-flex h-9 w-9 items-center justify-center rounded-full text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
            aria-label="Tutup modal">
            <x-icons.close />
          </button>
        </div>

        <form method="POST" action="{{ route('admin.users.store') }}" class="px-5 py-5 sm:px-6">
          @csrf
          <input type="hidden" name="formMode" value="create">

          <div>
            <label for="create_user_email" class="mb-2 block text-sm font-medium text-slate-700">
              Email
            </label>
            <input
              id="create_user_email"
              name="email"
              type="email"
              value="{{ old('email') }}"
              placeholder="nama@email.com"
              class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none placeholder:text-slate-400 focus:border-slate-300 focus:ring-4 focus:ring-slate-100"
              required />
            @error('email')
              <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <button type="button"
              onclick="window.closeCreateUserModal()"
              class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
              Batal
            </button>
            <button type="submit"
              class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
              Simpan Akun
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    (() => {
      const modal = document.getElementById('create-user-modal');
      if (!modal) return;

      const emailInput = document.getElementById('create_user_email');
      const backdrop = modal.querySelector('[data-create-user-modal-backdrop]');

      const openModal = () => {
        modal.classList.remove('hidden');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('overflow-hidden');

        window.requestAnimationFrame(() => {
          emailInput?.focus();
        });
      };

      const closeModal = () => {
        modal.classList.add('hidden');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('overflow-hidden');
      };

      window.openCreateUserModal = openModal;
      window.closeCreateUserModal = closeModal;

      backdrop?.addEventListener('click', closeModal);
      window.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
          closeModal();
        }
      });

      @if ($shouldOpenCreateModal)
        openModal();
      @endif
    })();
  </script>
@endsection
