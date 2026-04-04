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

<div class="border rounded-lg border-slate-200 p-3">
  <div class="grid grid-cols-1 gap-2">
    @forelse ($jobs as $job)
    <div class="rounded-md border border-slate-200 px-3 py-2">
      <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
        <div class="min-w-0">
          <div class="text-xs text-slate-500">{{ $job->job_code }}</div>
          <h3 class="truncate text-sm font-semibold text-slate-900">{{ $job->title }}</h3>
          <p class="truncate text-xs text-slate-600">{{ $job->placement }}</p>
        </div>
        <div class="mt-1 text-xs text-slate-600 sm:mt-0">{{ \App\Support\Currency::yen($job->salary) }}</div>
      </div>

      <div class="mt-2 flex flex-wrap gap-1 text-[11px] text-slate-600">
        <span class="rounded bg-slate-100 px-2 py-0.5">{{ $job->job_type }}</span>
        <span class="rounded bg-slate-100 px-2 py-0.5">{{ $job->gender_requirement == 'p' ? 'Perempuan' : 'Laki-laki' }}</span>
        <span class="rounded bg-slate-100 px-2 py-0.5">
          {{ $job->domicile_requirement === 'kokunai' ? 'Khusus Jepang' : 'Bebas' }}
        </span>
        <span class="rounded bg-slate-100 px-2 py-0.5">{{ $job->qty }} Orang</span>
      </div>

      <div class="mt-2">
        <a href="{{ route('admin.vacancy.detail', $job->job_code) }}" class="text-xs font-medium text-slate-600 hover:text-slate-800">Detail</a>
        <span class="mx-1 text-slate-300">•</span>
        <a href="{{ route("admin.vacancy.edit", $job->job_code) }}" class="text-xs font-medium text-slate-600 hover:text-slate-800">Edit</a>
        <span class="mx-1 text-slate-300">•</span>
        <form method="post" action="/admin/jobs/delete/{{ $job->job_code }}" class="inline js-delete-job-form">
          @csrf
          @method('DELETE')
          <button type="submit" class="text-xs font-medium text-red-600 hover:text-red-700">Hapus</button>
        </form>
      </div>
    </div>
    @empty
    <div class="rounded-md border border-dashed border-slate-200 px-3 py-6 text-center text-sm text-slate-500">
      Belum ada job yang diinput.
    </div>
    @endforelse
  </div>
</div>
@endsection

@section('scripts')
<script>
  const deleteJobForms = document.querySelectorAll(".js-delete-job-form");

  deleteJobForms.forEach((form) => {
    form.addEventListener("submit", async (event) => {
      event.preventDefault();

      if (typeof Swal === "undefined") {
        if (confirm("Hapus Lowongan Ini?\\nYakin ingin menghapus lowongan ini?")) {
          form.submit();
        }

        return;
      }

      const result = await Swal.fire({
        title: "Hapus Lowongan Ini?",
        text: "Yakin ingin menghapus lowongan ini?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, hapus",
        cancelButtonText: "Batal",
        confirmButtonColor: "#b91c1c",
        cancelButtonColor: "#64748b",
        reverseButtons: true,
      });

      if (result.isConfirmed) {
        form.submit();
      }
    });
  });
</script>
@endsection