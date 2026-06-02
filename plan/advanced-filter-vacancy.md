# PRD Advanced Filter Vacancy untuk Pengguna Umum

## Tujuan
- Membuat fitur filter lowongan kerja yang lebih luas untuk pengguna umum.
- Membantu pengguna mencari lowongan berdasarkan preferensi kerja masing-masing.
- Menempatkan akses filter pada halaman publik yang sudah digunakan pengguna untuk mencari lowongan.

## Ruang Lingkup
- Penambahan tombol pembuka filter pada:
  - `resources/views/landing/main.blade.php`
  - `resources/views/landing/explore.blade.php`
- Penambahan modal untuk mengatur preferensi filter lowongan kerja.
- Penyesuaian proses pencarian lowongan agar menerima filter dari modal.
- Filter hanya menggunakan data yang sudah tersedia pada tabel `vacancies`.

## Batasan Scope
- Tidak membuat tabel baru.
- Tidak menambah kolom baru pada tabel `vacancies`.
- Tidak mengubah flow admin create, update, delete, atau status lowongan.
- Tidak membuat halaman baru untuk filter.
- Tidak menambah filter di luar daftar yang sudah ditentukan.
- Tidak mengubah desain besar landing page, cukup menambahkan tombol dan modal filter.
- Tidak mengubah fungsi pencarian existing selain agar bisa berjalan bersama advanced filter.

## Target Pengguna
- Pengguna umum yang sedang mencari lowongan kerja Jepang.
- Pengguna yang ingin menyaring lowongan berdasarkan lokasi, visa, kemampuan bahasa, pengalaman, domisili, jenis kelamin, kuota, gaji, dan benefit.

## Prinsip Implementasi
- Filter harus mudah ditemukan dan mudah digunakan.
- Tombol filter tidak boleh mengganggu pencarian keyword dan lokasi yang sudah ada.
- Modal filter harus menampilkan pilihan dengan bahasa yang jelas untuk pengguna umum.
- Query filter harus hanya menerima field yang memang diizinkan.
- Filter yang aktif harus tetap terbaca ketika pengguna membuka halaman hasil pencarian.
- Pagination pada halaman explore harus tetap mempertahankan filter yang sedang aktif.
- Implementasi harus tetap sederhana dan mengikuti pola project yang sudah ada.

## Arah UI

### 1. Tombol Filter
- Sediakan tombol dengan icon filter atau teks `Cari Preferensi Kerjamu`.
- Tombol ditempatkan di area pencarian pada halaman landing utama dan halaman explore.
- Ketika tombol diklik, sistem menampilkan modal advanced filter.
- Tombol harus terlihat sebagai action tambahan, bukan menggantikan tombol `Cari`.

### 2. Modal Advanced Filter
- Modal berisi seluruh pilihan filter sesuai daftar requirement.
- Modal memiliki tombol untuk menerapkan filter.
- Modal memiliki tombol untuk menutup tanpa menerapkan perubahan.
- Modal memiliki pilihan untuk menghapus atau mengosongkan filter yang sedang dipilih.
- Nilai filter yang sudah aktif harus tetap tampil ketika modal dibuka kembali.

### 3. Hasil Filter
- Pada halaman `main`, filter diarahkan ke halaman daftar lowongan atau route pencarian lowongan existing.
- Pada halaman `explore`, hasil lowongan langsung mengikuti filter yang diterapkan.
- Jika tidak ada hasil, gunakan empty state existing atau teks kosong yang tetap ramah untuk pengguna umum.

## Daftar Filter

| Label | Kolom Tabel | Tipe Input | Pilihan |
| --- | --- | --- | --- |
| Penempatan/Lokasi Kerja | `placement` | Text | Input bebas |
| Jenis VISA | `visa_type` | Select option | Tokutei Ginou 1, Tokutei Ginou 2, Kaigo Visa, Gijinkoku |
| Gaji | `Salary` | Text | Input bebas |
| Level JLPT | `jlpt_requirement` | Select option | n5, n4, n3, n2, n1, all |
| Level Kaiwa | `kaiwa_requirement` | Select option | n5, n4, n3, n2, n1, all |
| Persyaratan Pengalaman | `exp_requirement` | Select option | Min. 6 Bulan Pengalaman, Min. 1 Tahun Pengalaman |
| Syarat Domisili | `domicile_requirement` | Select option | Domisili Jepang, Domisili Indonesia, Domisili Jepang & Indonesia |
| Syarat Jenis Kelamin | `gender_requirement` | Radio | Laki-laki, Perempuan, Laki-laki & Perempuan |
| Kuota dibutuhkan | `qty` | Radio button | < 10, < 30, < 50, > 100 |
| Benefit | `benefit` | Checkbox | Kenaikan Gaji, Bonus, Lembur, Shift Malam, Asrama, Tunjangan Asrama, Tunjangan Kendaraan, Tunjangan Sertifikat, Toleransi Babi, Toleransi Ibadah, Toleransi Hijab, Makan Gratis, Support TG2, Support Kaigo, Tunjangan Lainnya |

## Nilai Filter yang Wajib Dipakai

### Jenis VISA
- `Tokutei Ginou 1`
- `Tokutei Ginou 2`
- `Kaigo Visa`
- `Gijinkoku`

### Level JLPT
- `n5`
- `n4`
- `n3`
- `n2`
- `n1`
- `all`

### Level Kaiwa
- `n5`
- `n4`
- `n3`
- `n2`
- `n1`
- `all`

### Persyaratan Pengalaman
- `Min. 6 Bulan Pengalaman`
- `Min. 1 Tahun Pengalaman`

### Syarat Domisili
- Label: `Domisili Jepang`, value: `kokunai`
- Label: `Domisili Indonesia`, value: `kokugai`
- Label: `Domisili Jepang & Indonesia`, value: `kokunai-to-kokugai`

### Syarat Jenis Kelamin
- Label: `Laki-laki`, value: `l`
- Label: `Perempuan`, value: `p`
- Label: `Laki-laki & Perempuan`, value: `a`

### Kuota Dibutuhkan
- `< 10`
- `< 30`
- `< 50`
- `> 100`

### Benefit
- `Kenaikan Gaji`
- `Bonus`
- `Lembur`
- `Shift Malam`
- `Asrama`
- `Tunjangan Asrama`
- `Tunjangan Kendaraan`
- `Tunjangan Sertifikat`
- `Toleransi Babi`
- `Toleransi Ibadah`
- `Toleransi Hijab`
- `Makan Gratis`
- `Support TG2`
- `Support Kaigo`
- `Tunjangan Lainnya`

## Arah Backend
- Gunakan query daftar lowongan existing sebagai dasar.
- Tambahkan dukungan filter berdasarkan parameter yang dikirim dari modal.
- Batasi parameter filter hanya pada daftar field yang disebutkan di dokumen ini.
- Field berbentuk pilihan tetap menggunakan pencocokan nilai yang sesuai.
- Field berbentuk text dapat memakai pencarian yang fleksibel sesuai pola pencarian existing.
- Filter benefit harus mampu membaca satu atau beberapa pilihan benefit.
- Filter kuota harus mengikuti kategori angka yang dipilih pengguna.
- Pastikan query tetap hanya menampilkan lowongan yang memang layak tampil untuk publik.

## Alur Pengguna
- Pengguna membuka halaman utama atau halaman explore.
- Pengguna klik tombol `Cari Preferensi Kerjamu` atau tombol filter.
- Sistem menampilkan modal advanced filter.
- Pengguna memilih satu atau beberapa preferensi.
- Pengguna klik tombol terapkan filter.
- Sistem menampilkan daftar lowongan yang sesuai dengan preferensi tersebut.
- Pengguna dapat mengubah atau mengosongkan filter dari modal yang sama.

## File yang Berpotensi Disesuaikan
- `resources/views/landing/main.blade.php`
- `resources/views/landing/explore.blade.php`
- Controller yang menangani halaman landing dan explore lowongan.
- Model atau helper query lowongan jika dibutuhkan untuk menjaga controller tetap rapi.
- File JavaScript landing jika modal membutuhkan interaksi tambahan.

## Tahapan Implementasi

### Fase 1 - Review Existing
- Review alur pencarian lowongan yang sudah ada di halaman main dan explore.
- Review query lowongan publik yang sedang digunakan.
- Review struktur data benefit, gaji, kuota, dan field requirement pada tabel `vacancies`.

### Fase 2 - Backend Filter
- Tambahkan penerimaan parameter advanced filter pada query lowongan publik.
- Terapkan filter sesuai daftar field yang sudah ditentukan.
- Pastikan filter bisa berjalan sendiri maupun dikombinasikan dengan pencarian existing.
- Pastikan pagination tetap membawa parameter filter aktif.

### Fase 3 - UI Tombol dan Modal
- Tambahkan tombol filter pada halaman main.
- Tambahkan tombol filter pada halaman explore.
- Buat modal advanced filter dengan input sesuai daftar requirement.
- Pastikan nilai filter aktif dapat tampil kembali di modal.

### Fase 4 - Integrasi Hasil
- Hubungkan tombol terapkan filter dengan route pencarian lowongan.
- Pastikan halaman main mengarahkan pengguna ke hasil lowongan yang sesuai.
- Pastikan halaman explore langsung menampilkan hasil sesuai filter.
- Siapkan cara reset filter agar pengguna bisa kembali melihat semua lowongan.

### Fase 5 - Validasi Akhir
- Cek setiap filter secara terpisah.
- Cek kombinasi beberapa filter.
- Cek pencarian keyword dan lokasi tetap berjalan bersama advanced filter.
- Cek pagination ketika filter aktif.
- Cek tampilan modal di desktop dan mobile.

## Kriteria Hasil
- Halaman `resources/views/landing/main.blade.php` memiliki tombol untuk membuka modal filter preferensi kerja.
- Halaman `resources/views/landing/explore.blade.php` memiliki tombol untuk membuka modal filter preferensi kerja.
- Modal filter menyediakan seluruh field sesuai daftar requirement.
- Pengguna umum dapat menerapkan satu atau beberapa filter lowongan.
- Hasil lowongan mengikuti preferensi yang dipilih pengguna.
- Filter aktif tetap terbawa saat pengguna berpindah halaman pagination.
- Pengguna dapat mengosongkan filter dan kembali melihat daftar lowongan tanpa advanced filter.
- Tidak ada perubahan struktur database pada scope fitur ini.

## Catatan Implementasi
- Dokumen ini hanya membahas fitur advanced filter untuk pengguna umum.
- Jangan menambahkan filter admin dalam scope ini.
- Jangan membuat redesign besar landing page.
- Gunakan label yang ramah untuk pengguna, tetapi tetap simpan value sesuai kebutuhan query.
- Jika ditemukan perbedaan nama kolom di database, ikuti nama kolom aktual tanpa mengubah maksud filter.
