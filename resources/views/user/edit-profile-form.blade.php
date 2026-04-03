@vite('resources/css/app.css')
<section class="min-h-screen bg-slate-50">
    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto max-w-6xl px-6">
            <div class="flex h-16 items-center justify-between">
                <div class="text-lg font-semibold text-slate-800">Manajemen Profil</div>
                <div class="text-sm text-slate-500">Akun Saya</div>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-6 py-8">
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="text-base font-semibold text-slate-800">Data Profil</h2>
                <p class="mt-1 text-sm text-slate-500">Lengkapi data berikut sesuai dokumen resmi.</p>
            </div>

            <form class="px-6 py-6" method="POST" action="{{ url('my/store-profile') }}">
                @csrf
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-medium text-slate-700">Furigana</label>
                        <input type="text" value="{{ $profile->furigana }}" name="furigana" class="mt-2 w-full rounded-lg border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-800 focus:border-slate-400 focus:ring-0" placeholder="タナカ タロウ" value="{{ old('furigana') }}" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700">Nama Lengkap</label>
                        <input type="text" value="{{ $profile->nama_lengkap }}" name="nama_lengkap" class="mt-2 w-full rounded-lg border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-800 focus:border-slate-400 focus:ring-0" placeholder="Tanaka Taro" value="{{ old('nama_lengkap') }}" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700">Tanggal Lahir</label>
                        <input type="date" value="{{ $profile->tanggal_lahir }}" name="tanggal_lahir" class="mt-2 w-full rounded-lg border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-800 focus:border-slate-400 focus:ring-0" value="{{ old('tanggal_lahir') }}" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="mt-2 w-full rounded-lg border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-800 focus:border-slate-400 focus:ring-0">
                            <option value="Pria" @selected($profile->jenis_kelamin === 'Pria')>Pria</option>
                            <option value="Wanita" @selected($profile->jenis_kelamin === 'Wanita')>Wanita</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700">Status Pernikahan</label>
                        <select name="status_pernikahan" class="mt-2 w-full rounded-lg border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-800 focus:border-slate-400 focus:ring-0">
                            <option value="Belum Menikah" @selected($profile->status_pernikahan === 'Belum Menikah')>Belum Menikah</option>
                            <option value="Menikah" @selected($profile->status_pernikahan === 'Menikah')>Menikah</option>
                            <option value="Cerai" @selected($profile->status_pernikahan === 'Cerai')>Cerai</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700">Kewarganegaraan</label>
                        <input type="text" name="kewarganegaraan" class="mt-2 w-full rounded-lg border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-800 focus:border-slate-400 focus:ring-0" placeholder="Indonesia" value="{{ old('kewarganegaraan') }}" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700">Tempat Asal</label>
                        <input type="text" name="tempat_asal" class="mt-2 w-full rounded-lg border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-800 focus:border-slate-400 focus:ring-0" placeholder="Bandung" value="{{ old('tempat_asal') }}" />
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-sm font-medium text-slate-700">Alamat Sekarang</label>
                        <textarea rows="3" name="alamat_sekarang" class="mt-2 w-full rounded-lg border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-800 focus:border-slate-400 focus:ring-0" placeholder="Jl. Contoh No. 12, Jakarta">{{ old('alamat_sekarang') }}</textarea>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700">Agama</label>
                        <input type="text" name="agama" class="mt-2 w-full rounded-lg border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-800 focus:border-slate-400 focus:ring-0" placeholder="Islam" value="{{ old('agama') }}" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700">Hijab</label>
                        <select name="hijab" class="mt-2 w-full rounded-lg border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-800 focus:border-slate-400 focus:ring-0">
                            <option value="Ya" @selected(old('hijab') === 'Ya')>Ya</option>
                            <option value="Tidak" @selected(old('hijab') === 'Tidak')>Tidak</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700">Salat</label>
                        <select name="salat" class="mt-2 w-full rounded-lg border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-800 focus:border-slate-400 focus:ring-0">
                            <option value="Ya" @selected(old('salat') === 'Ya')>Ya</option>
                            <option value="Tidak" @selected(old('salat') === 'Tidak')>Tidak</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700">Toleransi Babi</label>
                        <select name="toleransi_babi" class="mt-2 w-full rounded-lg border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-800 focus:border-slate-400 focus:ring-0">
                            <option value="Ya" @selected(old('toleransi_babi') === 'Ya')>Ya</option>
                            <option value="Tidak" @selected(old('toleransi_babi') === 'Tidak')>Tidak</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700">Toleransi Alkohol</label>
                        <select name="toleransi_alkohol" class="mt-2 w-full rounded-lg border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-800 focus:border-slate-400 focus:ring-0">
                            <option value="Ya" @selected(old('toleransi_alkohol') === 'Ya')>Ya</option>
                            <option value="Tidak" @selected(old('toleransi_alkohol') === 'Tidak')>Tidak</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700">Tanggal Masuk Jepang</label>
                        <input type="date" name="tanggal_masuk_jepang" class="mt-2 w-full rounded-lg border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-800 focus:border-slate-400 focus:ring-0" value="{{ old('tanggal_masuk_jepang') }}" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700">Status Izin Tinggal</label>
                        <input type="text" name="status_izin_tinggal" class="mt-2 w-full rounded-lg border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-800 focus:border-slate-400 focus:ring-0" placeholder="Tokutei Ginou" value="{{ old('status_izin_tinggal') }}" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700">Masa Berlaku Kartu</label>
                        <input type="date" name="masa_berlaku_kartu" class="mt-2 w-full rounded-lg border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-800 focus:border-slate-400 focus:ring-0" value="{{ old('masa_berlaku_kartu') }}" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700">Tanggal Mulai Kerja</label>
                        <input type="date" name="tanggal_mulai_kerja" class="mt-2 w-full rounded-lg border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-800 focus:border-slate-400 focus:ring-0" value="{{ old('tanggal_mulai_kerja') }}" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700">Kemampuan Bahasa</label>
                        <input type="text" name="kemampuan_bahasa" class="mt-2 w-full rounded-lg border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-800 focus:border-slate-400 focus:ring-0" placeholder="N4" value="{{ old('kemampuan_bahasa') }}" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700">Ujian Keterampilan</label>
                        <input type="text" name="ujian_keterampilan" class="mt-2 w-full rounded-lg border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-800 focus:border-slate-400 focus:ring-0" placeholder="SSW" value="{{ old('ujian_keterampilan') }}" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700">Kepemilikan SIM</label>
                        <select name="kepemilikan_sim" class="mt-2 w-full rounded-lg border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-800 focus:border-slate-400 focus:ring-0">
                            <option value="Tidak Ada" @selected(old('kepemilikan_sim') === 'Tidak Ada')>Tidak Ada</option>
                            <option value="A" @selected(old('kepemilikan_sim') === 'A')>A</option>
                            <option value="B1" @selected(old('kepemilikan_sim') === 'B1')>B1</option>
                            <option value="B2" @selected(old('kepemilikan_sim') === 'B2')>B2</option>
                        </select>
                    </div>
                </div>

                <div class="mt-8 flex flex-col items-start justify-between gap-4 border-t border-slate-200 pt-6 sm:flex-row sm:items-center">
                    <p class="text-sm text-slate-500">Perbarui data jika ada perubahan pada dokumen.</p>
                    <div class="flex gap-3">
                        <button type="button" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 hover:border-slate-300">Batal</button>
                        <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </main>
</section>
