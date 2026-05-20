# Plan Setup TSK Candidate Pages

## Tujuan
- Membuat halaman khusus untuk pengguna TSK (Toroku Shien Kikan) agar dapat melihat kandidat yang sudah terdaftar.
- Menyediakan dua halaman utama:
  - halaman katalog kandidat untuk menampilkan seluruh kandidat
  - halaman detail kandidat untuk menampilkan data pribadi, riwayat pendidikan, dan riwayat pekerjaan
- Implementasi harus mengikuti pattern MVC Laravel dan memakai Tailwind CSS yang sudah tersedia.

## Scope
- Menambahkan tampilan halaman TSK di dalam `resources/views/tsk`.
- Menggunakan controller TSK yang sudah disediakan di `app/Http/Controllers/TSK/TskController.php`.
- Menggunakan route group `prefix("tsk")` yang sudah tersedia di `routes/web.php`.
- Mengambil data kandidat dari data user dan relasi profile, education history, serta work experience yang sudah ada.
- Menampilkan data kandidat tanpa fitur create, edit, delete, export, filter kompleks, atau perubahan database.

## Referensi File
- Controller TSK: `app/Http/Controllers/TSK/TskController.php`
- Route: `routes/web.php`
- Referensi layout detail profile: `resources/views/user/profile.blade.php`
- Folder view target: `resources/views/tsk`
- Model utama: `app/Models/User.php`
- Relasi profile: `App\Models\User\UserProfile`
- Relasi pendidikan: `App\Models\User\UserEducationHistory`
- Relasi pengalaman kerja: `App\Models\User\WorkExperience`

## Arah Arsitektur
- Gunakan `User` sebagai model utama untuk kandidat.
- Gunakan relasi Eloquent yang sudah tersedia:
  - `userProfile`
  - `educationHistories`
  - `workExperiences`
- Controller TSK bertanggung jawab mengambil data, melakukan pagination, dan mengirim data ke view.
- View hanya bertanggung jawab untuk rendering tampilan dan tidak berisi query database.
- Gunakan eager loading agar halaman katalog dan detail tidak menghasilkan query berulang yang tidak perlu.

## Halaman 1: Katalog Kandidat

### Tujuan Halaman
- Menampilkan daftar kandidat yang dapat dipindai cepat oleh pengguna TSK.
- Tampilan dibuat seperti katalog produk atau web bursa transfer pemain bola.

### Data Yang Ditampilkan
- Foto profile kandidat.
- Nama lengkap.
- Furigana.
- Umur.
- Link atau tombol menuju halaman detail kandidat.

### Aturan Tampilan
- Gunakan grid 4 kolom pada desktop.
- Pada tablet dan mobile, grid harus turun secara responsif agar tetap rapi.
- Setiap kandidat ditampilkan sebagai card sederhana dengan visual utama foto profile.
- Jika kandidat belum memiliki foto profile, tampilkan placeholder foto profile yang rapi.
- Gunakan desain simpel, minimalist, clean, dan tetap eye catching.
- Bungkus grid kandidat dalam container dengan margin kiri-kanan cukup besar agar halaman terasa modern dan tidak penuh ke tepi layar.

### Pagination
- Data kandidat ditampilkan dengan pagination.
- Jumlah kandidat per halaman adalah 35 data.
- Pagination harus mengikuti style sederhana dan konsisten dengan Tailwind CSS.

## Halaman 2: Detail Kandidat

### Tujuan Halaman
- Menampilkan informasi lengkap satu kandidat untuk kebutuhan review oleh TSK.
- Layout mengikuti pola `resources/views/user/profile.blade.php`.

### Layout Utama
- Gunakan grid utama dua area:
  - sisi kiri untuk foto profile kandidat
  - sisi kanan untuk data kandidat
- Pada sisi kanan, urutan section wajib:
  - data pribadi
  - riwayat pendidikan
  - riwayat pekerjaan
- Pada mobile, semua section stack vertikal agar tetap nyaman dibaca.

### Data Pribadi
- Tampilkan field profile penting yang sudah tersedia pada data profile user.
- Gunakan pola tampilan label kecil di atas dan nilai data di bawah seperti halaman profile user.
- Jika ada data kosong, tampilkan placeholder `-` agar layout tetap stabil.

### Riwayat Pendidikan
- Tampilkan riwayat pendidikan dalam bentuk table.
- Table minimal memuat informasi pendidikan, institusi, lokasi, periode, dan status.
- Jika tidak ada data, tampilkan empty state sederhana.
- Table wajib dibungkus overflow horizontal agar tidak merusak layout mobile.

### Riwayat Pekerjaan
- Tampilkan riwayat pengalaman kerja dalam bentuk table.
- Table minimal memuat bidang kerja, perusahaan, lokasi, periode kerja, status pekerjaan, dan tipe visa bila tersedia.
- Jika tidak ada data, tampilkan empty state sederhana.
- Table wajib dibungkus overflow horizontal agar tidak merusak layout mobile.

## Layout TSK
- Gunakan layout Blade standar Laravel.
- Buat layout sederhana untuk halaman TSK bila belum tersedia.
- Navbar berada di bagian atas.
- Logo Nihonskuy ditempatkan di sisi kanan navbar.
- Tombol logout ditempatkan di sisi kiri navbar.
- Konten utama berada di bawah navbar dengan wrapper lebar maksimum dan margin horizontal yang cukup.
- Gunakan Tailwind CSS langsung di Blade sesuai pola project.

## Rencana Perubahan MVC

### 1. Route
- Lengkapi route dalam group `prefix("tsk")`.
- Sediakan route untuk halaman katalog kandidat.
- Sediakan route untuk halaman detail kandidat berdasarkan ID user.
- Pastikan nama route mudah dipakai dari Blade.

### 2. Controller
- Tambahkan method untuk halaman katalog kandidat.
- Tambahkan method untuk halaman detail kandidat.
- Method katalog mengambil kandidat dengan relasi profile dan pagination 35 data.
- Method detail mengambil satu kandidat dengan relasi profile, education histories, dan work experiences.
- Jika kandidat tidak ditemukan, gunakan mekanisme 404 Laravel.

### 3. View
- Buat view katalog kandidat di folder `resources/views/tsk`.
- Buat view detail kandidat di folder `resources/views/tsk`.
- Buat atau gunakan layout TSK sederhana yang konsisten untuk kedua halaman.
- Pastikan seluruh tampilan menggunakan Tailwind CSS yang sudah tersedia.

## Prinsip Desain
- Tampilan harus sederhana, minimalist, modern, dan mudah dipindai.
- Gunakan warna netral, border halus, shadow ringan, dan spacing yang konsisten.
- Hindari komponen yang terlalu ramai atau fitur visual di luar kebutuhan TSK.
- Card kandidat harus menonjolkan foto, nama, furigana, dan umur.
- Halaman detail harus memprioritaskan keterbacaan data.

## Empty State
- Jika kandidat tidak memiliki foto profile, tampilkan placeholder foto.
- Jika kandidat tidak memiliki profile lengkap, tampilkan placeholder data kosong.
- Jika riwayat pendidikan kosong, tampilkan pesan kosong yang jelas.
- Jika riwayat pekerjaan kosong, tampilkan pesan kosong yang jelas.

## Acceptance Criteria
- Pengguna TSK dapat membuka halaman katalog kandidat.
- Katalog menampilkan kandidat dalam grid 4 kolom pada desktop.
- Katalog memakai pagination 35 kandidat per halaman.
- Setiap card kandidat menampilkan foto atau placeholder, nama lengkap, furigana, dan umur.
- Pengguna TSK dapat membuka halaman detail kandidat dari katalog.
- Detail kandidat menampilkan foto di sisi kiri dan data di sisi kanan pada desktop.
- Data pribadi tampil sebelum riwayat pendidikan dan riwayat pekerjaan.
- Riwayat pendidikan tampil dalam bentuk table.
- Riwayat pekerjaan tampil dalam bentuk table.
- Seluruh halaman berada di folder `resources/views/tsk`.
- Implementasi memakai MVC Laravel dan tidak menaruh query database di Blade.
- Tidak ada perubahan database atau fitur tambahan di luar scope dokumen ini.

## Batasan Scope
- Jangan membuat fitur tambah, ubah, atau hapus kandidat.
- Jangan membuat fitur pencarian atau filter lanjutan kecuali sudah diminta terpisah.
- Jangan membuat export PDF, Excel, atau print.
- Jangan mengubah struktur database.
- Jangan mengubah halaman user profile existing kecuali hanya dijadikan referensi.
- Jangan membuat redesign global layout aplikasi.
- Jangan menambahkan package baru.

## Catatan Untuk Implementer
- Kerjakan hanya file yang relevan dengan halaman TSK.
- Ikuti tampilan detail dari `resources/views/user/profile.blade.php` sebagai acuan utama.
- Gunakan data dan relasi yang sudah tersedia di model.
- Jika ada perbedaan nama controller pada filesystem, ikuti nama class dan file yang benar di project saat implementasi.
- Setelah selesai, cek manual halaman katalog, pagination, halaman detail, foto placeholder, dan kondisi data riwayat kosong.
