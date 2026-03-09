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
          Edit Job
        </span>
      </li>
    </ol>
  </nav>
  <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
    Edit Job
  </h1>
  <p class="mt-2 text-sm text-slate-500">
    Perbarui info lowongan
  </p>
</div>

<div class="border rounded-lg border-slate-200 p-4 relative">
  <div class="absolute top-0 inset-x-0 bg-slate-400 text-xs text-white rounded-b-none rounded p-1">Informasi Umum Job</div>

  <form method="post" action="/admin/jobs/update/{{ $job->job_code }}">
    @csrf
    @method('PUT')
    <div class="block sm:grid grid-cols-8 gap-5 mt-8">

      <!-- First row -->
      <div class="flex flex-col gap-1 col-span-2">
        <label class="text-sm">Job ID</label>
        <input type="text" value="{{ $job->job_code }}" class="rounded outline-none border border-slate-200 py-1 px-2 text-sm bg-slate-50" disabled>
      </div>
      <div class="flex flex-col gap-1 col-span-4">
        <label for="job-title" class="text-sm">Nama Job</label>
        @error('job-title')
        <span class="text-[10px] text-red-600">{{ $message }}</span>
        @enderror
        <input type="text" name="job-title" id="job-title" value="{{ old('job-title', $job->title) }}" class=" rounded outline-none border py-1 px-2 text-sm focus:border transition-all {{ $errors->has('job-title') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }}">
      </div>
      <div class="flex flex-col gap-1 col-span-2">
        <label for="job-type" class="text-sm">Jenis Pekerjaan</label>
        @error('job-type')
        <span class="text-[10px] text-red-600">{{ $message }}</span>
        @enderror
        <select
          name="job-type"
          id="job-type"
          class=" rounded outline-none border py-1 px-2 text-sm focus:border transition-all {{ $errors->has('job-type') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }}">
          <option value="">Pilih</option>
          <option value="Pengolahan Makanan" @selected(old('job-type', $job->job_type)==='Pengolahan Makanan')>Pengolahan Makanan</option>
          <option value="Perhotelan" @selected(old('job-type', $job->job_type)==='Perhotelan')>Perhotelan</option>
          <option value="Perikanan" @selected(old('job-type', $job->job_type)==='Perikanan')>Perikanan</option>
          <option value="Driver" @selected(old('job-type', $job->job_type)==='Driver')>Driver</option>
          <option value="Pertanian" @selected(old('job-type', $job->job_type)==='Pertanian')>Pertanian</option>
          <option value="Kaigo" @selected(old('job-type', $job->job_type)==='Kaigo')>Kaigo</option>
          <option value="Lainnya" @selected(old('job-type', $job->job_type)==='Lainnya')>Lainnya</option>
        </select>
      </div>

      <!-- Second row -->
      <div class="flex flex-col gap-1 col-span-2">
        <label for="job-placement" class="text-sm">Penempatan</label>
        @error('job-placement')
        <span class="text-[10px] text-red-600">{{ $message }}</span>
        @enderror
        <select
          name="job-placement"
          id="job-placement"
          data-selected="{{ old('job-placement', $job->placement) }}"
          class=" rounded outline-none border py-1 px-2 text-sm focus:border transition-all {{ $errors->has('job-placement') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }}">
          <option value="">Pilih</option>
        </select>
      </div>
      <div class="flex flex-col gap-1 col-span-2">
        <label for="visa-type" class="text-sm">Tipe Visa</label>
        @error('visa-type')
        <span class="text-[10px] text-red-600">{{ $message }}</span>
        @enderror
        <input type="text" name="visa-type" id="visa-type" value="{{ old('visa-type', $job->visa_type) }}" class=" rounded outline-none border py-1 px-2 text-sm focus:border transition-all {{ $errors->has('visa-type') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }}">
      </div>
      <div class="flex flex-col gap-1 col-span-2">
        <label for="source" class="text-sm">Salinan Asli</label>
        @error('source')
        <span class="text-[10px] text-red-600">{{ $message }}</span>
        @enderror
        <input type="url" name="source" id="source" value="{{ old('source', $job->source) }}" placeholder="https://drive.google.com/..." class=" rounded outline-none border py-1 px-2 text-sm focus:border transition-all w-full {{ $errors->has('source') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }}">
      </div>
      <div class="flex flex-col gap-1 col-span-2">
        <label for="job-sallary" class="text-sm">Gaji</label>
        @error('job-sallary')
        <span class="text-[10px] text-red-600">{{ $message }}</span>
        @enderror
        <input type="text" name="job-sallary" id="job-sallary" value="{{ old('job-sallary', $job->salary) }}" class=" rounded outline-none border py-1 px-2 text-sm focus:border transition-all w-full {{ $errors->has('job-sallary') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }}">
        <span class="text-[10px] text-slate-400">Jika tidak ada, isi dengan -</span>
      </div>
      <div class="flex flex-col gap-1 col-span-2">
        <label for="whatsapp-number" class="text-sm">Nomor WhatsApp</label>
        @error('whatsapp-number')
        <span class="text-[10px] text-red-600">{{ $message }}</span>
        @enderror
        <input type="text" name="whatsapp-number" id="whatsapp-number" value="{{ old('whatsapp-number', $job->whatsapp_number) }}" class=" rounded outline-none border py-1 px-2 text-sm focus:border transition-all w-full {{ $errors->has('whatsapp-number') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }}">
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
          <option value="l" @selected(old('gender-requirement', $job->gender_requirement) === 'l')>Laki-laki</option>
          <option value="p" @selected(old('gender-requirement', $job->gender_requirement) === 'p')>Perempuan</option>
          <option value="a" @selected(old('gender-requirement', $job->gender_requirement) === 'a')>Laki-laki & Perempuan</option>
        </select>
      </div>
      <div class="flex flex-col gap-1 col-span-2">
        <label for="domicile-requirement" class="text-sm">Persyaratan Domisili</label>
        @error('domicile-requirement')
        <span class="text-[10px] text-red-600">{{ $message }}</span>
        @enderror
        <select name="domicile-requirement" id="domicile-requirement" class=" rounded outline-none border border-slate-300 py-1 px-2 text-sm focus:border-slate-500 focus:border transition-all">
          <option value="">Pilih</option>
          <option value="kokunai" @selected(old('domicile-requirement', $job->domicile_requirement) === 'kokunai')>Khusus Jepang</option>
          <option value="kokugai" @selected(old('domicile-requirement', $job->domicile_requirement) === 'kokugai')>Bebas (Di Luar Jepang)</option>
        </select>
      </div>
      <div class="flex flex-col gap-1 col-span-2">
        <label for="qty" class="text-sm">Kuantitas Dibutuhkan</label>
        @error('qty')
        <span class="text-[10px] text-red-600">{{ $message }}</span>
        @enderror
        <input type="number" name="qty" id="qty" value="{{ old('qty', $job->qty) }}" class=" rounded outline-none border py-1 px-2 text-sm focus:border transition-all {{ $errors->has('qty') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }}">
      </div>

      <!-- Fourth row -->
      <div class="gap-2 col-span-8 mt-5">
        <label class="text-sm">Benefit & Fasilitas</label>
        @php
        $selectedBenefits = old('benefit', $job->benefit ? explode('|', $job->benefit) : []);
        $selectedBenefits = is_array($selectedBenefits) ? $selectedBenefits : [];
        @endphp
        <div>
          <input type="checkbox" id="sallary" value="Gaji" name="benefit[]" @checked(in_array('Gaji', $selectedBenefits, true))>
          <label for="sallary">Gaji</label>
        </div>
        <div>
          <input type="checkbox" id="sallary-upgradable" value="Kenaikan Gaji" name="benefit[]" @checked(in_array('Kenaikan Gaji', $selectedBenefits, true))>
          <label for="sallary-upgradable">Kenaikan Gaji</label>
        </div>
        <div>
          <input type="checkbox" id="paid-overtime" value="Lembur" name="benefit[]" @checked(in_array('Lembur', $selectedBenefits, true))>
          <label for="paid-overtime">Lembur</label>
        </div>
        <div>
          <input type="checkbox" id="night-shift" value="Shift Malam" name="benefit[]" @checked(in_array('Shift Malam', $selectedBenefits, true))>
          <label for="night-shift">Shift Malam</label>
        </div>
        <div>
          <input type="checkbox" id="tg2-support" value="Support TG2" name="benefit[]" @checked(in_array('Support TG2', $selectedBenefits, true))>
          <label for="tg2-support">Support TG2</label>
        </div>
        <div>
          <input type="checkbox" id="kaigo-support" value="Support Kaigo" name="benefit[]" @checked(in_array('Support Kaigo', $selectedBenefits, true))>
          <label for="kaigo-support">Support Kaigo</label>
        </div>
        <div>
          <input type="checkbox" id="bonus" value="Bonus" name="benefit[]" @checked(in_array('Bonus', $selectedBenefits, true))>
          <label for="bonus">Bonus</label>
        </div>
        <div>
          <input type="checkbox" id="free-meal" value="Makan Gratis" name="benefit[]" @checked(in_array('Makan Gratis', $selectedBenefits, true))>
          <label for="free-meal">Makan Gratis</label>
        </div>
        <div>
          <input type="checkbox" id="dorm" value="Asrama" name="benefit[]" @checked(in_array('Asrama', $selectedBenefits, true))>
          <label for="dorm">Asrama</label>
        </div>
        <div>
          <input type="checkbox" id="dorm-allowance" value="Tunjangan Asrama" name="benefit[]" @checked(in_array('Tunjangan Asrama', $selectedBenefits, true))>
          <label for="dorm-allowance">Tunjangan Asrama</label>
        </div>
        <div>
          <input type="checkbox" id="vehicle-allowance" value="Tunjangan Kendaraan" name="benefit[]" @checked(in_array('Tunjangan Kendaraan', $selectedBenefits, true))>
          <label for="vehicle-allowance">Tunjangan Kendaraan</label>
        </div>
        <div>
          <input type="checkbox" id="pig-tollerant" value="Toleransi Babi" name="benefit[]" @checked(in_array('Toleransi Babi', $selectedBenefits, true))>
          <label for="pig-tollerant">Toleransi Babi</label>
        </div>
        <div>
          <input type="checkbox" id="pray-tollerant" value="Toleransi Ibadah" name="benefit[]" @checked(in_array('Toleransi Ibadah', $selectedBenefits, true))>
          <label for="pray-tollerant">Toleransi Ibadah</label>
        </div>
      </div>

      <!-- Fivth row -->
      <div class="flex flex-col gap-2 col-span-8 mt-5">
        <label for="additional-information" class="text-sm">Informasi Tambahan</label>
        @error('additional-information')
        <span class="text-[10px] text-red-600">{{ $message }}</span>
        @enderror
        <span class="text-xs text-slate-400">Tambahkan deskripsi pekerjaan, persyaratan khusus, bonus dan lain sebagainya</span>
        <input type="hidden" name="additional-information" id="additional-information" value="{{ old('additional-information', $job->additional_information) }}">
        <div id="additional-information-editor" class="rounded border text-sm {{ $errors->has('additional-information') ? 'border-red-500' : 'border-slate-300' }}"></div>
      </div>
    </div>

    <div class="block sm:grid grid-cols-8 gap-5 mt-2">
      <div class="col-span-8">
        <button type="submit" class="p-2 bg-slate-500 text-white w-full hover:bg-slate-600 active:scale-[0.98] active:bg-slate-600 transition-all">Simpan Perubahan</button>
      </div>
    </div>
  </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>

@php
$jobInformation = $job->additional_information
@endphp

<script>
  const additionalInformationInput = document.getElementById("additional-information");
  const additionalInformationEditor = document.getElementById("additional-information-editor");
  const initialAdditionalInformation = @json(old('additional-information', $jobInformation));

  const quill = new Quill(additionalInformationEditor, {
    theme: "snow",
    placeholder: "Tulis deskripsi pekerjaan di sini...",
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

  const placementSelect = document.getElementById("job-placement");
  if (placementSelect) {
    const selectedPlacement = (placementSelect.dataset.selected || "").trim().toLowerCase();
    fetch("/japan.json")
      .then((response) => response.json())
      .then((data) => {
        const prefectures = Array.isArray(data.japan_prefectures) ? data.japan_prefectures : [];
        prefectures.forEach((prefecture) => {
          const option = document.createElement("option");
          option.value = prefecture;
          option.textContent = prefecture;
          if (String(prefecture).trim().toLowerCase() === selectedPlacement) {
            option.selected = true;
          }
          placementSelect.appendChild(option);
        });
      });
  }
</script>
@endsection