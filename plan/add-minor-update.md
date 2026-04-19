# Plan Add Minor Update

## Tujuan
- Menyusun rencana minor update pada informasi lowongan kerja dengan menambahkan data cabang penempatan yang bersifat opsional.
- Menambahkan opsi baru pada field `Persyaratan Domisili` agar lowongan dapat menampung kondisi domisili luar dan dalam Jepang.
- Menjaga dokumen tetap high level, ringkas, dan cukup jelas untuk dikerjakan oleh junior programmer atau AI model dengan kemampuan terbatas.

## Ruang Lingkup
- Penambahan kolom `placement_branch` pada tabel `vacancies`.
- Penambahan field input `Cabang Penempatan` pada form create dan update lowongan.
- Penambahan opsi `Domisili Luar & Dalam Jepang` dengan value `kokunai-to-kokugai` pada field `Persyaratan Domisili`.
- Penyesuaian tampilan data agar value `kokunai-to-kokugai` ditampilkan sebagai `Domisili Bebas`.

## Prinsip Implementasi
- Fokus hanya pada perubahan minor yang disebutkan di brief dan jangan menambah fitur lain di luar scope.
- Pertahankan alur create, update, dan display lowongan yang sudah ada; cukup sisipkan kebutuhan baru pada titik yang relevan.
- Gunakan naming dan struktur yang konsisten dengan modul lowongan kerja yang sudah ada.
- Pastikan field `Cabang Penempatan` benar-benar opsional di database dan di alur input.
- Pastikan value internal tetap `kokunai-to-kokugai`, sedangkan label tampil ke user menggunakan teks yang lebih ramah dibaca.

## Arah Perubahan
### 1. Database
- Buat migration `add_branch_in_vacancies` untuk menambahkan kolom `placement_branch`.
- Gunakan tipe `string` dengan panjang `255` dan status `nullable`.
- Pastikan migration hanya menambah kolom yang dibutuhkan dan tidak mengubah struktur lain di tabel `vacancies`.

### 2. Form Create dan Update Lowongan
- Tambahkan field input `Cabang Penempatan` pada form create lowongan.
- Tambahkan field input yang sama pada form update lowongan.
- Tempatkan field baru ini di area yang masih relevan dengan informasi penempatan kerja agar tetap mudah dipahami admin.
- Perlakukan field ini sebagai input opsional, sehingga form tetap dapat disimpan ketika nilainya kosong.

### 3. Opsi Persyaratan Domisili
- Tambahkan opsi `Domisili Luar & Dalam Jepang` pada daftar pilihan field `Persyaratan Domisili`.
- Gunakan value internal `kokunai-to-kokugai`.
- Pastikan opsi baru tersedia secara konsisten di form create dan update lowongan.
- Jangan mengubah value atau perilaku opsi lama yang sudah ada.

### 4. Displayed Data
- Pada area tampilan data lowongan, value `kokunai-to-kokugai` harus ditampilkan sebagai `Domisili Bebas`.
- Penyesuaian label tampil ini harus berlaku di titik display yang saat ini menampilkan nilai `Persyaratan Domisili` ke user atau admin.
- Hindari menampilkan value mentah jika sudah ada label bisnis yang lebih sesuai.

## Dampak Alur Data
### 1. Input
- Admin dapat mengisi `Cabang Penempatan` jika informasi tersebut tersedia.
- Admin dapat memilih opsi domisili baru ketika lowongan menerima domisili luar maupun dalam Jepang.

### 2. Penyimpanan
- Sistem menyimpan `Cabang Penempatan` ke kolom `placement_branch` jika diisi.
- Sistem menyimpan value `kokunai-to-kokugai` pada field persyaratan domisili ketika opsi baru dipilih.

### 3. Penampilan
- Data `Cabang Penempatan` tampil sebagai bagian dari informasi lowongan jika tersedia.
- Value domisili `kokunai-to-kokugai` diterjemahkan menjadi `Domisili Bebas` pada tampilan data.

## Tahapan Implementasi
### Fase 1 - Penyesuaian Database
- Tambahkan migration untuk kolom `placement_branch` pada tabel `vacancies`.
- Pastikan sifat kolom sesuai brief: `string(255)` dan `nullable`.

### Fase 2 - Penyesuaian Form Lowongan
- Tambahkan field `Cabang Penempatan` ke form create dan update lowongan.
- Tambahkan opsi `Domisili Luar & Dalam Jepang` ke field `Persyaratan Domisili` pada kedua form.

### Fase 3 - Penyesuaian Penyimpanan Data
- Pastikan data `Cabang Penempatan` ikut terbaca dan tersimpan pada alur create maupun update.
- Pastikan value `kokunai-to-kokugai` diterima dan diproses sama seperti opsi domisili lainnya.

### Fase 4 - Penyesuaian Display
- Ubah mapping tampilan agar `kokunai-to-kokugai` dibaca sebagai `Domisili Bebas`.
- Pastikan informasi `Cabang Penempatan` ikut tampil jika memang ada nilainya.

### Fase 5 - Finalisasi
- Cek kembali konsistensi form create, form update, penyimpanan data, dan tampilan detail lowongan.
- Pastikan perubahan tetap terbatas pada minor update ini dan tidak memicu perubahan perilaku lain.

## Kriteria Hasil
- Tabel `vacancies` memiliki kolom `placement_branch` dengan tipe `string(255)` dan `nullable`.
- Form create lowongan memiliki field `Cabang Penempatan` yang bersifat opsional.
- Form update lowongan memiliki field `Cabang Penempatan` yang bersifat opsional.
- Field `Persyaratan Domisili` memiliki opsi `Domisili Luar & Dalam Jepang` dengan value `kokunai-to-kokugai`.
- Value `kokunai-to-kokugai` ditampilkan sebagai `Domisili Bebas` pada displayed data.
- Perubahan berjalan konsisten di alur create, update, dan display lowongan.

## Catatan Implementasi
- Jangan memperluas scope ke perubahan field lowongan lain, refactor besar, atau redesign halaman form.
- Jangan mengubah aturan existing selain yang dibutuhkan untuk menambah `placement_branch` dan opsi domisili baru.
- Fokus pada minor update yang diminta: database, form create/update, penyimpanan, dan displayed label.
