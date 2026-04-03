@vite('resources/css/app.css')
<section class="min-h-screen bg-slate-50">
    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto max-w-6xl px-6">
            <div class="flex h-16 items-center justify-between">
                <div class="text-lg font-semibold text-slate-800">Profil Saya</div>
                <a href="{{ route('my.fill-profile') }}" class="text-sm text-slate-500">Isi Data</a>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-6 py-8">
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="text-base font-semibold text-slate-800">Data Pribadi</h2>
                <p class="mt-1 text-sm text-slate-500">Berikut data akhir setelah pengisian. Hubungi admin jika ada perubahan.</p>
            </div>

            <div class="px-6 py-6">
                @if(empty($profile))
                    <p class="text-sm text-slate-500">Belum ada data. Harap isi data.</p>
                @endif
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Furigana</p>
                        <p class="mt-1 text-sm text-slate-800">{{ !empty($profile->furigana) ? $profile->furigana : "" }}</p>
                    </div>
                    <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Nama Lengkap</p>
                        <p class="mt-1 text-sm text-slate-800">{{ !empty($profile->nama_lengkap) ? $profile->nama_lengkap : "" }}</p>
                    </div>
                    <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Tanggal Lahir</p>
                        <p class="mt-1 text-sm text-slate-800">{{ !empty($profile->tanggal_lahir) ? $profile->tanggal_lahir : "" }}</p>
                    </div>
                    <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Umur</p>
                        <p class="mt-1 text-sm text-slate-800">{{ !empty($profile->tanggal_lahir) ? date('Y') - date('Y', strtotime($profile->tanggal_lahir)) : "" }}</p>
                    </div>
                    <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Jenis Kelamin</p>
                        <p class="mt-1 text-sm text-slate-800">{{ !empty($profile->jenis_kelamin) ? $profile->jenis_kelamin : "" }}</p>
                    </div>
                    <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Status Pernikahan</p>
                        <p class="mt-1 text-sm text-slate-800">{{ !empty($profile->status_pernikahan) ? $profile->status_pernikahan : "" }}</p>
                    </div>
                    <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Kewarganegaraan</p>
                        <p class="mt-1 text-sm text-slate-800">{{ !empty($profile->kewarganegaraan) ? $profile->kewarganegaraan : "" }}</p>
                    </div>
                    <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Tempat Asal</p>
                        <p class="mt-1 text-sm text-slate-800">{{ !empty($profile->tempat_asal) ? $profile->tempat_asal : "" }}</p>
                    </div>
                    <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 md:col-span-2">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Alamat Sekarang</p>
                        <p class="mt-1 text-sm text-slate-800">{{ !empty($profile->alamat_sekarang) ? $profile->alamat_sekarang : "" }}</p>
                    </div>
                    <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Agama</p>
                        <p class="mt-1 text-sm text-slate-800">{{ !empty($profile->agama) ? $profile->agama : "" }}</p>
                    </div>
                    <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Hijab</p>
                        <p class="mt-1 text-sm text-slate-800">{{ !empty($profile->hijab) ? $profile->hijab : "" }}</p>
                    </div>
                    <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Salat</p>
                        <p class="mt-1 text-sm text-slate-800">{{ !empty($profile->salat) ? $profile->salat : "" }}</p>
                    </div>
                    <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Toleransi Babi</p>
                        <p class="mt-1 text-sm text-slate-800">{{ !empty($profile->toleransi_babi) ? $profile->toleransi_babi : "" }}</p>
                    </div>
                    <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Toleransi Alkohol</p>
                        <p class="mt-1 text-sm text-slate-800">{{ !empty($profile->toleransi_alkohol) ? $profile->toleransi_alkohol : "" }}</p>
                    </div>
                    <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Tanggal Masuk Jepang</p>
                        <p class="mt-1 text-sm text-slate-800">{{ !empty($profile->tanggal_masuk_jepang) ? date('d-m-Y', strtotime($profile->tanggal_masuk_jepang)) : "" }}</p>
                    </div>
                    <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Status Izin Tinggal</p>
                        <p class="mt-1 text-sm text-slate-800">{{ !empty($profile->status_izin_tinggal) ? $profile->status_izin_tinggal : "" }}</p>
                    </div>
                    <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Masa Berlaku Kartu</p>
                        <p class="mt-1 text-sm text-slate-800">{{ !empty($profile->masa_berlaku_kartu) ? date('d-m-Y', strtotime($profile->masa_berlaku_kartu)) : "" }}</p>
                    </div>
                    <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Tanggal Mulai Kerja</p>
                        <p class="mt-1 text-sm text-slate-800">{{ !empty($profile->tanggal_mulai_kerja) ? date('d-m-Y', strtotime($profile->tanggal_mulai_kerja)) : "" }}</p>
                    </div>
                    <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Kemampuan Bahasa</p>
                        <p class="mt-1 text-sm text-slate-800">N4</p>
                    </div>
                    <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Ujian Keterampilan</p>
                        <p class="mt-1 text-sm text-slate-800">SSW</p>
                    </div>
                    <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Kepemilikan SIM</p>
                        <p class="mt-1 text-sm text-slate-800">B1</p>
                    </div>
                </div>

                <div class="mt-8 flex flex-col items-start justify-between gap-4 border-t border-slate-200 pt-6 sm:flex-row sm:items-center">
                    <button type="button" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 hover:border-slate-300">Ajukan Perubahan</button>
                </div>
            </div>
        </div>
    </main>
</section>
