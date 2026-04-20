@extends('layouts.admin')

@push('title')
  <title>NihonSkuy - Data User</title>
@endpush

@section('content')
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

  <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
    <div
      class="mb-4 flex flex-col gap-3 border-b border-slate-100 pb-4 sm:flex-row sm:items-center sm:justify-between">
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

      <div class="text-sm text-slate-500">
        Menampilkan {{ $users->total() }} akun
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
@endsection
