# Plan Setup Advanced Vacancies Sorting In Admin

## Tujuan
- Menambahkan advanced filter dan sorting pada data vacancies di halaman admin manajemen loker.
- Membantu admin mencari lowongan kerja secara lebih spesifik berdasarkan beberapa kriteria penting.
- Memanfaatkan Laravel Spatie Query Builder yang sudah terinstall di project agar query filter dan sorting lebih aman, rapi, dan mudah dikembangkan.

## Ruang Lingkup
- Penyesuaian halaman admin seluruh lowongan kerja di `resources/views/admin/vacancy/all.blade.php`.
- Penyesuaian query data vacancies pada controller/model existing yang sudah digunakan untuk halaman admin loker.
- Penggunaan Spatie Query Builder untuk allowed filter dan allowed sort.
- Penambahan modal advanced filter pada halaman admin loker.
- Memastikan pagination tetap berjalan ketika data sedang difilter atau disort.

## Batasan Scope
- Tidak membuat modul admin baru.
- Tidak mengubah struktur tabel `vacancies`.
- Tidak mengubah flow create, update, detail, delete, atau status lowongan kecuali jika dibutuhkan untuk menjaga konsistensi filter.
- Tidak menambah filter di luar daftar yang diminta.
- Tidak mengubah halaman landing/public vacancies.
- Tidak mengganti keseluruhan UI halaman admin loker, cukup tambahkan advanced filter/sorting sesuai kebutuhan.

## Kondisi Existing Project
- Halaman admin semua loker berada di `resources/views/admin/vacancy/all.blade.php`.
- Controller yang menangani data loker admin adalah controller/model existing yang sudah tersedia.
- Model `Vacancy` sudah memiliki beberapa accessor dan scope yang dapat tetap dimanfaatkan.
- Package `spatie/laravel-query-builder` sudah tersedia di dependency project.
- Halaman create loker sudah memiliki daftar opsi yang dapat dijadikan referensi nilai filter, terutama untuk pilihan penempatan/prefektur Jepang.

## Prinsip Implementasi
- Gunakan whitelist filter dan sort melalui Spatie Query Builder.
- Jangan menerima nama kolom sort/filter secara bebas dari request tanpa allowed list.
- Pertahankan parameter pencarian existing jika masih digunakan.
- Query filter harus mudah diuji dan mudah dikembangkan.
- UI filter harus tetap sederhana, jelas, dan tidak mengganggu list loker utama.
- Pagination wajib mempertahankan query string filter/sort yang sedang aktif.
- Setiap filter yang aktif harus bisa dihapus dari modal sebelum tombol terapkan filter diklik.

## Arah Backend

### 1. Query Builder
- Gunakan Spatie Query Builder pada query daftar vacancies admin.
- Tentukan allowed filters secara eksplisit untuk field yang boleh difilter.
- Tentukan allowed sorts secara eksplisit untuk field yang boleh disort.
- Gunakan exact filter untuk field enum atau field dengan pilihan tetap.
- Pertahankan pencarian keyword existing jika diperlukan, dengan pola yang tetap aman.

### 2. Filter yang Didukung
- `visa_type`
- `placement`
- `gender_requirement`
- `domicile_requirement`
- `jlpt_requirement`
- `kaiwa_requirement`
- `status`

### 3. Sorting yang Didukung
- Sorting `job_code` dari A to Z.
- Sorting `job_code` dari Z to A.
- Gunakan format sorting yang konsisten dengan Spatie Query Builder, misalnya ascending dan descending melalui parameter sort yang terkontrol.

### 4. Pagination
- Data loker harus menggunakan pagination.
- Pagination harus mempertahankan query string aktif, seperti pencarian, filter, dan sort.
- Ketika admin berpindah halaman, hasil tetap berada dalam konteks filter/sort yang sama.

## Arah UI

### 1. Area Search dan Filter Button
- Pada `resources/views/admin/vacancy/all.blade.php`, tambahkan tombol persegi dengan icon filter.
- Letakkan tombol tersebut di ujung kanan sejajar dengan field pencarian.
- Tombol harus terlihat sebagai action sekunder yang jelas, bukan menggantikan field pencarian.
- Tombol filter membuka modal advanced filter.

### 2. Modal Advanced Filter
- Modal berisi tools filter dan sorting sesuai daftar requirement.
- Modal harus memiliki tombol terapkan filter.
- Modal harus memiliki cara untuk menutup tanpa menerapkan perubahan.
- Modal harus menampilkan nilai filter yang sedang aktif dari query request.
- Setiap filter aktif harus punya remove filter di dalam modal.
- Remove filter hanya menghapus nilai pada modal; data diperbarui setelah admin klik terapkan filter.

### 3. Field di Modal
- Sorting kode loker `job_code` menggunakan pilihan A to Z dan Z to A.
- Jenis visa `visa_type` menggunakan dropdown dengan pilihan:
  - Tokutei Ginou 1
  - Tokutei Ginou 2
  - Kaigo Visa
  - Gijinkoku
- Penempatan `placement` menggunakan dropdown seluruh prefektur Jepang sesuai referensi pada halaman create loker.
- Syarat jenis kelamin `gender_requirement` menggunakan radio button.
- Syarat domisili `domicile_requirement` menggunakan radio button.
- Syarat JLPT `jlpt_requirement` menggunakan radio button.
- Syarat kaiwa `kaiwa_requirement` menggunakan radio button.
- Status `status` menggunakan radio button.

## Nilai Filter yang Disarankan

### Gender Requirement
- Laki-laki
- Perempuan
- Laki-laki & Perempuan

### Domicile Requirement
- Khusus Jepang
- Bebas di luar Jepang
- Domisili luar dan dalam Jepang

### JLPT Requirement
- N5
- N4
- N3
- N2
- N1
- Bebas

### Kaiwa Requirement
- N5
- N4
- N3
- N2
- N1

### Status
- Aktif
- Nonaktif

## Perilaku User
- Admin membuka halaman manajemen loker.
- Admin dapat memakai pencarian biasa seperti sebelumnya.
- Admin menekan tombol filter untuk membuka modal advanced filter.
- Admin memilih satu atau beberapa filter.
- Admin dapat menghapus filter tertentu dari modal sebelum menerapkan perubahan.
- Admin klik tombol terapkan filter.
- Sistem menampilkan data loker sesuai filter dan sorting yang dipilih.
- Jika hasil memiliki banyak data, pagination tetap bekerja dan mempertahankan filter aktif.

## File yang Berpotensi Disesuaikan
- `resources/views/admin/vacancy/all.blade.php`
- `app/Http/Controllers/VacancyController.php`
- `app/Models/Vacancy.php`
- File request/filter/helper tambahan jika dibutuhkan untuk menjaga controller tetap rapi.
- Test feature untuk halaman admin vacancies jika diperlukan.

## Tahapan Implementasi

### Fase 1 - Review Existing
- Review query daftar vacancies admin yang saat ini digunakan.
- Review struktur view `all.blade.php`, terutama area search dan list data.
- Review opsi field di halaman create loker sebagai referensi nilai filter.

### Fase 2 - Backend Query
- Terapkan Spatie Query Builder pada query daftar vacancies admin.
- Tambahkan allowed filters sesuai scope.
- Tambahkan allowed sort untuk `job_code`.
- Pastikan query pencarian existing tetap kompatibel.
- Ubah output data menjadi pagination.

### Fase 3 - UI Filter Button dan Modal
- Tambahkan tombol filter sejajar dengan field pencarian.
- Buat modal advanced filter pada halaman admin loker.
- Tambahkan field filter dan sorting sesuai requirement.
- Pastikan modal membaca nilai filter aktif dari request.

### Fase 4 - Remove Filter dan Apply Filter
- Tambahkan remove filter untuk setiap field yang sedang aktif di dalam modal.
- Pastikan remove filter tidak langsung reload data sebelum tombol terapkan filter diklik.
- Tombol terapkan filter mengirim query parameter yang benar ke halaman admin vacancies.

### Fase 5 - Pagination dan State
- Pastikan pagination mempertahankan query filter, sort, dan pencarian.
- Pastikan reset filter dapat mengembalikan halaman ke daftar tanpa advanced filter.
- Pastikan count summary di bagian atas tetap jelas dan tidak membingungkan ketika data sedang difilter.

### Fase 6 - Validasi Akhir
- Cek filter satu per satu.
- Cek kombinasi beberapa filter.
- Cek sorting A to Z dan Z to A pada `job_code`.
- Cek pagination dalam kondisi filter aktif.
- Cek pencarian biasa tetap berjalan.
- Cek halaman tetap aman dari parameter filter atau sort yang tidak diizinkan.

## Kriteria Hasil
- Halaman admin vacancies memiliki tombol filter persegi dengan icon filter di ujung kanan sejajar field pencarian.
- Tombol filter membuka modal advanced filter.
- Modal menyediakan filter dan sorting sesuai requirement.
- Admin dapat menerapkan filter dan melihat hasil data loker yang sesuai.
- Admin dapat menghapus filter tertentu dari dalam modal sebelum menerapkan perubahan.
- Sorting `job_code` A to Z dan Z to A berjalan.
- Filter `visa_type`, `placement`, `gender_requirement`, `domicile_requirement`, `jlpt_requirement`, `kaiwa_requirement`, dan `status` berjalan.
- Pagination tetap berfungsi ketika filter atau sorting aktif.
- Query backend menggunakan Spatie Query Builder dengan allowed filters dan allowed sorts yang eksplisit.
- Controller dan model existing tetap digunakan sesuai scope.

## Catatan Implementasi
- Jaga implementasi tetap high level dan tidak melebar ke fitur lain.
- Jangan membuat filter yang tidak diminta pada scope ini.
- Jangan expose semua kolom database untuk filter/sort.
- Gunakan nilai option yang konsisten dengan data existing agar hasil query valid.
- Jika perlu membuat class tambahan, gunakan hanya untuk menjaga controller tetap bersih dan mudah diuji.
