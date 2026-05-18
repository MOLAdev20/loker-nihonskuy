@extends('layouts.user-dashboard')

@section('title', 'Form Profile User')

@section('content_header', 'Form Data Diri')

@section('content_subheader', 'Lengkapi data profil untuk proses penempatan kerja.')

@section('content')
  @php
    $inputClass =
        'mt-2 block w-full rounded-xl border bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm placeholder:text-slate-400 focus:outline-none focus:ring-2';
    $labelClass = 'text-sm font-medium text-slate-700';
  @endphp

  @if (session('status'))
    <div
      class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
      {{ session('status') }}
    </div>
  @endif

  <x-form-wizard :steps="$wizardSteps" />

  <form method="POST" action="{{ route('user.profile.store') }}"
    class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
    @csrf

    <div class="mb-5 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
      Semua kolom bertanda <span class="font-semibold text-red-600">*</span> wajib diisi.
    </div>

    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
      <div>
        <label class="{{ $labelClass }}" for="fullName">Nama Lengkap <span
            class="text-red-600">*</span></label>
        <input id="fullName" name="fullName" type="text"
          value="{{ old('fullName', $profile?->full_name ?? '') }}"
          class="{{ $inputClass }} @error('fullName') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror"
          placeholder="Masukkan nama lengkap">
        @error('fullName')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="{{ $labelClass }}" for="furiganaName">Furigana <span
            class="text-red-600">*</span></label>
        <input id="furiganaName" name="furiganaName" type="text"
          value="{{ old('furiganaName', $profile?->furigana_name ?? '') }}"
          class="{{ $inputClass }} @error('furiganaName') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror"
          placeholder="Masukkan furigana">
        @error('furiganaName')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="{{ $labelClass }}" for="birthDate">Tanggal Lahir <span
            class="text-red-600">*</span></label>
        <input id="birthDate" name="birthDate" type="date"
          value="{{ old('birthDate', optional($profile?->birth_date)->format('Y-m-d')) }}"
          class="{{ $inputClass }} @error('birthDate') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror">
        @error('birthDate')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <p class="{{ $labelClass }}">Jenis Kelamin <span class="text-red-600">*</span></p>
        <div
          class="@error('gender') border-red-500 @else border-slate-300 @enderror mt-2 flex flex-wrap items-center gap-4 rounded-xl border px-3 py-2.5">
          <label class="inline-flex items-center gap-2 text-sm text-slate-700">
            <input type="radio" name="gender" value="male"
              class="h-4 w-4 border-slate-300 text-slate-800 focus:ring-slate-300"
              @checked(old('gender', $profile?->gender ?? '') === 'male')>
            Laki-laki
          </label>
          <label class="inline-flex items-center gap-2 text-sm text-slate-700">
            <input type="radio" name="gender" value="female"
              class="h-4 w-4 border-slate-300 text-slate-800 focus:ring-slate-300"
              @checked(old('gender', $profile?->gender ?? '') === 'female')>
            Perempuan
          </label>
        </div>
        @error('gender')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="{{ $labelClass }}" for="height">Tinggi Badan <span
            class="text-red-600">*</span></label>
        <input id="height" name="height" type="number" min="1"
          value="{{ old('height', $profile?->height ?? '') }}"
          class="{{ $inputClass }} @error('height') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror"
          placeholder="Contoh: 170">
        @error('height')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="{{ $labelClass }}" for="weight">Berat Badan <span
            class="text-red-600">*</span></label>
        <input id="weight" name="weight" type="number" min="1"
          value="{{ old('weight', $profile?->weight ?? '') }}"
          class="{{ $inputClass }} @error('weight') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror"
          placeholder="Contoh: 60">
        @error('weight')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div class="md:col-span-2">
        <p class="{{ $labelClass }}">Status Pernikahan <span class="text-red-600">*</span></p>
        <div
          class="@error('maritalStatus') border-red-500 @else border-slate-300 @enderror mt-2 flex flex-wrap items-center gap-4 rounded-xl border px-3 py-2.5">
          <label class="inline-flex items-center gap-2 text-sm text-slate-700">
            <input type="radio" name="maritalStatus" value="single"
              class="h-4 w-4 border-slate-300 text-slate-800 focus:ring-slate-300"
              @checked(old('maritalStatus', $profile?->marital_status ?? '') === 'single')>
            Belum Menikah
          </label>
          <label class="inline-flex items-center gap-2 text-sm text-slate-700">
            <input type="radio" name="maritalStatus" value="married"
              class="h-4 w-4 border-slate-300 text-slate-800 focus:ring-slate-300"
              @checked(old('maritalStatus', $profile?->marital_status ?? '') === 'married')>
            Menikah
          </label>
          <label class="inline-flex items-center gap-2 text-sm text-slate-700">
            <input type="radio" name="maritalStatus" value="divorce"
              class="h-4 w-4 border-slate-300 text-slate-800 focus:ring-slate-300"
              @checked(old('maritalStatus', $profile?->marital_status ?? '') === 'divorce')>
            Cerai
          </label>
        </div>
        @error('maritalStatus')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="{{ $labelClass }}" for="nationality">Kewarganegaraan <span
            class="text-red-600">*</span></label>
        <input id="nationality" name="nationality" type="text"
          value="{{ old('nationality', $profile?->nationality ?? '') }}"
          class="{{ $inputClass }} @error('nationality') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror"
          placeholder="Masukkan kewarganegaraan">
        @error('nationality')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="{{ $labelClass }}" for="placeOfOrigin">Tempat Asal <span
            class="text-red-600">*</span></label>
        <input id="placeOfOrigin" name="placeOfOrigin" type="text"
          value="{{ old('placeOfOrigin', $profile?->place_of_origin ?? '') }}"
          class="{{ $inputClass }} @error('placeOfOrigin') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror"
          placeholder="Masukkan tempat asal">
        @error('placeOfOrigin')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div class="md:col-span-2">
        <label class="{{ $labelClass }}" for="currentAddress">Alamat Saat Ini <span
            class="text-red-600">*</span></label>
        <textarea id="currentAddress" name="currentAddress" rows="3"
          class="{{ $inputClass }} @error('currentAddress') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror"
          placeholder="Masukkan alamat saat ini">{{ old('currentAddress', $profile?->current_address ?? '') }}</textarea>
        @error('currentAddress')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="{{ $labelClass }}" for="religion">Agama <span
            class="text-red-600">*</span></label>
        <select id="religion" name="religion"
          class="{{ $inputClass }} @error('religion') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror">
          <option value="">Pilih agama</option>
          <option value="islam" @selected(old('religion', $profile?->religion ?? '') === 'islam')>Islam</option>
          <option value="kristen" @selected(old('religion', $profile?->religion ?? '') === 'kristen')>Kristen</option>
          <option value="katolik" @selected(old('religion', $profile?->religion ?? '') === 'katolik')>Katolik</option>
          <option value="hindu" @selected(old('religion', $profile?->religion ?? '') === 'hindu')>Hindu</option>
          <option value="buddha" @selected(old('religion', $profile?->religion ?? '') === 'buddha')>Buddha</option>
        </select>
        @error('religion')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="{{ $labelClass }}" for="isWearingHijab">Apakah Menggunakan Hijab? <span
            class="text-red-600">*</span></label>
        <select id="isWearingHijab" name="isWearingHijab"
          class="{{ $inputClass }} @error('isWearingHijab') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror">
          <option value="">Pilih</option>
          <option value="Saya ingin memakai jilbab" @selected(old('isWearingHijab', $profile?->is_wearing_hijab ?? '') === 'Saya ingin memakai jilbab')>Saya ingin memakai jilbab</option>
          <option value="Saya bisa menyesuaikan situasi" @selected(old('isWearingHijab', $profile?->is_wearing_hijab ?? '') === 'Saya bisa menyesuaikan situasi')>Saya bisa menyesuaikan situasi</option>
          <option value="Saya tidak berencana memakainya" @selected(old('isWearingHijab', $profile?->is_wearing_hijab ?? '') === 'Saya tidak berencana memakainya')>Saya tidak berencana memakainya</option>
        </select>
        @error('isWearingHijab')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="{{ $labelClass }}" for="prayerRequirement">Kebutuhan Ibadah <span
            class="text-red-600">*</span></label>
        <select id="prayerRequirement" name="prayerRequirement"
          class="{{ $inputClass }} @error('prayerRequirement') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror">
          <option value="">Pilih</option>
          <option value="Saya sangat membutuhkan fasilitas ibadah" @selected(old('prayerRequirement', $profile?->prayer_requirement ?? '') === 'Saya sangat membutuhkan fasilitas ibadah')>Saya sangat membutuhkan fasilitas ibadah</option>
          <option value="Bisa menyesuaikan kondisi" @selected(old('prayerRequirement', $profile?->prayer_requirement ?? '') === 'Bisa menyesuaikan kondisi')>Bisa menyesuaikan kondisi</option>
          <option value="Saya tidak membutuhkannya" @selected(old('prayerRequirement', $profile?->prayer_requirement ?? '') === 'Saya tidak membutuhkannya')>Saya tidak membutuhkannya</option>
        </select>
        @error('prayerRequirement')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="{{ $labelClass }}" for="porkTolerance">Toleransi Terhadap Daging Babi <span
            class="text-red-600">*</span></label>
        <select id="porkTolerance" name="porkTolerance"
          class="{{ $inputClass }} @error('porkTolerance') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror">
          <option value="">Pilih</option>
          <option value="Tidak boleh ada keterlibatan dengan babi sama sekali" @selected(old('porkTolerance', $profile?->pork_tolerance ?? '') === 'Tidak boleh ada keterlibatan dengan babi sama sekali')>Tidak boleh ada keterlibatan dengan babi sama sekali</option>
          <option value="Boleh memasak, tapi tidak mencicipi/mengonsumsi" @selected(old('porkTolerance', $profile?->pork_tolerance ?? '') === 'Boleh memasak, tapi tidak mencicipi/mengonsumsi')>Boleh memasak, tapi tidak mencicipi/mengonsumsi</option>
          <option value="Boleh memasak & mencicipi, tapi tidak mengonsumsi" @selected(old('porkTolerance', $profile?->pork_tolerance ?? '') === 'Boleh memasak & mencicipi, tapi tidak mengonsumsi')>Boleh memasak & mencicipi, tapi tidak mengonsumsi</option>
          <option value="Tidak ada batasan terkait daging babi (bebas)" @selected(old('porkTolerance', $profile?->pork_tolerance ?? '') === 'Tidak ada batasan terkait daging babi (bebas)')>Tidak ada batasan terkait daging babi (bebas)</option>
        </select>
        @error('porkTolerance')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="{{ $labelClass }}" for="alcoholTolerance">Toleransi Terhadap Alkohol <span
            class="text-red-600">*</span></label>
        <select id="alcoholTolerance" name="alcoholTolerance"
          class="{{ $inputClass }} @error('alcoholTolerance') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror">
          <option value="">Pilih</option>
          <option value="Tidak boleh ada keterlibatan alkohol sama sekali" @selected(old('alcoholTolerance', $profile?->alcohol_tolerance ?? '') === 'Tidak boleh ada keterlibatan alkohol sama sekali')>Tidak boleh ada keterlibatan alkohol sama sekali</option>
          <option value="Boleh menyiapkan, tapi tidak mencicipi/minum" @selected(old('alcoholTolerance', $profile?->alcohol_tolerance ?? '') === 'Boleh menyiapkan, tapi tidak mencicipi/minum')>Boleh menyiapkan, tapi tidak mencicipi/minum</option>
          <option value="Boleh menyiapkan & mencicipi, tapi tidak minum" @selected(old('alcoholTolerance', $profile?->alcohol_tolerance ?? '') === 'Boleh menyiapkan & mencicipi, tapi tidak minum')>Boleh menyiapkan & mencicipi, tapi tidak minum</option>
          <option value="Tidak ada batasan terkait alkohol (bebas)" @selected(old('alcoholTolerance', $profile?->alcohol_tolerance ?? '') === 'Tidak ada batasan terkait alkohol (bebas)')>Tidak ada batasan terkait alkohol (bebas)</option>
        </select>
        @error('alcoholTolerance')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="{{ $labelClass }}" for="entryDate">Tanggal Masuk Jepang</label>
        <input id="entryDate" name="entryDate" type="date"
          value="{{ old('entryDate', optional($profile?->entry_date)->format('Y-m-d')) }}"
          class="{{ $inputClass }} @error('entryDate') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror">
        @error('entryDate')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="{{ $labelClass }}" for="visaExpiryDate">Masa Berlaku VISA</label>
        <input id="visaExpiryDate" name="visaExpiryDate" type="date"
          value="{{ old('visaExpiryDate', optional($profile?->visa_expiry_date)->format('Y-m-d')) }}"
          class="{{ $inputClass }} @error('visaExpiryDate') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror">
        @error('visaExpiryDate')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="{{ $labelClass }}" for="currentVisaType">Jenis Visa Saat Ini <span
            class="text-red-600">*</span></label>
        <input id="currentVisaType" name="currentVisaType" type="text"
          value="{{ old('currentVisaType', $profile?->current_visa_type ?? '') }}"
          class="{{ $inputClass }} @error('currentVisaType') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror"
          placeholder="Masukkan jenis visa">
        @error('currentVisaType')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="{{ $labelClass }}" for="jlptLevel">Level Kemampuan Bahasa Jepang (JLPT)
          <span class="text-red-600">*</span></label>
        <select id="jlptLevel" name="jlptLevel"
          class="{{ $inputClass }} @error('jlptLevel') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror">
          <option value="">Pilih Kemampuan</option>
          <option value="N1" @selected(old('jlptLevel', $profile?->jlpt_level ?? '') === 'N1')>N1</option>
          <option value="N2" @selected(old('jlptLevel', $profile?->jlpt_level ?? '') === 'N2')>N2</option>
          <option value="N3" @selected(old('jlptLevel', $profile?->jlpt_level ?? '') === 'N3')>N3</option>
          <option value="N4" @selected(old('jlptLevel', $profile?->jlpt_level ?? '') === 'N4')>N4</option>
          <option value="N5" @selected(old('jlptLevel', $profile?->jlpt_level ?? '') === 'N5')>N5</option>
          <option value="none" @selected(old('jlptLevel', $profile?->jlpt_level ?? '') === 'none')>Belum Ada</option>
        </select>
        @error('jlptLevel')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="{{ $labelClass }}" for="hasDriverLicense">Memiliki SIM? <span
            class="text-red-600">*</span></label>
        <input id="hasDriverLicense" name="hasDriverLicense" type="text"
          value="{{ old('hasDriverLicense', $profile?->has_driver_license ?? '') }}"
          class="{{ $inputClass }} @error('hasDriverLicense') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror"
          placeholder="Contoh: Memiliki SIM A">
        @error('hasDriverLicense')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="{{ $labelClass }}" for="workStartDate">Tanggal Siap Mulai Kerja <span
            class="text-red-600">*</span></label>
        <input id="workStartDate" name="workStartDate" type="date"
          value="{{ old('workStartDate', optional($profile?->work_start_date)->format('Y-m-d')) }}"
          class="{{ $inputClass }} @error('workStartDate') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror">
        @error('workStartDate')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div class="md:col-span-2">
        <label class="{{ $labelClass }}" for="technicalExperience">Detail Pengalaman Magang/Skill
          <span class="text-red-600">*</span></label>
        <textarea id="technicalExperience" name="technicalExperience" rows="4"
          class="{{ $inputClass }} @error('technicalExperience') border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror"
          placeholder="Jelaskan pengalaman magang atau skill teknis">{{ old('technicalExperience', $profile?->technical_experience ?? '') }}</textarea>
        @error('technicalExperience')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>
    </div>

    <div
      class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-200 pt-5 sm:flex-row sm:justify-end">
      <a href="{{ route('user.dashboard') }}"
        class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
        Kembali ke Dashboard
      </a>
      <button type="submit"
        class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
        Simpan & Lanjut ke Riwayat Pendidikan
      </button>
    </div>
  </form>
@endsection
