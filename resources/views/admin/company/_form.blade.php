@php
    $company = $company ?? null;
@endphp

<div class="space-y-6">
    @if ($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            Periksa kembali data yang diisi. Masih ada field yang belum valid.
        </div>
    @endif

    <div class="grid gap-5 lg:grid-cols-2">
        <div class="space-y-2">
            <label for="name" class="text-sm font-medium text-slate-700">Nama perusahaan</label>
            <input type="text" id="name" name="name" value="{{ old('name', $company?->name) }}"
                class="w-full rounded-xl border {{ $errors->has('name') ? 'border-red-300' : 'border-slate-200' }} bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:ring-4 focus:ring-slate-100"
                placeholder="Contoh: PT Sakura Jepang">
            @error('name')
                <p class="text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="established" class="text-sm font-medium text-slate-700">Tahun berdiri</label>
            <input type="text" id="established" name="established"
                value="{{ old('established', $company?->established) }}"
                class="w-full rounded-xl border {{ $errors->has('established') ? 'border-red-300' : 'border-slate-200' }} bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:ring-4 focus:ring-slate-100"
                placeholder="Contoh: 2008">
            @error('established')
                <p class="text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2 lg:col-span-2">
            <label for="bio" class="text-sm font-medium text-slate-700">Profil perusahaan</label>
            <textarea id="bio" name="bio" rows="4"
                class="w-full rounded-xl border {{ $errors->has('bio') ? 'border-red-300' : 'border-slate-200' }} bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:ring-4 focus:ring-slate-100"
                placeholder="Tuliskan ringkasan singkat perusahaan">{{ old('bio', $company?->bio) }}</textarea>
            @error('bio')
                <p class="text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="location" class="text-sm font-medium text-slate-700">Lokasi</label>
            <input type="text" id="location" name="location" value="{{ old('location', $company?->location) }}"
                class="w-full rounded-xl border {{ $errors->has('location') ? 'border-red-300' : 'border-slate-200' }} bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:ring-4 focus:ring-slate-100"
                placeholder="Contoh: Osaka, Jepang">
            @error('location')
                <p class="text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="website" class="text-sm font-medium text-slate-700">Website</label>
            <input type="text" id="website" name="website" value="{{ old('website', $company?->website) }}"
                class="w-full rounded-xl border {{ $errors->has('website') ? 'border-red-300' : 'border-slate-200' }} bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:ring-4 focus:ring-slate-100"
                placeholder="Contoh: sakura.co.jp atau https://sakura.co.jp">
            @error('website')
                <p class="text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="field" class="text-sm font-medium text-slate-700">Bidang perusahaan</label>
            <input type="text" id="field" name="field" value="{{ old('field', $company?->field) }}"
                class="w-full rounded-xl border {{ $errors->has('field') ? 'border-red-300' : 'border-slate-200' }} bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:ring-4 focus:ring-slate-100"
                placeholder="Contoh: Manufaktur">
            @error('field')
                <p class="text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="facility" class="text-sm font-medium text-slate-700">Fasilitas</label>
            <textarea id="facility" name="facility" rows="4"
                class="w-full rounded-xl border {{ $errors->has('facility') ? 'border-red-300' : 'border-slate-200' }} bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:ring-4 focus:ring-slate-100"
                placeholder="Pisahkan dengan koma atau baris baru">{{ old('facility', $company?->facility) }}</textarea>
            @error('facility')
                <p class="text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2 lg:col-span-2">
            <label for="logo" class="text-sm font-medium text-slate-700">Logo perusahaan</label>
            <input type="file" id="logo" name="logo" accept=".jpg,.jpeg,.png,.webp,.svg"
                class="block w-full rounded-xl border {{ $errors->has('logo') ? 'border-red-300' : 'border-slate-200' }} bg-white px-4 py-3 text-sm text-slate-700 file:mr-4 file:rounded-lg file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-slate-800">
            <p class="text-xs text-slate-500">Format yang disarankan: JPG, PNG, WEBP, atau SVG. Maksimal 2 MB.</p>
            @error('logo')
                <p class="text-xs text-red-600">{{ $message }}</p>
            @enderror

            @if ($company?->logo_url)
                <div class="mt-3 flex items-center gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <img src="{{ $company->logo_url }}" alt="{{ $company->name }} logo" class="h-16 w-16 rounded-2xl object-cover">
                    <div>
                        <p class="text-sm font-medium text-slate-900">Logo saat ini</p>
                        <p class="text-xs text-slate-500">Unggah file baru jika ingin mengganti logo.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="flex flex-wrap items-center gap-3 border-t border-slate-200 pt-5">
        <button type="submit"
            class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
            {{ $submitLabel }}
        </button>
        <a href="{{ route('admin.company.index') }}"
            class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
            Kembali
        </a>
    </div>
</div>
