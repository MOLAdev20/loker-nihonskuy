@extends('layouts.admin')

@push("title")
<title>NihonSkuy - Data Loker</title>
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
          Loker
        </span>
      </li>
    </ol>
  </nav>
  <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
      <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
        Lowongan Kerja
      </h1>
      <p class="mt-2 text-sm text-slate-500">
        Kelola semua lowongan kerja
      </p>
    </div>
    <div>
      <a href="/admin/vacancy/create" class="inline-flex items-center justify-center rounded bg-slate-500 px-4 py-2 text-sm font-medium text-white hover:bg-slate-600">Tambah Job</a>
    </div>
  </div>
</div>

<div class="grid lg:grid-cols-4 grid-cols-1 gap-2 lg:gap-5">
  <div class="relative bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:bg-slate-50 transition-shadow duration-300">
    <div class="h-3 w-3 rounded-full bg-green-200 border animate-ping border-green-500 absolute top-2 right-2 {{ request('filter') ? "hidden" : ""  }}"></div>
    <p class="text-sm font-medium text-slate-500 mb-1">Jumlah Loker</p>
    <p class="text-3xl font-extrabold text-slate-950 tracking-tight">{{ $totalJobs }}</p>
    <p class="text-xs text-slate-400 mt-1">Seluruh lowongan kerja</p>
    <a href="{{ route("admin.vacancies") }}" class="absolute inset-0 opacity-0 z-10"></a>
  </div>
  <div class="relative bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:bg-slate-50 transition-shadow duration-300">
    <div class="h-3 w-3 rounded-full bg-green-200 border animate-ping border-green-500 absolute top-2 right-2 {{ request('filter') != "active" ? "hidden" : ""  }}"></div>
    <p class="text-sm font-medium text-slate-500 mb-1">Jumlah Loker Aktif</p>
    <p class="text-3xl font-extrabold text-green-700 tracking-tight">{{ $totalActiveJobs }}</p>
    <p class="text-xs text-slate-400 mt-1">Seluruh lowongan kerja</p>
    <a href="{{ route("admin.vacancies", ["filter" => "active"]) }}" class="absolute inset-0 opacity-0 z-10"></a>
  </div>
  <div class="relative bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:bg-slate-50 transition-shadow duration-300">
    <div class="h-3 w-3 rounded-full bg-green-200 border animate-ping border-green-500 absolute top-2 right-2 {{ request('filter') != "inactive" ? "hidden" : ""  }}"></div>
    <p class="text-sm font-medium text-slate-500 mb-1">Jumlah Loker Nonaktif</p>
    <p class="text-3xl font-extrabold text-red-600 tracking-tight">{{ $totalInactiveJobs }}</p>
    <p class="text-xs text-slate-400 mt-1">Seluruh lowongan kerja</p>
    <a href="{{ route("admin.vacancies", ["filter" => "inactive"]) }}" class="absolute inset-0 opacity-0 z-10"></a>
  </div>
  <div class="relative bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:bg-slate-50 transition-shadow duration-300 cursor-pointer">
    <div class="h-3 w-3 rounded-full bg-green-200 border animate-ping border-green-500 absolute top-2 right-2 {{ request('filter') != "on-going-expired" ? "hidden" : ""  }}"></div>
    <p class="text-sm font-medium text-slate-500 mb-1">Mendekati Tenggat</p>
    <p class="text-3xl font-extrabold text-slate-950 tracking-tight">{{ $onGoingExpired }}</p>
    <p class="text-xs text-slate-400 mt-1">Loker yang mendekati tenggat</p>
    <a href="{{ route("admin.vacancies", ["filter" => "on-going-expired"]) }}" class="absolute inset-0 opacity-0 z-10"></a>
  </div>
</div>

<div class="border rounded-lg border-slate-200 p-3 mt-5">
  <div class="grid grid-cols-1 gap-2 mt-2">
    <form method="GET" action="" class="w-full lg:w-90 relative">
        <label class="relative block">
            <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="7" />
                    <path d="M21 21l-4.3-4.3" />
                </svg>
            </span>
            <input
                class="w-full rounded-xl border border-slate-200 bg-white px-10 py-2 text-sm outline-none placeholder:text-slate-400 focus:border-slate-300 focus:ring-4 focus:ring-slate-100"
                placeholder="Cari..."
                name="q"
                value="{{ request("q") }}"
                type="text" />
        </label>
        <a href="{{ route("admin.vacancies") }}" class="absolute inset-y-0 right-3 flex items-center text-slate-400 {{ !request('q') ? "hidden" : "" }}"><x-icons.close/></a>
    </form>
    @forelse ($jobs as $job)
    <div class="relative rounded-md border border-slate-200 {{ $job->days_left > 0 ? 'bg-white' : 'bg-red-50' }} px-3 py-2">
      <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
        <div class="min-w-0">
          <div class="text-xs text-slate-500">{{ $job->job_code }}</div>
          <h3 class="truncate text-sm font-semibold text-slate-900">{{ $job->title }}</h3>
          <p class="truncate text-xs text-slate-600">{{ $job->placement }}</p>
          @if($job->days_left > 0)
          <p class="truncate text-xs text-green-600">{{ $job->days_left }} hari lagi sebelum ditutup</p>
          @else
          <p class="truncate text-xs text-red-600">Lowongan ini melewati tenggat waktu</p>
          @endif
        </div>
        <div class="mt-1 text-lg font-bold text-slate-600 sm:mt-0">{{ $job->salary_range }}</div>
      </div>

      <div class="mt-2 flex flex-wrap gap-1 text-[11px] text-slate-600">
        <span class="rounded bg-slate-100 px-2 py-0.5">{{ $job->job_type }}</span>
        <span class="rounded bg-slate-100 px-2 py-0.5">{{ $job->gender_requirement == 'p' ? 'Perempuan' : 'Laki-laki' }}</span>
        <span class="rounded bg-slate-100 px-2 py-0.5">
          {{ $job->domicile }}
        </span>
        <span class="rounded bg-slate-100 px-2 py-0.5">{{ $job->qty }} Orang</span>
      </div>

      <div class="mt-2 relative z-20">
        <a href="{{ route('admin.vacancy.detail', $job->job_code) }}" class="text-xs font-medium text-slate-600 hover:text-slate-800">Detail</a>
        <span class="mx-1 text-slate-300">•</span>
        <a href="{{ route("admin.vacancy.edit", $job->job_code) }}" class="text-xs font-medium text-slate-600 hover:text-slate-800">Edit</a>
        <span class="mx-1 text-slate-300">•</span>
        <form 
          method="post" 
          id="delete-vacancy-{{ $job->job_code }}" 
          action="{{ route("admin.vacancy.delete", $job->job_code) }}" 
          class="hidden"
        >
          @csrf
          @method("DELETE")
        </form>
        <button type="button" onclick="confirmDelete('delete-vacancy-{{ $job->job_code }}')" class="text-xs font-medium text-red-600 hover:text-red-800 cursor-pointer">Hapus</button>
      </div>

      <a href="{{ route("admin.vacancy.detail", $job->job_code) }}" class="absolute inset-0 opacity-0"></a>
    </div>
    @empty
    <div class="rounded-md border border-dashed border-slate-200 px-3 py-6 text-center text-sm text-slate-500">
      Belum ada loker
    </div>
    @endforelse
  </div>
</div>
@endsection

@section('scripts')
<script type="module">
  @if(session("msg"))
  const config = @js(session("msg"));
  Swal.fire(config[1], config[2], config[0]);
  @endif
</script>
<script>
  function confirmDelete(id)
  {
    Swal.fire({
      title: "Hapus Lowongan Ini?",
      text: "Data akan dihapus secara permanen",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Ya, hapus",
      cancelButtonText: "Batal",
      confirmButtonColor: "#b91c1c",
      cancelButtonColor: "#64748b",
      reverseButtons: true,
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById(id).submit();
      }
    });
  }
</script>
@endsection