@extends('layouts.admin')

@push("title")
<title>NihonSkuy - Detail Loker</title>
@endpush

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.bubble.css" rel="stylesheet">
{{-- <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet"> --}}
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
        <a href="{{ route("admin.vacancies") }}" class="hover:text-slate-700">
          Loker
        </a>
      </li>

      <li class="flex items-center gap-2">
        <span class="text-slate-400">/</span>
        <span class="font-medium text-slate-700">
          Detail Loker
        </span>
      </li>
    </ol>
  </nav>
  <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
    Detail Loker
  </h1>
  <p class="mt-2 text-sm text-slate-500">
    Ringkasan informasi lowongan
  </p>
</div>

<div class="border rounded-lg border-slate-200 p-4 relative">
  <div class="absolute top-0 inset-x-0 bg-slate-400 text-xs text-white rounded-b-none rounded p-1">Informasi Umum Job</div>

  <!-- Thumbnail row -->
  <div class="flex flex-col gap-3 mt-4">
    @if($job->thumbnail_path)
    <div onclick="document.getElementById('thumbnail').click()" class="overflow-hidden rounded-xl border border-slate-200 bg-slate-50 cursor-pointer">
      <img
        src="{{ asset('storage/' . $job->thumbnail_path) }}"
        alt="Thumbnail {{ $job->title }}"
        class="h-56 w-full object-cover">
    </div>
    @else
    <div onclick="document.getElementById('thumbnail').click()" class="flex flex-col h-40 items-center justify-center rounded-xl border border-dashed border-slate-200 bg-slate-50 text-sm text-slate-400 cursor-pointer">
      <p>Belum ada thumbnail.</p>
      <p class="font-medium text-blue-400">Klik untuk upload</p>
      <span class="mt-3 text-xs text-slate-400">Format: jpg, png, webp. Maks 2MB.</span>
    </div>
    @endif

    <form method="post" action="{{ route("admin.vacancy.upload-thumbnail", $job->job_code) }}" enctype="multipart/form-data" class="flex flex-col gap-2">
      @csrf
      @error('thumbnail')
      <span class="text-[10px] text-red-600">{{ $message }}</span>
      @enderror
      <input
        type="file"
        name="thumbnail"
        id="thumbnail"
        accept="image/*"
        class="rounded border border-slate-300 bg-white px-3 py-2 text-sm hidden"
        onchange="this.form.submit()"
        >
    </form>
  </div>

  <div class="sm:grid grid-cols-8 gap-3 bg-white p-3 rounded-lg border border-slate-200 shadow">
    <!-- First row -->
    <div class="flex flex-col gap-1 col-span-2">
      <span class="text-sm text-slate-500">Job ID / Kode Lowongan</span>
      <div class="flex items-center gap-2 group" id="job-code-container">
        <span id="job-code-text" class="text-sm font-medium text-slate-900">{{ $job->job_code }}</span>
        <button type="button" onclick="toggleEditJobCode()" class="text-slate-400 hover:text-slate-600 transition-colors">
            <x-icons.pencil size="14" />
        </button>
      </div>
      <div id="job-code-edit-container" class="hidden flex flex-col gap-1">
          <input type="text" id="job-code-input" value="{{ $job->job_code }}" 
                 class="text-sm font-medium text-slate-900 border border-slate-300 rounded px-2 py-1 outline-none focus:border-slate-500 w-full"
                 onkeydown="handleJobCodeKeydown(event)">
          <span id="job-code-error" class="text-[10px] text-red-600 hidden"></span>
          <span id="job-code-success" class="text-[10px] text-green-600 hidden"></span>
      </div>
    </div>
    <div class="flex flex-col gap-1 col-span-2">
      <span class="text-sm text-slate-500">Nama Pekerjaan</span>
      <span class="text-sm font-medium text-slate-900">{{ $job->title }}</span>
    </div>

    <!-- Second row -->
    <div class="flex flex-col gap-1 col-span-2">
      <span class="text-sm text-slate-500">Jenis Pekerjaan</span>
      <span class="text-sm font-medium text-slate-900">{{ $job->job_type }}</span>
    </div>
    <div class="flex flex-col gap-1 col-span-2">
      <span class="text-sm text-slate-500">Penempatan</span>
      <span class="text-sm font-medium text-slate-900">{{ $job->placement }}</span>
    </div>
    <div class="flex flex-col gap-1 col-span-2">
      <span class="text-sm text-slate-500">Jenis VISA</span>
      <span class="text-sm font-medium text-slate-900">{{ $job->visa_type }}</span>
    </div>
    <div class="flex flex-col gap-1 col-span-2">
      <span class="text-sm text-slate-500">Range Gaji</span>
      <span class="text-sm font-medium text-slate-900">{{ $job->salary_range }}</span>
    </div>

    <!-- Third row -->
    <div class="flex flex-col gap-1 col-span-2">
      <span class="text-sm text-slate-500">Persyaratan Gender</span>
      <span class="text-sm font-medium text-slate-900">{{ $job->gender }}</span>
    </div>
    <div class="flex flex-col gap-1 col-span-2">
      <span class="text-sm text-slate-500">Persyaratan Domisili</span>
      <span class="text-sm font-medium text-slate-900">{{ $job->domicile }}</span>
    </div>
    <div class="flex flex-col gap-1 col-span-2">
      <span class="text-sm text-slate-500">Kuantitas Dibutuhkan</span>
      <span class="text-sm font-medium text-slate-900">{{ $job->qty }} Orang</span>
    </div>
    <div class="flex flex-col gap-1 col-span-2">
      <span class="text-sm text-slate-500">Batas Waktu Pendaftaran</span>
      <span class="text-sm font-medium {{ $job->days_left < 0 ? "text-red-500" : "text-slate-900" }}">
        {{ date('d F Y', strtotime($job->expired_at)) }}
      </span>
      @if($job->days_left < 0)
      <small class="text-xs -mt-1 text-red-300">Lowongan ini sudah mencapai tenggat waktu</small>
      @else
      <small class="text-xs -mt-1 text-red-300">{{ $job->days_left }} Hari lagi sebelum ditutup</small>
      @endif
    </div>
    <div class="flex flex-col gap-1 col-span-2">
      <span class="text-sm text-slate-500">Status Lowongan</span>
      <form
        method="post"
        action="{{ route("admin.vacancy.change-status", $job->job_code) }}"
        id="change-status-{{  $job->job_code }}"
        >
          @csrf
      </form>
      <button 
        type="button" 
        onclick="confirmChangeStatus('change-status-{{  $job->job_code }}')" 
        class='text-sm flex items-center gap-1 font-medium {{ $job->status ? "text-green-600" : "text-red-600" }}  cursor-pointer'>
          @if($job->status)
          <x-icons.pause size="15"/> Aktif
          @else
          <x-icons.play size="15"/> Tidak Aktif
          @endif
      </button>
    </div>

    <!-- Fourth row -->
    <div class="flex flex-col gap-2 col-span-8 mt-5">
      <span class="text-sm text-slate-500">Benefit & Fasilitas</span>
      <div class="flex flex-wrap gap-2">
        @forelse ($job->benefit_and_facility as $benefit)
        <span class="inline-block rounded-full border border-slate-200 bg-white px-3 py-2 text-xs font-bold text-slate-600">
          {{ $benefit }}
        </span>
        @empty
        <span class="text-xs text-slate-400">Belum ada benefit.</span>
        @endforelse
      </div>
    </div>

    <!-- Fifth row -->
    <div class="flex flex-col gap-2 col-span-8 mt-5">
      <span class="text-sm text-slate-500">Informasi Tambahan</span>

      @if($job->additional_information_delta)
      <div id="job-description-viewer" class="rounded border border-slate-200 bg-slate-50 p-3 text-sm"></div>
      @else
      <p class="text-sm text-slate-900 whitespace-pre-line">{!! nl2br(e($job->additional_information)) !!}</p>
      @endif
    </div>
  </div>
</div>
@endsection

@section('scripts')
@if($job->additionalInformationDelta)
<script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>
<script>
  const viewerTarget = document.getElementById("job-description-viewer");
  const descriptionDelta = @json($job->additionalInformationDelta);

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

<script type="module">
  @if(session('msg'))
  const config = @js(session('msg'));
  Swal.fire(config[1], config[2], config[0]);
  @endif
</script>

<script>
  let currentJobCode = '{{ $job->job_code }}';

  function toggleEditJobCode() {
    const textContainer = document.getElementById('job-code-container');
    const editContainer = document.getElementById('job-code-edit-container');
    const input = document.getElementById('job-code-input');
    
    textContainer.classList.add('hidden');
    editContainer.classList.remove('hidden');
    input.focus();
    input.select();
  }

  function hideEditJobCode() {
    const textContainer = document.getElementById('job-code-container');
    const editContainer = document.getElementById('job-code-edit-container');
    const errorSpan = document.getElementById('job-code-error');
    const input = document.getElementById('job-code-input');
    
    textContainer.classList.remove('hidden');
    editContainer.classList.add('hidden');
    errorSpan.classList.add('hidden');
    input.value = currentJobCode;
  }

  function handleJobCodeKeydown(event) {
    if (event.key === 'Enter') {
      submitJobCodeUpdate();
    } else if (event.key === 'Escape') {
      hideEditJobCode();
    }
  }

  function submitJobCodeUpdate() {
    const input = document.getElementById('job-code-input');
    const newJobCode = input.value.trim();
    const errorSpan = document.getElementById('job-code-error');
    const successSpan = document.getElementById('job-code-success');
    const textSpan = document.getElementById('job-code-text');

    if (newJobCode === currentJobCode) {
      hideEditJobCode();
      return;
    }

    errorSpan.classList.add('hidden');
    successSpan.classList.add('hidden');

    const baseUrl = "{{ route('admin.vacancy.update-job-code', 'PLACEHOLDER') }}";
    const updateUrl = baseUrl.replace('PLACEHOLDER', currentJobCode);

    fetch(updateUrl, {
      method: 'PATCH',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json'
      },
      body: JSON.stringify({ job_code: newJobCode })
    })
    .then(async response => {
      const data = await response.json();
      if (response.ok) {
        if (data.status === 'success') {
          const oldJobCode = currentJobCode;
          currentJobCode = data.job_code;
          textSpan.innerText = currentJobCode;
          successSpan.innerText = 'ID berhasil dirubah';
          successSpan.classList.remove('hidden');
          
          setTimeout(() => {
            hideEditJobCode();
            successSpan.classList.add('hidden');
            
            // Update URL without refresh
            const newUrl = window.location.pathname.replace(oldJobCode, currentJobCode);
            window.history.replaceState(null, '', newUrl);
          }, 1000);
        } else if (data.status === 'unchanged') {
          hideEditJobCode();
        }
      } else {
        errorSpan.innerText = data.errors?.job_code?.[0] || 'Gagal mengubah ID';
        errorSpan.classList.remove('hidden');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      errorSpan.innerText = 'Terjadi kesalahan sistem';
      errorSpan.classList.remove('hidden');
    });
  }

  function confirmChangeStatus(id){
    Swal.fire({
      title: "Ubah Status Lowongan?",
      text: "Status lowongan akan diubah",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Ya, ubah",
      cancelButtonText: "Batal",
      confirmButtonColor: "#52a447",
      reverseButtons: true,
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById(id).submit();
      }
    });
  }
</script>
@endsection