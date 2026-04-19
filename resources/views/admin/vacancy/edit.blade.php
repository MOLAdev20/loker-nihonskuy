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
            Loker
          </a>
        </li>

        <li class="flex items-center gap-2">
          <span class="text-slate-400">/</span>
          <span class="font-medium text-slate-700">
            Edit Loker
          </span>
        </li>
      </ol>
    </nav>
    <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
      Edit Loker
    </h1>
    <p class="mt-2 text-sm text-slate-500">
      Perbarui info lowongan
    </p>
  </div>

  <div class="relative rounded-lg border border-slate-200 p-4">
    <div class="absolute inset-x-0 top-0 rounded rounded-b-none bg-slate-400 p-1 text-xs text-white">
      Informasi Umum Job</div>

    <form method="post" action="{{ route('admin.vacancy.update', $job->job_code) }}">
      @csrf
      @method('PUT')
      <div class="mt-8 block grid-cols-8 gap-5 sm:grid">

        <!-- First row -->
        <div class="col-span-4 flex flex-col gap-1">
          <label for="job-title" class="text-sm">Nama Pekerjaan</label>
          @error('job-title')
            <span class="text-[10px] text-red-600">{{ $message }}</span>
          @enderror
          <input type="text" name="job-title" id="job-title"
            value="{{ old('job-title', $job->title) }}"
            class="{{ $errors->has('job-title') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }} rounded border bg-white px-2 py-1 text-sm outline-none transition-all focus:border">
        </div>
        <div class="col-span-4 flex flex-col gap-1">
          <label for="job-type" class="text-sm">Jenis Pekerjaan</label>
          @error('job-type')
            <span class="text-[10px] text-red-600">{{ $message }}</span>
          @enderror
          <select name="job-type" id="job-type"
            class="{{ $errors->has('job-type') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }} rounded border bg-white px-2 py-1 text-sm outline-none transition-all focus:border">
            <option value="">Pilih</option>
            <option value="Restoran" @selected(old('job-type', $job->job_type) === 'Restoran')>Restoran</option>
            <option value="Perawat Lansia" @selected(old('job-type', $job->job_type) === 'Perawat Lansia')>Perawat Lansia</option>
            <option value="Perawat Disabilitas" @selected(old('job-type', $job->job_type) === 'Perawat Disabilitas')>Perawat Disabilitas
            </option>
            <option value="Pengolahan Makanan" @selected(old('job-type', $job->job_type) === 'Pengolahan Makanan')>Pengolahan Makanan
            </option>
            <option value="Pertanian (Pertanian Tanaman)" @selected(old('job-type', $job->job_type) === 'Pertanian (Pertanian Tanaman)')>Pertanian
              (Pertanian Tanaman)</option>
            <option value="Pertanian (Peternakan)" @selected(old('job-type', $job->job_type) === 'Pertanian (Peternakan)')>Pertanian (Peternakan)
            </option>
            <option value="Perhotelan" @selected(old('job-type', $job->job_type) === 'Perhotelan')>Perhotelan</option>
            <option value="Pembersihan Gedung" @selected(old('job-type', $job->job_type) === 'Pembersihan Gedung')>Pembersihan Gedung
            </option>
            <option value="Manufaktur Produk Industri" @selected(old('job-type', $job->job_type) === 'Manufaktur Produk Industri')>Manufaktur Produk
              Industri</option>
            <option value="Konstruksi" @selected(old('job-type', $job->job_type) === 'Konstruksi')>Konstruksi</option>
            <option value="Pembuatan Kapal & Industri Kelautan" @selected(old('job-type', $job->job_type) === 'Pembuatan Kapal & Industri Kelautan')>
              Pembuatan Kapal & Industri Kelautan</option>
            <option value="Perawatan Otomotif" @selected(old('job-type', $job->job_type) === 'Perawatan Otomotif')>Perawatan Otomotif
            </option>
            <option value="Penerbangan" @selected(old('job-type', $job->job_type) === 'Penerbangan')>Penerbangan</option>
            <option value="Perikanan" @selected(old('job-type', $job->job_type) === 'Perikanan')>Perikanan</option>
            <option value="Transportasi otomotif" @selected(old('job-type', $job->job_type) === 'Transportasi otomotif')>Transportasi otomotif
            </option>
            <option value="Perkeretaapian" @selected(old('job-type', $job->job_type) === 'Perkeretaapian')>Perkeretaapian</option>
            <option value="Kehutanan" @selected(old('job-type', $job->job_type) === 'Kehutanan')>Kehutanan</option>
            <option value="Industri Kayu" @selected(old('job-type', $job->job_type) === 'Industri Kayu')>Industri Kayu</option>
            <option value="Visa Kerja Tetap" @selected(old('job-type', $job->job_type) === 'Visa Kerja Tetap')>Visa Kerja Tetap</option>
          </select>
        </div>

        <!-- Second row -->
        <div class="col-span-2 flex flex-col gap-1">
          <label for="job-placement" class="text-sm">Penempatan</label>
          @error('job-placement')
            <span class="text-[10px] text-red-600">{{ $message }}</span>
          @enderror
          <select name="job-placement" id="job-placement"
            data-selected="{{ old('job-placement', $job->placement) }}"
            class="{{ $errors->has('job-placement') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }} rounded border bg-white px-2 py-1 text-sm outline-none transition-all focus:border">
            <option value="">Pilih</option>
          </select>
        </div>
        <div class="col-span-2 flex flex-col gap-1">
          <label for="visa-type" class="text-sm">Jenis VISA</label>
          @error('visa-type')
            <span class="text-[10px] text-red-600">{{ $message }}</span>
          @enderror
          <input type="text" name="visa-type" id="visa-type"
            value="{{ old('visa-type', $job->visa_type) }}"
            class="{{ $errors->has('visa-type') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }} rounded border bg-white px-2 py-1 text-sm outline-none transition-all focus:border">
        </div>
        <div class="col-span-2 flex flex-col gap-1">
          <label for="placement-branch" class="text-sm">Cabang Penempatan</label>
          @error('placement-branch')
            <span class="text-[10px] text-red-600">{{ $message }}</span>
          @enderror
          <input type="text" name="placement-branch" id="placement-branch"
            value="{{ old('placement-branch', $job->placement_branch) }}" placeholder="Opsional"
            class="{{ $errors->has('placement-branch') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }} rounded border bg-white px-2 py-1 text-sm outline-none transition-all focus:border">
        </div>
        <div class="col-span-2 flex flex-col gap-1">
          <label for="source" class="text-sm">Salinan Asli</label>
          @error('source')
            <span class="text-[10px] text-red-600">{{ $message }}</span>
          @enderror
          <input type="url" name="source" id="source"
            value="{{ old('source', $job->source) }}" placeholder="https://drive.google.com/..."
            class="{{ $errors->has('source') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }} w-full rounded border bg-white px-2 py-1 text-sm outline-none transition-all focus:border">
        </div>
        <div class="col-span-2 flex flex-col gap-1">
          <label for="job-sallary" class="text-sm">Range Gaji</label>
          <div class="flex gap-1">
            @php
              $salary = explode('-', $job->salary);
              $salaryFrom = empty($salary[0]) ? '' : $salary[0];
              $salaryTo = empty($salary[1]) ? '' : $salary[1];
            @endphp
            <div>
              <input type="number" name="salary-from" value="{{ $salaryFrom }}"
                id="salary-from" value="{{ old('salary-from') }}"
                class="{{ $errors->has('salary-from') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }} w-full rounded border bg-white px-2 py-1 text-sm outline-none transition-all focus:border">
              @error('salary-from')
                <span class="text-[10px] text-red-600">{{ $message }}</span>
              @enderror
            </div>
            <div>
              @error('salary-to')
                <span class="text-[10px] text-red-600">{{ $message }}</span>
              @enderror
              <input type="number" name="salary-to" value="{{ $salaryTo }}" id="salary-to"
                value="{{ old('salary-to') }}"
                class="{{ $errors->has('salary-to') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }} w-full rounded border bg-white px-2 py-1 text-sm outline-none transition-all focus:border">
            </div>
          </div>
          <span class="text-[10px] text-slate-400">Jika tidak ada, isi dengan -</span>
        </div>
        <div class="col-span-2 flex flex-col gap-1">
          <label for="whatsapp-number" class="text-sm">Nomor WhatsApp</label>
          @error('whatsapp-number')
            <span class="text-[10px] text-red-600">{{ $message }}</span>
          @enderror
          <input type="text" name="whatsapp-number" id="whatsapp-number"
            value="{{ old('whatsapp-number', $job->whatsapp_number) }}"
            class="{{ $errors->has('whatsapp-number') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }} w-full rounded border bg-white px-2 py-1 text-sm outline-none transition-all focus:border">
          <span class="text-[10px] text-slate-400">Gunakan format internasional, contoh:
            62812xxxxxxx</span>
        </div>

        <!-- Third row -->
        <div class="col-span-2 flex flex-col gap-1">
          <label for="gender-requirement" class="text-sm">Persyaratan Gender</label>
          @error('gender-requirement')
            <span class="text-[10px] text-red-600">{{ $message }}</span>
          @enderror
          <select name="gender-requirement" id="gender-requirement"
            class="rounded border border-slate-300 bg-white px-2 py-1 text-sm outline-none transition-all focus:border focus:border-slate-500">
            <option value="">Pilih</option>
            <option value="l" @selected(old('gender-requirement', $job->gender_requirement) === 'l')>Laki-laki</option>
            <option value="p" @selected(old('gender-requirement', $job->gender_requirement) === 'p')>Perempuan</option>
            <option value="a" @selected(old('gender-requirement', $job->gender_requirement) === 'a')>Laki-laki & Perempuan</option>
          </select>
        </div>
        <div class="col-span-2 flex flex-col gap-1">
          <label for="domicile-requirement" class="text-sm">Persyaratan Domisili</label>
          @error('domicile-requirement')
            <span class="text-[10px] text-red-600">{{ $message }}</span>
          @enderror
          <select name="domicile-requirement" id="domicile-requirement"
            class="rounded border border-slate-300 bg-white px-2 py-1 text-sm outline-none transition-all focus:border focus:border-slate-500">
            <option value="">Pilih</option>
            <option value="kokunai" @selected(old('domicile-requirement', $job->domicile_requirement) === 'kokunai')>Khusus Jepang</option>
            <option value="kokugai" @selected(old('domicile-requirement', $job->domicile_requirement) === 'kokugai')>Bebas (Di Luar Jepang)</option>
            <option value="kokunai-to-kokugai" @selected(old('domicile-requirement', $job->domicile_requirement) === 'kokunai-to-kokugai')>Domisili Luar & Dalam
              Jepang</option>
          </select>
        </div>
        <div class="col-span-2 mt-5 gap-2">
          <label class="text-sm">Benefit & Fasilitas</label>
          @php
            $selectedBenefits = old('benefit', $job->benefit ? explode('|', $job->benefit) : []);
            $selectedBenefits = is_array($selectedBenefits) ? $selectedBenefits : [];
          @endphp

          <div class="col-span-8 mt-5 gap-2">
            <label for="additional-information" class="text-sm">Benefit & Fasilitas</label>
            <div>
              <input type="checkbox" id="sallary" value="Gaji" name="benefit[]"
                @checked(in_array('Gaji', $selectedBenefits, true))>
              <label for="sallary">Gaji</label>
            </div>
            <div>
              <input type="checkbox" id="sallary-upgradable" value="Kenaikan Gaji"
                name="benefit[]" @checked(in_array('Kenaikan Gaji', $selectedBenefits, true))>
              <label for="sallary-upgradable">Kenaikan Gaji</label>
            </div>
            <div>
              <input type="checkbox" id="paid-overtime" value="Lembur" name="benefit[]"
                @checked(in_array('Lembur', $selectedBenefits, true))>
              <label for="paid-overtime">Lembur</label>
            </div>
            <div>
              <input type="checkbox" id="night-shift" value="Shift Malam" name="benefit[]"
                @checked(in_array('Shift Malam', $selectedBenefits, true))>
              <label for="night-shift">Shift Malam</label>
            </div>
            <div>
              <input type="checkbox" id="tg2-support" value="Support TG2" name="benefit[]"
                @checked(in_array('Support TG2', $selectedBenefits, true))>
              <label for="tg2-support">Support TG2</label>
            </div>
            <div>
              <input type="checkbox" id="kaigo-support" value="Support Kaigo" name="benefit[]"
                @checked(in_array('Support Kaigo', $selectedBenefits, true))>
              <label for="kaigo-support">Support Kaigo</label>
            </div>
            <div>
              <input type="checkbox" id="bonus" value="Bonus" name="benefit[]"
                @checked(in_array('Bonus', $selectedBenefits, true))>
              <label for="bonus">Bonus</label>
            </div>
            <div>
              <input type="checkbox" id="free-meal" value="Makan Gratis" name="benefit[]"
                @checked(in_array('Makan Gratis', $selectedBenefits, true))>
              <label for="free-meal">Makan Gratis</label>
            </div>
            <div>
              <input type="checkbox" id="dorm" value="Asrama" name="benefit[]"
                @checked(in_array('Asrama', $selectedBenefits, true))>
              <label for="dorm">Asrama</label>
            </div>
            <div>
              <input type="checkbox" id="dorm-allowance" value="Tunjangan Asrama" name="benefit[]"
                @checked(in_array('Tunjangan Asrama', $selectedBenefits, true))>
              <label for="dorm-allowance">Tunjangan Asrama</label>
            </div>
            <div>
              <input type="checkbox" id="vehicle-allowance" value="Tunjangan Kendaraan"
                name="benefit[]" @checked(in_array('Tunjangan Kendaraan', $selectedBenefits, true))>
              <label for="vehicle-allowance">Tunjangan Kendaraan</label>
            </div>
            <div>
              <input type="checkbox" id="pig-tollerant" value="Toleransi Babi" name="benefit[]"
                @checked(in_array('Toleransi Babi', $selectedBenefits, true))>
              <label for="pig-tollerant">Toleransi Babi</label>
            </div>
            <div>
              <input type="checkbox" id="pray-tollerant" value="Toleransi Ibadah" name="benefit[]"
                @checked(in_array('Toleransi Ibadah', $selectedBenefits, true))>
              <label for="pray-tollerant">Toleransi Ibadah</label>
            </div>
          </div>
        </div>
        <div class="col-span-2 flex flex-col gap-1">
          <label for="qty" class="text-sm">Kuantitas Dibutuhkan</label>
          @error('qty')
            <span class="text-[10px] text-red-600">{{ $message }}</span>
          @enderror
          <input type="number" name="qty" id="qty" value="{{ old('qty', $job->qty) }}"
            class="{{ $errors->has('qty') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }} rounded border bg-white px-2 py-1 text-sm outline-none transition-all focus:border">
        </div>

        <!-- Fourth row -->
        <div class="col-span-2 flex flex-col gap-1">
          <label for="expiration-date" class="text-sm">Tenggat Lamaran</label>
          @error('expiration-date')
            <span class="text-[10px] text-red-600">{{ $message }}</span>
          @enderror
          <input type="date" name="expiration-date" id="expiration-date"
            value="{{ old('expiration-date', date('Y-m-d', strtotime($job->expired_at))) }}"
            class="{{ $errors->has('expiration-date') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }} w-full rounded border bg-white px-2 py-1 text-sm outline-none transition-all focus:border">
        </div>

        <!-- Fivth row -->
        <div class="col-span-8 mt-5 flex flex-col gap-2">
          <label for="additional-information" class="text-sm">Informasi Tambahan</label>
          @error('additional-information')
            <span class="text-[10px] text-red-600">{{ $message }}</span>
          @enderror
          <span class="text-xs text-slate-400">Tambahkan deskripsi pekerjaan, persyaratan khusus,
            bonus dan lain sebagainya</span>
          <input type="hidden" name="additional-information" id="additional-information"
            value="{{ old('additional-information', $job->additional_information) }}">
          <div id="additional-information-editor"
            class="{{ $errors->has('additional-information') ? 'border-red-500' : 'border-slate-300' }} rounded border text-sm">
          </div>
        </div>
      </div>

      <div class="mt-2 block grid-cols-8 gap-5 sm:grid">
        <div class="col-span-8">
          <button type="submit"
            class="w-full bg-slate-500 p-2 text-white transition-all hover:bg-slate-600 active:scale-[0.98] active:bg-slate-600">Simpan
            Perubahan</button>
        </div>
      </div>
    </form>
  </div>
@endsection

@section('scripts')
  <script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>

  @php
    $jobInformation = $job->additional_information;
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

    if (typeof initialAdditionalInformation === "string" && initialAdditionalInformation.trim() !==
      "") {
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
