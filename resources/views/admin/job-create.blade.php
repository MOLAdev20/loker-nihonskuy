@extends('layouts.admin')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">
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
        @error('job-id')
        <span class="text-[10px] text-red-600">{{ $message }}</span>
        @enderror
        <input type="text" name="job-id" id="job-id" value="{{ old('job-id') }}" class=" rounded outline-none border py-1 px-2 text-sm focus:border transition-all {{ $errors->has('job-id') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }}">
      </div>
      <div class="flex flex-col gap-1 col-span-6">
        <label for="job-title" class="text-sm">Nama Job</label>
        @error('job-title')
        <span class="text-[10px] text-red-600">{{ $message }}</span>
        @enderror
        <input type="text" name="job-title" id="job-title" value="{{ old('job-title') }}" class=" rounded outline-none border py-1 px-2 text-sm focus:border transition-all {{ $errors->has('job-title') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }}">
      </div>

      <!-- Second row -->
      <div class="flex flex-col gap-1 col-span-2">
        <label for="company" class="text-sm">Nama Perusahaan</label>
        @error('company')
        <span class="text-[10px] text-red-600">{{ $message }}</span>
        @enderror
        <input type="text" name="company" id="company" value="{{ old('company') }}" class=" rounded outline-none border py-1 px-2 text-sm focus:border transition-all {{ $errors->has('company') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }}">
      </div>
      <div class="flex flex-col gap-1 col-span-2">
        <label for="job-placement" class="text-sm">Penempatan</label>
        @error('job-placement')
        <span class="text-[10px] text-red-600">{{ $message }}</span>
        @enderror
        <input type="text" name="job-placement" id="job-placement" value="{{ old('job-placement') }}" class=" rounded outline-none border py-1 px-2 text-sm focus:border transition-all {{ $errors->has('job-placement') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }}">
      </div>
      <div class="flex flex-col gap-1 col-span-2">
        <label for="job-type" class="text-sm">Jenis Pekerjaan</label>
        @error('job-type')
        <span class="text-[10px] text-red-600">{{ $message }}</span>
        @enderror
        <input type="text" name="job-type" id="job-type" value="{{ old('job-type') }}" class=" rounded outline-none border py-1 px-2 text-sm focus:border transition-all {{ $errors->has('job-type') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }}">
      </div>
      <div class="flex flex-col gap-1 col-span-2">
        <label for="job-sallary" class="text-sm">Gaji</label>
        @error('job-sallary')
        <span class="text-[10px] text-red-600">{{ $message }}</span>
        @enderror
        <input type="text" name="job-sallary" id="job-sallary" value="{{ old('job-sallary') }}" class=" rounded outline-none border py-1 px-2 text-sm focus:border transition-all w-full {{ $errors->has('job-sallary') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }}">
        <span class="text-[10px] text-slate-400">Jika tidak ada, isi dengan -</span>
      </div>
      <div class="flex flex-col gap-1 col-span-2">
        <label for="whatsapp-number" class="text-sm">Nomor WhatsApp</label>
        @error('whatsapp-number')
        <span class="text-[10px] text-red-600">{{ $message }}</span>
        @enderror
        <input type="text" name="whatsapp-number" id="whatsapp-number" value="{{ old('whatsapp-number') }}" class="rounded outline-none border py-1 px-2 text-sm focus:border transition-all w-full {{ $errors->has('whatsapp-number') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }}">
        <span class="text-[10px] text-slate-400">Gunakan format internasional, contoh: 62812xxxxxxx</span>
      </div>

      <!-- Third row -->
      <div class="flex flex-col gap-1 col-span-2">
        <label for="gender-requirement" class="text-sm">Persyaratan Gender</label>
        @error('gender-requirement')
        <span class="text-[10px] text-red-600">{{ $message }}</span>
        @enderror
        <select name="gender-requirement" id="gender-requirement" class=" rounded outline-none border border-slate-300 py-1 px-2 text-sm focus:border-slate-500 focus:border transition-all">
          <option value="">Pilih</option>
          <option value="l" @selected(old('gender-requirement')==='l' )>Laki-laki</option>
          <option value="p" @selected(old('gender-requirement')==='p' )>Perempuan</option>
        </select>
      </div>
      <div class="flex flex-col gap-1 col-span-2">
        <label for="domicile-requirement" class="text-sm">Persyaratan Domisili</label>
        @error('domicile-requirement')
        <span class="text-[10px] text-red-600">{{ $message }}</span>
        @enderror
        <select name="domicile-requirement" id="domicile-requirement" class=" rounded outline-none border border-slate-300 py-1 px-2 text-sm focus:border-slate-500 focus:border transition-all">
          <option value="">Pilih</option>
          <option value="kokunai" @selected(old('domicile-requirement')==='kokunai' )>Khusus Jepang</option>
          <option value="kokugai" @selected(old('domicile-requirement')==='kokugai' )>Bebas (Di Luar Jepang)</option>
        </select>
      </div>
      <div class="flex flex-col gap-1 col-span-2">
        <label for="qty" class="text-sm">Kuantitas Dibutuhkan</label>
        @error('qty')
        <span class="text-[10px] text-red-600">{{ $message }}</span>
        @enderror
        <input type="number" name="qty" id="qty" value="{{ old('qty') }}" class=" rounded outline-none border py-1 px-2 text-sm focus:border transition-all {{ $errors->has('qty') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }}">
      </div>

      <!-- Fourth row -->
      <div class="flex flex-col gap-2 col-span-8 mt-5">
        <label for="additional-information" class="text-sm">Informasi Tambahan</label>
        @error('additional-information')
        <span class="text-[10px] text-red-600">{{ $message }}</span>
        @enderror
        <span class="text-xs text-slate-400">Tambahkan deskripsi pekerjaan, persyaratan khusus, bonus dan lain sebagainya</span>
        <input type="hidden" name="additional-information" id="additional-information" value="{{ old('additional-information') }}">
        <div id="additional-information-editor" class="rounded border text-sm {{ $errors->has('additional-information') ? 'border-red-500' : 'border-slate-300' }}"></div>
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

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>
<script>
  const additionalInformationInput = document.getElementById("additional-information");
  const additionalInformationEditor = document.getElementById("additional-information-editor");
  const initialAdditionalInformation = @json(old('additional-information', ''));

  const quill = new Quill(additionalInformationEditor, {
    theme: "snow",
    modules: {
      toolbar: [
        [{
          header: [1, 2, 3, false]
        }],
        ["bold", "italic", "underline", "strike"],
        [{
          list: "ordered"
        }, {
          list: "bullet"
        }],
        ["blockquote", "link"],
        ["clean"]
      ]
    }
  });

  const isValidDelta = (value) => {
    return value && typeof value === "object" && Array.isArray(value.ops);
  };

  let parsedInitialValue = null;

  if (typeof initialAdditionalInformation === "string" && initialAdditionalInformation.trim() !== "") {
    try {
      parsedInitialValue = JSON.parse(initialAdditionalInformation);
    } catch (e) {
      parsedInitialValue = null;
    }
  }

  if (isValidDelta(parsedInitialValue)) {
    quill.setContents(parsedInitialValue);
  } else if (initialAdditionalInformation) {
    quill.setText(initialAdditionalInformation);
  }

  const syncQuillDeltaToInput = () => {
    additionalInformationInput.value = JSON.stringify(quill.getContents());
  };

  syncQuillDeltaToInput();
  quill.on("text-change", syncQuillDeltaToInput);
</script>
@endsection
