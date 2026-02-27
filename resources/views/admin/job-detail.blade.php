@extends('layouts.admin')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.bubble.css" rel="stylesheet">
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
    <!-- Thumbnail row -->
    <div class="flex flex-col gap-3 col-span-8">
      <span class="text-sm text-slate-500">Thumbnail</span>
      @if($job->thumbnail_path)
      <div class="overflow-hidden rounded-xl border border-slate-200 bg-slate-50">
        <img
          src="{{ asset('storage/' . $job->thumbnail_path) }}"
          alt="Thumbnail {{ $job->title }}"
          class="h-56 w-full object-cover">
      </div>
      @else
      <div class="flex h-40 items-center justify-center rounded-xl border border-dashed border-slate-200 bg-slate-50 text-sm text-slate-400">
        Belum ada thumbnail
      </div>
      @endif

      <form method="post" action="/admin/jobs/{{ $job->job_code }}/thumbnail" enctype="multipart/form-data" class="flex flex-col gap-2">
        @csrf
        <label for="thumbnail" class="text-sm font-medium text-slate-600">Upload thumbnail baru</label>
        @error('thumbnail')
        <span class="text-[10px] text-red-600">{{ $message }}</span>
        @enderror
        <input
          type="file"
          name="thumbnail"
          id="thumbnail"
          accept="image/*"
          class="rounded border border-slate-300 bg-white px-3 py-2 text-sm">
        <span class="text-xs text-slate-400">Format: jpg, png, webp. Maks 2MB.</span>
        <button type="submit" class="mt-2 w-fit rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
          Simpan Thumbnail
        </button>
      </form>
    </div>

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
      <span class="text-sm text-slate-500">Benefit & Fasilitas</span>
      @php
      $benefits = $job->benefit ? array_filter(explode('|', $job->benefit)) : [];
      @endphp
      @if (count($benefits))
      <div class="flex flex-wrap gap-2">
        @foreach ($benefits as $benefit)
        <span class="inline-block rounded-full border border-slate-200 bg-white px-3 py-2 text-xs font-bold text-slate-600">
          {{ $benefit }}
        </span>
        @endforeach
      </div>
      @else
      <span class="text-xs text-slate-400">Belum ada benefit.</span>
      @endif
    </div>

    <!-- Fifth row -->
    <div class="flex flex-col gap-2 col-span-8 mt-5">
      <span class="text-sm text-slate-500">Informasi Tambahan</span>
      @php
      $additionalInformationRaw = $job->additional_information;
      $additionalInformationDelta = null;

      if (is_string($additionalInformationRaw)) {
      $decoded = json_decode($additionalInformationRaw, true);

      if (is_array($decoded) && isset($decoded['ops']) && is_array($decoded['ops'])) {
      $additionalInformationDelta = $decoded;
      }
      }
      @endphp

      @if($additionalInformationDelta)
      <div id="job-description-viewer" class="rounded border border-slate-200 bg-slate-50 p-3 text-sm"></div>
      @else
      <p class="text-sm text-slate-900 whitespace-pre-line">{!! nl2br(e($job->additional_information)) !!}</p>
      @endif
    </div>
  </div>
</div>
@endsection

@section('scripts')
@if($additionalInformationDelta)
<script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>
<script>
  const viewerTarget = document.getElementById("job-description-viewer");
  const descriptionDelta = @json($additionalInformationDelta);

  const quillViewer = new Quill(viewerTarget, {
    theme: "bubble",
    readOnly: true,
    modules: {
      toolbar: false
    }
  });

  quillViewer.setContents(descriptionDelta);
</script>
@endif
@endsection