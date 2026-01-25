@extends('layouts.admin')

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
        <a href="#" class="hover:text-slate-700">
          Job
        </a>
      </li>

      <li class="flex items-center gap-2">
        <span class="text-slate-400">/</span>
        <span class="font-medium text-slate-700">
          Detail Job
        </span>
      </li>
    </ol>
  </nav>
  <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
    Detail Job
  </h1>
  <p class="mt-2 text-sm text-slate-500">
    Ringkasan informasi lowongan
  </p>
</div>

<div class="border rounded-lg border-slate-200 p-4 relative">
  <div class="absolute top-0 inset-x-0 bg-slate-400 text-xs text-white rounded-b-none rounded p-1">Informasi Umum Job</div>

  <div class="block sm:grid grid-cols-8 gap-5 mt-8">
    <!-- First row -->
    <div class="flex flex-col gap-1 col-span-2">
      <span class="text-sm text-slate-500">Job ID</span>
      <span class="text-sm font-medium text-slate-900">{{ $job->job_code }}</span>
    </div>
    <div class="flex flex-col gap-1 col-span-6">
      <span class="text-sm text-slate-500">Nama Job</span>
      <span class="text-sm font-medium text-slate-900">{{ $job->title }}</span>
    </div>

    <!-- Second row -->
    <div class="flex flex-col gap-1 col-span-2">
      <span class="text-sm text-slate-500">Nama Perusahaan</span>
      <span class="text-sm font-medium text-slate-900">{{ $job->company_name }}</span>
    </div>
    <div class="flex flex-col gap-1 col-span-2">
      <span class="text-sm text-slate-500">Penempatan</span>
      <span class="text-sm font-medium text-slate-900">{{ $job->placement }}</span>
    </div>
    <div class="flex flex-col gap-1 col-span-2">
      <span class="text-sm text-slate-500">Jenis Pekerjaan</span>
      <span class="text-sm font-medium text-slate-900">{{ $job->job_type }}</span>
    </div>
    <div class="flex flex-col gap-1 col-span-2">
      <span class="text-sm text-slate-500">Gaji</span>
      <span class="text-sm font-medium text-slate-900">{{ $job->salary }}</span>
    </div>

    <!-- Third row -->
    <div class="flex flex-col gap-1 col-span-2">
      <span class="text-sm text-slate-500">Persyaratan Gender</span>
      <span class="text-sm font-medium text-slate-900">{{ $job->gender_requirement === 'l' ? 'Laki-laki' : 'Perempuan' }}</span>
    </div>
    <div class="flex flex-col gap-1 col-span-2">
      <span class="text-sm text-slate-500">Persyaratan Domisili</span>
      <span class="text-sm font-medium text-slate-900">{{ $job->domicile_requirement === 'kokunai' ? 'Khusus Jepang' : 'Bebas (Di Luar Jepang)' }}</span>
    </div>
    <div class="flex flex-col gap-1 col-span-2">
      <span class="text-sm text-slate-500">Kuantitas Dibutuhkan</span>
      <span class="text-sm font-medium text-slate-900">{{ $job->qty }}</span>
    </div>

    <!-- Fourth row -->
    <div class="flex flex-col gap-2 col-span-8 mt-5">
      <span class="text-sm text-slate-500">Informasi Tambahan</span>
      <p class="text-sm text-slate-900 whitespace-pre-line">{!! nl2br(e($job->additional_information)) !!}</p>
    </div>
  </div>
</div>
@endsection
