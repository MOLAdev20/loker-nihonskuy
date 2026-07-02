@extends('layouts.admin')

@push('title')
    <title>NihonSkuy - Edit Perusahaan Jepang</title>
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
                    <span class="font-medium text-slate-700">Edit</span>
                </li>
            </ol>
        </nav>

        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Edit Perusahaan Jepang</h1>
        <p class="mt-2 text-sm text-slate-500">Perbarui informasi perusahaan tanpa mengubah struktur halaman publik.</p>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <form method="POST" action="{{ route('admin.company.update', $company) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.company._form', ['submitLabel' => 'Update Perusahaan', 'company' => $company])
        </form>
    </div>
@endsection
