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
          Buat Job
        </span>
      </li>
    </ol>
  </nav>
  <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
    Buat Job
  </h1>
  <p class="mt-2 text-sm text-slate-500">
    Buat info lowongan terbaru
  </p>
</div>

<div class="border rounded-lg border-slate-200 p-4 relative">
  <div class="absolute top-0 inset-x-0 bg-slate-400 text-xs text-white rounded-b-none rounded p-1">Informasi Umum Job</div>

  <form method="post" action="/admin/jobs/insert">
    @csrf
    <div class="block sm:grid grid-cols-8 gap-5 mt-8">

      <!-- First row -->
      <div class="flex flex-col gap-1 col-span-2">
        <label for="job-id" class="text-sm">Job ID</label>
        <input type="text" name="job-id" id="job-id" class=" rounded outline-none border border-slate-300 py-1 px-2 text-sm focus:border-slate-500 focus:border transition-all">
      </div>
      <div class="flex flex-col gap-1 col-span-6">
        <label for="job-title" class="text-sm">Nama Job</label>
        <input type="text" name="job-title" id="job-title" class=" rounded outline-none border border-slate-300 py-1 px-2 text-sm focus:border-slate-500 focus:border transition-all">
      </div>

      <!-- Second row -->
      <div class="flex flex-col gap-1 col-span-2">
        <label for="company" class="text-sm">Nama Perusahaan</label>
        <input type="text" name="company" id="company" class=" rounded outline-none border border-slate-300 py-1 px-2 text-sm focus:border-slate-500 focus:border transition-all">
      </div>
      <div class="flex flex-col gap-1 col-span-2">
        <label for="job-placement" class="text-sm">Penempatan</label>
        <input type="text" name="job-placement" id="job-placement" class=" rounded outline-none border border-slate-300 py-1 px-2 text-sm focus:border-slate-500 focus:border transition-all">
      </div>
      <div class="flex flex-col gap-1 col-span-2">
        <label for="job-type" class="text-sm">Jenis Pekerjaan</label>
        <input type="text" name="job-type" id="job-type" class=" rounded outline-none border border-slate-300 py-1 px-2 text-sm focus:border-slate-500 focus:border transition-all">
      </div>
      <div class="flex flex-col gap-1 col-span-2">
        <label for="job-sallary" class="text-sm">Gaji</label>
        <input type="text" name="job-sallary" id="job-sallary" class=" rounded outline-none border border-slate-300 py-1 px-2 text-sm focus:border-slate-500 focus:border transition-all w-full">
        <span class="text-[10px] text-slate-400">Jika tidak ada, isi dengan -</span>
      </div>

      <!-- Third row -->
      <div class="flex flex-col gap-1 col-span-2">
        <label for="gender-requirement" class="text-sm">Persyaratan Gender</label>
        <select name="gender-requirement" id="gender-requirement" class=" rounded outline-none border border-slate-300 py-1 px-2 text-sm focus:border-slate-500 focus:border transition-all">
          <option value="">Pilih</option>
          <option value="l">Laki-laki</option>
          <option value="p">Perempuan</option>
        </select>
      </div>
      <div class="flex flex-col gap-1 col-span-2">
        <label for="domicile-requirement" class="text-sm">Persyaratan Domisili</label>
        <select name="domicile-requirement" id="domicile-requirement" class=" rounded outline-none border border-slate-300 py-1 px-2 text-sm focus:border-slate-500 focus:border transition-all">
          <option value="">Pilih</option>
          <option value="kokunai">Khusus Jepang</option>
          <option value="kokugai">Bebas (Di Luar Jepang)</option>
        </select>
      </div>

      <!-- Fourth row -->
      <div class="flex flex-col gap-2 col-span-8 mt-5">
        <label for="additional-information" class="text-sm">Informasi Tambahan</label>
        <span class="text-xs text-slate-400">Tambahkan deskripsi pekerjaan, persyaratan khusus, bonus dan lain sebagainya</span>
        <textarea rows="10" name="additional-information" id="additional-information" class="rounded outline-none border border-slate-300 py-1 px-2 text-sm focus:border-slate-500 focus:border transition-all"></textarea>
      </div>
    </div>

    <div class="block sm:grid grid-cols-8 gap-5 mt-2">
      <div class="col-span-8">
        <button type="submit" class="p-2 bg-slate-500 text-white w-full hover:bg-slate-600 active:scale-[0.98] active:bg-slate-600 transition-all">Simpan</button>
      </div>
    </div>
  </form>
</div>
@endsection