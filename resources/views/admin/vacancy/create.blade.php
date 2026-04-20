@extends('layouts.admin')

@push('title')
  <title>NihonSkuy - Buat Loker</title>
@endpush

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
          <a href="{{ route('admin.vacancies') }}" class="hover:text-slate-700">
            Loker
          </a>
        </li>

        <li class="flex items-center gap-2">
          <span class="text-slate-400">/</span>
          <span class="font-medium text-slate-700">
            Buat Loker
          </span>
        </li>
      </ol>
    </nav>
    <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
      Buat Loker
    </h1>
    <p class="mt-2 text-sm text-slate-500">
      Buat info lowongan kerja terbaru
    </p>
  </div>

  <div class="relative rounded-lg border border-slate-200 p-4">
    <div class="absolute inset-x-0 top-0 rounded rounded-b-none bg-slate-400 p-1 text-xs text-white">
      Informasi Umum Job</div>

    <form method="post" action="/admin/vacancy/insert">
      @csrf
      <div class="mt-8 block grid-cols-8 gap-5 sm:grid">

        <!-- First row -->
        <div class="col-span-2 flex flex-col gap-1">
          <label for="job-id" class="text-sm">Job ID / Kode Lowongan</label>
          @error('job-id')
            <span class="text-[10px] text-red-600">{{ $message }}</span>
          @enderror
          <input type="text" name="job-id" id="job-id" value="{{ old('job-id') }}"
            class="{{ $errors->has('job-id') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }} rounded border bg-white px-2 py-1 text-sm outline-none transition-all focus:border">
        </div>
        <div class="col-span-4 flex flex-col gap-1">
          <label for="job-title" class="text-sm">Nama Pekerjaan</label>
          @error('job-title')
            <span class="text-[10px] text-red-600">{{ $message }}</span>
          @enderror
          <input type="text" placeholder="Cth: Pengolahan Makanan Kaleng" name="job-title"
            id="job-title" value="{{ old('job-title') }}"
            class="{{ $errors->has('job-title') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }} rounded border bg-white px-2 py-1 text-sm outline-none transition-all focus:border">
        </div>

        <!-- Second row -->
        <div class="col-span-2 flex flex-col gap-1">
          <label for="job-type" class="text-sm">Jenis Pekerjaan</label>
          @error('job-type')
            <span class="text-[10px] text-red-600">{{ $message }}</span>
          @enderror
          <select name="job-type" id="job-type"
            class="{{ $errors->has('job-type') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }} rounded border bg-white px-2 py-1 text-sm outline-none transition-all focus:border">
            <option value="">Pilih</option>
            <option value="Restoran" @selected(old('job-type') === 'Restoran')>Restoran</option>
            <option value="Perawat Lansia" @selected(old('job-type') === 'Perawat Lansia')>Perawat Lansia</option>
            <option value="Perawat Disabilitas" @selected(old('job-type') === 'Perawat Disabilitas')>Perawat Disabilitas
            </option>
            <option value="Pengolahan Makanan" @selected(old('job-type') === 'Pengolahan Makanan')>Pengolahan Makanan
            </option>
            <option value="Pertanian (Pertanian Tanaman)" @selected(old('job-type') === 'Pertanian (Pertanian Tanaman)')>Pertanian
              (Pertanian Tanaman)</option>
            <option value="Pertanian (Peternakan)" @selected(old('job-type') === 'Pertanian (Peternakan)')>Pertanian (Peternakan)
            </option>
            <option value="Perhotelan" @selected(old('job-type') === 'Perhotelan')>Perhotelan</option>
            <option value="Pembersihan Gedung" @selected(old('job-type') === 'Pembersihan Gedung')>Pembersihan Gedung
            </option>
            <option value="Manufaktur Produk Industri" @selected(old('job-type') === 'Manufaktur Produk Industri')>Manufaktur Produk
              Industri</option>
            <option value="Konstruksi" @selected(old('job-type') === 'Konstruksi')>Konstruksi</option>
            <option value="Pembuatan Kapal & Industri Kelautan" @selected(old('job-type') === 'Pembuatan Kapal & Industri Kelautan')>
              Pembuatan Kapal & Industri Kelautan</option>
            <option value="Perawatan Otomotif" @selected(old('job-type') === 'Perawatan Otomotif')>Perawatan Otomotif
            </option>
            <option value="Penerbangan" @selected(old('job-type') === 'Penerbangan')>Penerbangan</option>
            <option value="Perikanan" @selected(old('job-type') === 'Perikanan')>Perikanan</option>
            <option value="Transportasi otomotif" @selected(old('job-type') === 'Transportasi otomotif')>Transportasi otomotif
            </option>
            <option value="Perkeretaapian" @selected(old('job-type') === 'Perkeretaapian')>Perkeretaapian</option>
            <option value="Kehutanan" @selected(old('job-type') === 'Kehutanan')>Kehutanan</option>
            <option value="Industri Kayu" @selected(old('job-type') === 'Industri Kayu')>Industri Kayu</option>
            <option value="Visa Kerja Tetap" @selected(old('job-type') === 'Visa Kerja Tetap')>Visa Kerja Tetap</option>
          </select>
        </div>
        <div class="col-span-2 flex flex-col gap-1">
          <label for="job-placement" class="text-sm">Penempatan</label>
          <div id="select-location"
            class="{{ $errors->has('job-type') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }} relative rounded border bg-white px-2 py-1 text-sm outline-none transition-all focus:border">
            <div class="w-full" id="japan-pref-wrapper">
              <input type="hidden" id="japan-pref-value" name="job-placement" value="">
              <button type="button" id="japan-pref-toggle"
                class="flex w-full cursor-pointer items-center justify-between gap-2 bg-transparent text-sm text-slate-900 focus:outline-none"
                aria-haspopup="listbox" aria-expanded="false">
                <span id="japan-pref-label" class="text-slate-400">Semua prefektur</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                  class="text-slate-400">
                  <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" />
                </svg>
              </button>
            </div>
            <div id="japan-pref-panel"
              class="shadow-soft absolute left-0 right-0 top-full z-20 mt-2 hidden rounded-xl border border-slate-200 bg-white p-2">
              <input id="japan-pref-search" type="text" placeholder="Cari prefektur..."
                class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200" />
              <ul id="japan-pref-list" class="mt-2 max-h-56 overflow-auto text-sm text-slate-900"
                role="listbox" aria-label="Daftar prefektur">
              </ul>
            </div>
          </div>
        </div>
        {{-- <div class="flex flex-col gap-1 col-span-2">
        <label for="job-placement" class="text-sm">Penempatan</label>
        @error('job-placement')
        <span class="text-[10px] text-red-600">{{ $message }}</span>
        @enderror
        <select
          name="job-placement"
          id="job-placement"
          data-selected="{{ old('job-placement') }}">
          <option value="">Pilih</option>
        </select>
      </div> --}}
        <div class="col-span-2 flex flex-col gap-1">
          <label for="visa-type" class="text-sm">Jenis VISA</label>
          @error('visa-type')
            <span class="text-[10px] text-red-600">{{ $message }}</span>
          @enderror
          <input type="text" name="visa-type" id="visa-type" value="{{ old('visa-type') }}"
            class="{{ $errors->has('visa-type') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }} rounded border bg-white px-2 py-1 text-sm outline-none transition-all focus:border">
        </div>
        <div class="col-span-2 flex flex-col gap-1">
          <label for="placement-branch" class="text-sm">Cabang Penempatan</label>
          @error('placement-branch')
            <span class="text-[10px] text-red-600">{{ $message }}</span>
          @enderror
          <input type="text" name="placement-branch" id="placement-branch"
            value="{{ old('placement-branch') }}" placeholder="Opsional"
            class="{{ $errors->has('placement-branch') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }} rounded border bg-white px-2 py-1 text-sm outline-none transition-all focus:border">
        </div>
        <div class="col-span-2 flex flex-col gap-1">
          <label for="source" class="text-sm">Salinan Asli</label>
          @error('source')
            <span class="text-[10px] text-red-600">{{ $message }}</span>
          @enderror
          <input type="url" name="source" id="source" value="{{ old('source') }}"
            placeholder="https://drive.google.com/..."
            class="{{ $errors->has('source') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }} w-full rounded border bg-white px-2 py-1 text-sm outline-none transition-all focus:border">
        </div>
        <div class="col-span-2 flex flex-col gap-1">
          <label for="job-sallary" class="text-sm">Range Gaji</label>
          <div class="flex gap-1">
            <div>
              <input type="number" name="salary-from" id="salary-from"
                value="{{ old('salary-from') }}"
                class="{{ $errors->has('salary-from') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }} w-full rounded border bg-white px-2 py-1 text-sm outline-none transition-all focus:border">
              @error('salary-from')
                <span class="text-[10px] text-red-600">{{ $message }}</span>
              @enderror
            </div>
            <div>
              @error('salary-to')
                <span class="text-[10px] text-red-600">{{ $message }}</span>
              @enderror
              <input type="number" name="salary-to" id="salary-to"
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
            value="{{ old('whatsapp-number') }}"
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
            class="rounded border border-slate-300 px-2 py-1 text-sm outline-none transition-all focus:border focus:border-slate-500">
            <option value="">Pilih</option>
            <option value="l" @selected(old('gender-requirement') === 'l')>Laki-laki</option>
            <option value="p" @selected(old('gender-requirement') === 'p')>Perempuan</option>
            <option value="a" @selected(old('gender-requirement') === 'a')>Laki-laki & Perempuan</option>
          </select>
        </div>
        <div class="col-span-2 flex flex-col gap-1">
          <label for="domicile-requirement" class="text-sm">Persyaratan Domisili</label>
          @error('domicile-requirement')
            <span class="text-[10px] text-red-600">{{ $message }}</span>
          @enderror
          <select name="domicile-requirement" id="domicile-requirement"
            class="rounded border border-slate-300 px-2 py-1 text-sm outline-none transition-all focus:border focus:border-slate-500">
            <option value="">Pilih</option>
            <option value="kokunai" @selected(old('domicile-requirement') === 'kokunai')>Khusus Jepang</option>
            <option value="kokugai" @selected(old('domicile-requirement') === 'kokugai')>Bebas (Di Luar Jepang)</option>
            <option value="kokunai-to-kokugai" @selected(old('domicile-requirement') === 'kokunai-to-kokugai')>Domisili Luar & Dalam
              Jepang</option>
          </select>
        </div>
        <div class="col-span-2 mt-5 gap-2">
          <label for="additional-information" class="text-sm">Benefit & Fasilitas</label>
          <div>
            <input type="checkbox" id="sallary" value="Gaji" name="benefit[]">
            <label for="sallary">Gaji</label>
          </div>
          <div>
            <input type="checkbox" id="sallary-upgradable" value="Kenaikan Gaji" name="benefit[]">
            <label for="sallary-upgradable">Kenaikan Gaji</label>
          </div>
          <div>
            <input type="checkbox" id="paid-overtime" value="Lembur" name="benefit[]">
            <label for="paid-overtime">Lembur</label>
          </div>
          <div>
            <input type="checkbox" id="night-shift" value="Shift Malam" name="benefit[]">
            <label for="night-shift">Shift Malam</label>
          </div>
          <div>
            <input type="checkbox" id="tg2-support" value="Support TG2" name="benefit[]">
            <label for="tg2-support">Support TG2</label>
          </div>
          <div>
            <input type="checkbox" id="kaigo-support" value="Support Kaigo" name="benefit[]">
            <label for="kaigo-support">Support Kaigo</label>
          </div>
          <div>
            <input type="checkbox" id="bonus" value="Bonus" name="benefit[]">
            <label for="bonus">Bonus</label>
          </div>
          <div>
            <input type="checkbox" id="free-meal" value="Makan Gratis" name="benefit[]">
            <label for="free-meal">Makan Gratis</label>
          </div>
          <div>
            <input type="checkbox" id="dorm" value="Asrama" name="benefit[]">
            <label for="dorm">Asrama</label>
          </div>
          <div>
            <input type="checkbox" id="dorm-allowance" value="Tunjangan Asrama" name="benefit[]">
            <label for="dorm-allowance">Tunjangan Asrama</label>
          </div>
          <div>
            <input type="checkbox" id="vehicle-allowance" value="Tunjangan Kendaraan"
              name="benefit[]">
            <label for="vehicle-allowance">Tunjangan Kendaraan</label>
          </div>
          <div>
            <input type="checkbox" id="pig-tollerant" value="Toleransi Babi" name="benefit[]">
            <label for="pig-tollerant">Toleransi Babi</label>
          </div>
          <div>
            <input type="checkbox" id="pray-tollerant" value="Toleransi Ibadah" name="benefit[]">
            <label for="pray-tollerant">Toleransi Ibadah</label>
          </div>
        </div>
        <div class="col-span-2 mt-5 gap-2">
          <label class="text-sm">Tag Khusus</label>
          @error('special-tag')
            <span class="block text-[10px] text-red-600">{{ $message }}</span>
          @enderror
          @error('special-tag.*')
            <span class="block text-[10px] text-red-600">{{ $message }}</span>
          @enderror
          @php
            $selectedSpecialTags = old('special-tag', []);
            $selectedSpecialTags = is_array($selectedSpecialTags) ? $selectedSpecialTags : [];
          @endphp
          <div>
            <input type="checkbox" id="special-tag-urgent" value="urgent" name="special-tag[]"
              @checked(in_array('urgent', $selectedSpecialTags, true))>
            <label for="special-tag-urgent">Dibutuhkan Segera</label>
          </div>
        </div>
        <div class="col-span-2 flex flex-col gap-1">
          <label for="qty" class="text-sm">Kuantitas Dibutuhkan</label>
          @error('qty')
            <span class="text-[10px] text-red-600">{{ $message }}</span>
          @enderror
          <input type="number" name="qty" id="qty" value="{{ old('qty') }}"
            class="{{ $errors->has('qty') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }} rounded border bg-white px-2 py-1 text-sm outline-none transition-all focus:border">
        </div>

        <!-- Fourth row -->

        <div class="col-span-2 flex flex-col gap-1">
          <label for="expiration-date" class="text-sm">Tenggat Postingan</label>
          @error('expiration-date')
            <span class="text-[10px] text-red-600">{{ $message }}</span>
          @enderror
          <input type="date" name="expiration-date" id="expiration-date"
            value="{{ old('expiration-date') }}"
            class="{{ $errors->has('expiration-date') ? 'border-red-500 focus:border-red-500' : 'border-slate-300 focus:border-slate-500' }} w-full rounded border bg-white px-2 py-1 text-sm outline-none transition-all focus:border">
        </div>

        <!-- Fivth row -->
        <div class="col-span-8 flex flex-col gap-2">
          <label for="additional-information" class="text-sm">Informasi Tambahan</label>
          @error('additional-information')
            <span class="text-[10px] text-red-600">{{ $message }}</span>
          @enderror
          <span class="text-xs text-slate-400">Tambahkan deskripsi pekerjaan, persyaratan khusus,
            bonus dan lain sebagainya</span>
          <input type="hidden" name="additional-information" id="additional-information"
            value="{{ old('additional-information') }}">
          <div id="additional-information-editor"
            class="{{ $errors->has('additional-information') ? 'border-red-500' : 'border-slate-300' }} rounded border text-sm">
          </div>
        </div>
      </div>

      <div class="mt-2 block grid-cols-8 gap-5 sm:grid">
        <div class="col-span-8">
          <button type="submit"
            class="w-full bg-slate-500 p-2 text-white transition-all hover:bg-slate-600 active:scale-[0.98] active:bg-slate-600">Simpan</button>
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

    fetch('/japan.json')
      .then(response => response.json())
      .then(data => {
        const wrapper = document.getElementById('select-location');
        const toggle = document.getElementById('japan-pref-toggle');
        const panel = document.getElementById('japan-pref-panel');
        const search = document.getElementById('japan-pref-search');
        const list = document.getElementById('japan-pref-list');
        const valueInput = document.getElementById('japan-pref-value');
        const label = document.getElementById('japan-pref-label');
        const allPrefectures = Array.isArray(data.japan_prefectures) ? data.japan_prefectures : [];

        const renderOptions = (items) => {
          list.innerHTML = '';
          const allItem = document.createElement('button');
          allItem.type = 'button';
          allItem.className =
            'w-full text-left cursor-pointer rounded-lg px-3 py-2 hover:bg-slate-100';
          allItem.textContent = 'Semua prefektur';
          allItem.dataset.value = '';
          list.appendChild(allItem);

          items.forEach(prefecture => {
            const item = document.createElement('button');
            item.type = 'button';
            item.className =
              'w-full text-left cursor-pointer rounded-lg px-3 py-2 hover:bg-slate-100';
            item.textContent = prefecture;
            item.dataset.value = prefecture;
            list.appendChild(item);
          });
        };

        renderOptions(allPrefectures);

        search.addEventListener('input', () => {
          const query = search.value.trim().toLowerCase();
          if (!query) {
            renderOptions(allPrefectures);
            return;
          }
          const filtered = allPrefectures.filter((prefecture) =>
            String(prefecture).toLowerCase().includes(query)
          );
          renderOptions(filtered);
        });

        const openPanel = () => {
          panel.classList.remove('hidden');
          toggle.setAttribute('aria-expanded', 'true');
          search.focus();
        };

        const closePanel = () => {
          panel.classList.add('hidden');
          toggle.setAttribute('aria-expanded', 'false');
          search.value = '';
          renderOptions(allPrefectures);
        };

        toggle.addEventListener('click', (event) => {
          event.stopPropagation();
          if (panel.classList.contains('hidden')) {
            openPanel();
          } else {
            closePanel();
          }
        });

        list.addEventListener('click', (event) => {
          event.preventDefault();
          event.stopPropagation();
          const target = event.target.closest('button');
          if (!target) return;
          const value = target.dataset.value || '';
          valueInput.value = value;
          label.textContent = value || 'Semua prefektur';
          label.classList.toggle('text-slate-400', !value);
          label.classList.toggle('text-slate-900', !!value);
          closePanel();
        });

        document.addEventListener('click', (event) => {
          if (!wrapper.contains(event.target)) {
            closePanel();
          }
        });
      });
  </script>
@endsection
