@extends('layouts.admin')

@push('title')
    <title>NihonSkuy - Detail Perusahaan Jepang</title>
@endpush

@section('content')
    <div class="mb-6">
        <nav class="mb-4 text-sm" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2 text-slate-500">
                <li><span>Dashboard</span></li>
                <li class="flex items-center gap-2">
                    <span class="text-slate-400">/</span>
                    <a href="{{ route('admin.company.index') }}" class="hover:text-slate-700">Perusahaan Jepang</a>
                </li>
                <li class="flex items-center gap-2">
                    <span class="text-slate-400">/</span>
                    <span class="font-medium text-slate-700">Detail</span>
                </li>
            </ol>
        </nav>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">{{ $company->name }}</h1>
                <p class="mt-2 text-sm text-slate-500">Detail data perusahaan yang dipublikasikan di halaman umum.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.company.edit', $company) }}"
                    class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                    Edit Data
                </a>
                <form method="POST" action="{{ route('admin.company.destroy', $company) }}"
                    onsubmit="return confirm('Yakin ingin menghapus perusahaan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-xl border border-red-200 bg-red-50 px-5 py-3 text-sm font-semibold text-red-700 transition hover:bg-red-100">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    @if (session('status'))
        <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('status') }}
        </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <div class="grid gap-6 sm:grid-cols-2">
                    <div class="space-y-2 sm:col-span-2">
                        <h2 class="text-sm font-semibold uppercase tracking-wider text-slate-500">Profil perusahaan</h2>
                        <p class="text-sm leading-7 text-slate-700">{{ $company->bio }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Lokasi</p>
                        <p class="mt-2 text-sm text-slate-900">{{ $company->location }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Website</p>
                        <a href="{{ $company->website_href }}" target="_blank" rel="noreferrer"
                            class="mt-2 inline-block text-sm text-slate-900 hover:text-slate-700">
                            {{ $company->website }}
                        </a>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Bidang perusahaan</p>
                        <p class="mt-2 text-sm text-slate-900">{{ $company->field }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Tahun berdiri</p>
                        <p class="mt-2 text-sm text-slate-900">{{ $company->established }}</p>
                    </div>

                    <div class="sm:col-span-2">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Fasilitas</p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach ($company->facility_items as $facility)
                                <span
                                    class="inline-flex items-center rounded-full bg-slate-100 px-3 py-2 text-xs font-medium text-slate-700">
                                    {{ $facility }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <aside class="space-y-6">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold text-slate-900">Logo perusahaan</p>
                <div class="mt-4 flex items-center justify-center rounded-3xl border border-slate-200 bg-slate-50 p-6">
                    <img src="{{ $company->logo_url }}" alt="{{ $company->name }} logo"
                        class="max-h-40 w-auto rounded-2xl object-contain">
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold text-slate-900">Aksi cepat</p>
                <div class="mt-4 grid gap-3">
                    <a href="{{ route('jp.company.detail', $company->public_slug) }}"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                        Lihat halaman publik
                    </a>
                    <a href="{{ route('admin.company.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                        Kembali ke daftar
                    </a>
                </div>
            </div>
        </aside>
    </div>
@endsection
