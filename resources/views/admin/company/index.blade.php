@extends('layouts.admin')

@push('title')
    <title>NihonSkuy - Data Perusahaan Jepang</title>
@endpush

@section('content')
    <div class="mb-6">
        <nav class="mb-4 text-sm" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2 text-slate-500">
                <li><span>Dashboard</span></li>
                <li class="flex items-center gap-2">
                    <span class="text-slate-400">/</span>
                    <span class="font-medium text-slate-700">Perusahaan Jepang</span>
                </li>
            </ol>
        </nav>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Perusahaan Jepang</h1>
                <p class="mt-2 text-sm text-slate-500">Kelola daftar perusahaan Jepang yang tampil di halaman publik.</p>
            </div>
            <a href="{{ route('admin.company.create') }}"
                class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                Tambah Perusahaan
            </a>
        </div>
    </div>

    @if (session('status'))
        <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('status') }}
        </div>
    @endif

    <div class="grid gap-4 lg:grid-cols-3">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Total perusahaan</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalCompanies }}</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Total lokasi</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalLocations }}</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Status data</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">Aktif</p>
            <p class="mt-1 text-xs text-slate-500">Semua data pada tabel ini ditampilkan ke halaman publik.</p>
        </div>
    </div>

    <div class="mt-6 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="text-base font-semibold text-slate-900">Daftar perusahaan</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                        <th class="px-6 py-4">Logo</th>
                        <th class="px-6 py-4">Nama perusahaan</th>
                        <th class="px-6 py-4">Lokasi</th>
                        <th class="px-6 py-4">Bidang</th>
                        <th class="px-6 py-4">Website</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($companies as $company)
                        <tr class="align-top">
                            <td class="px-6 py-4">
                                <div class="flex h-14 w-14 items-center justify-center overflow-hidden rounded-2xl border border-slate-200 bg-slate-50">
                                    <img src="{{ $company->logo_url }}" alt="{{ $company->name }} logo"
                                        class="h-full w-full object-cover">
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-semibold text-slate-900">{{ $company->name }}</p>
                                <p class="mt-1 text-xs text-slate-500">Berdiri sejak {{ $company->established }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $company->location }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $company->field }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $company->website }}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap items-center gap-3 text-sm">
                                    <a href="{{ route('admin.company.show', $company) }}"
                                        class="font-medium text-slate-700 hover:text-slate-900">Detail</a>
                                    <a href="{{ route('admin.company.edit', $company) }}"
                                        class="font-medium text-slate-700 hover:text-slate-900">Edit</a>
                                    <form method="POST" action="{{ route('admin.company.destroy', $company) }}"
                                        onsubmit="return confirm('Yakin ingin menghapus perusahaan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-medium text-red-600 hover:text-red-800">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-sm text-slate-500">
                                Belum ada data perusahaan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($companies->hasPages())
            <div class="border-t border-slate-200 px-6 py-4">
                {{ $companies->links() }}
            </div>
        @endif
    </div>
@endsection
