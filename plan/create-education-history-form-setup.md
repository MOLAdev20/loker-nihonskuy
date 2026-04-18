# Plan Create Education History Form

## Tujuan
- Menyusun rencana pembuatan halaman riwayat pendidikan user pada route `/my/education-history` dengan pendekatan arsitektur MVC.
- Menyiapkan alur CRUD riwayat pendidikan agar 1 user dapat menambah, melihat, mengubah, dan menghapus lebih dari satu data pendidikan mereka.
- Menjaga agar implementasi tetap high level, terstruktur, dan cukup jelas untuk dikerjakan oleh junior fullstack programmer atau AI model dengan kemampuan terbatas.

## Ruang Lingkup
- Pembuatan halaman daftar riwayat pendidikan user.
- Pembuatan form create dan edit riwayat pendidikan berbasis modal.
- Penyesuaian route untuk tampil data, simpan data baru, ubah data, dan hapus data.
- Penyusunan alur MVC antara route, controller, request validation, model, dan view.
- Validasi input di sisi server beserta penampilan error pada UI.
- Penyimpanan, perubahan, dan penghapusan data pada tabel `user_education_history`.

## Prinsip Implementasi
- Gunakan pendekatan MVC secara tegas agar tanggung jawab route, controller, request validation, model, dan view tetap terpisah.
- Pindahkan process logic education history dari `User/ProfileController` ke `User/EducationController`.
- Gunakan naming `camelCase` untuk variabel, function, method, dan identifier baru.
- Pastikan halaman mengikuti layout dasar area content yang sudah digunakan pada halaman profile dashboard.
- Fokus pada pengalaman input yang rapi, ringan, responsif, dan mudah dipahami user.
- Hindari logika validasi langsung di Blade; validasi harus berada di sisi server.
- Jangan menambah fitur di luar scope CRUD education history pada `user_education_history`.

## Arah Arsitektur MVC
### 1. Route
- Sediakan route `GET /my/education-history` untuk menampilkan halaman daftar riwayat pendidikan.
- Sediakan route `POST /my/education-history` untuk menyimpan data pendidikan baru.
- Sediakan route update untuk mengubah satu data pendidikan berdasarkan `id`.
- Sediakan route delete untuk menghapus satu data pendidikan berdasarkan `id`.
- Pastikan seluruh route berada dalam area user yang membutuhkan autentikasi.

### 2. Controller
- Gunakan `User/EducationController` sebagai titik orkestrasi seluruh flow education history.
- Controller bertugas menampilkan daftar data milik user, menerima request create dan update yang sudah tervalidasi, lalu memproses delete per data.
- Controller harus memastikan setiap aksi edit atau hapus hanya bisa dilakukan pada data yang dimiliki user yang sedang login.
- Controller hanya mengelola flow aplikasi, bukan memuat detail validasi panjang atau logika tampilan.

### 3. Request Validation
- Gunakan request object khusus agar aturan validasi terpisah dari controller.
- Seluruh aturan validasi harus mengikuti requirement field yang sudah ditentukan.
- Pesan error harus formal, singkat, berbahasa Indonesia, dan relevan dengan jenis kesalahan input.
- Validasi create dan update harus konsisten agar perilaku form tetap seragam.

### 4. Model
- Gunakan model yang merepresentasikan tabel `user_education_history`.
- Pastikan relasi data ke user terhubung dengan bersih melalui `user_id`.
- Pastikan query data selalu dibatasi pada milik user yang sedang login agar aman untuk aksi edit dan hapus.

### 5. View
- Gunakan view `user/education-history-form.blade.php`.
- Layout dasar mengikuti pola section content dari `profile.blade.php` agar tampilan tetap konsisten dengan dashboard user.
- Blade difokuskan untuk rendering daftar data, tombol aksi, modal create/edit, old input, state error, dan feedback visual validasi.

## Struktur Halaman
### 1. Layout Konten
- Tempatkan halaman di dalam card atau panel utama yang konsisten dengan gaya dashboard user.
- Sediakan judul halaman, subjudul singkat, tombol tambah riwayat pendidikan, dan area daftar data.
- Pertahankan tampilan modern, minimalist, soft, dan tetap dekat dengan pola input Bootstrap yang bersih.

### 2. Komponen Modal
- Gunakan `components/modal.blade.php` sebagai dasar modal create dan edit.
- Saat tombol tambah diklik, modal muncul berisi form input pendidikan baru.
- Saat tombol edit diklik, modal muncul berisi form dengan data existing dari row yang dipilih.
- Setelah simpan berhasil, modal tertutup otomatis dan daftar data pada halaman utama tampil dalam kondisi terbaru.

### 3. Tampilan Daftar Data
- Tampilkan data pendidikan yang sudah diinput dalam layout yang paling mudah dipindai dan diubah.
- Untuk kebutuhan data berulang dengan aksi per baris, gunakan tabel responsif sebagai pilihan utama.
- Pada mobile, pastikan daftar tetap nyaman dibaca, baik melalui stacking yang rapi maupun pola tabel yang masih usable.
- Setiap row data harus memiliki tombol edit dan hapus yang jelas.

### 4. Responsivitas
- Gunakan block layout dari atas ke bawah untuk mobile pada area form modal.
- Gunakan grid untuk medium sampai large screen agar field di dalam modal lebih ringkas dan nyaman dipindai.
- Pastikan jarak antar field, label, helper state, tombol aksi, dan daftar data tetap konsisten di semua ukuran layar.

### 5. Pola Komponen Input
- Setiap field memiliki label yang jelas, elemen input utama, dan area error text di bawah input.
- Saat validasi gagal, border field berubah merah dan error text ditampilkan dengan ukuran kecil (`text-xs`).
- Nilai input sebelumnya harus tetap tampil kembali agar user tidak perlu mengisi ulang seluruh form.

## Spesifikasi Field Form
| Field | Tipe Input | Aturan Utama | Label |
| --- | --- | --- | --- |
| `education` | Select | required, pilih salah satu dari `SMP`, `SMK`, `SMA`, `D1`, `D2`, `D3`, `D4`, `S1`, `S2`, `S3` | Jenjang Pendidikan |
| `institution` | Text | min 3, max 255, required | Nama Institusi/Sekolah/Perguruan |
| `location` | Text | required | Lokasi Institusi/Sekolah/Perguruan |
| `dateOfEntry` | Date | required | Tanggal Masuk |
| `dateOfGraduation` | Date | mengikuti requirement form | Tanggal Lulus |
| `dateOfDroppedOut` | Date | mengikuti requirement form | Tanggal Berhenti/Putus Sekolah (Jika ada) |
| `status` | Radio | required, `graduated` / `studying` / `droppedOut` | Status |

## Rencana Validasi Server
- Validasi harus dilakukan penuh di sisi server sebelum data disimpan atau diubah.
- Gunakan aturan validasi yang konsisten dengan tipe field, batas minimal, batas maksimal, dan status required.
- Untuk select dan radio, pastikan hanya nilai yang diizinkan yang dapat diterima.
- Untuk field tanggal, pastikan format data sesuai tipe yang diharapkan dan hubungan antar tanggal tetap masuk akal.
- Tampilkan pesan validasi tepat di bawah field terkait, bukan dikumpulkan menjadi satu blok global saja.

## Rencana UI dan UX
- Gunakan Tailwind CSS dengan pendekatan visual yang bersih, lembut, dan modern.
- Input text, select, radio, dan date harus memiliki tinggi, padding, border, radius, dan focus state yang seragam.
- Error state harus terlihat jelas tetapi tetap halus, terutama melalui border merah dan text error kecil di bawah field.
- Tombol tambah, simpan, edit, dan hapus harus mudah dikenali serta tetap selaras dengan visual dashboard.
- Gunakan confirm sebelum aksi hapus dijalankan agar user tidak menghapus data secara tidak sengaja.

## Rencana Alur Data
### 1. Tampil Halaman
- User mengakses `GET /my/education-history`.
- Sistem menampilkan halaman daftar riwayat pendidikan milik user di area content dashboard.

### 2. Tambah Data
- User menekan tombol tambah riwayat pendidikan.
- Sistem membuka modal create yang memuat form input.
- User submit form ke route create.
- Jika validasi gagal, modal tetap menjadi konteks utama dengan pesan error per field.
- Jika validasi lolos, data baru disimpan dan halaman menampilkan row baru pada daftar data.

### 3. Edit Data
- User menekan tombol edit pada salah satu row.
- Sistem membuka modal edit yang terisi data row terpilih.
- User submit perubahan ke route update berdasarkan `id`.
- Jika validasi lolos, data pada row terkait diperbarui dan tampilan daftar menyesuaikan hasil terbaru.

### 4. Hapus Data
- User menekan tombol hapus pada salah satu row.
- Sistem meminta konfirmasi terlebih dahulu.
- Jika user menyetujui, data dihapus berdasarkan `id` dan daftar data diperbarui.

## Dependency Penting
- Tabel `user_education_history` harus mendukung penyimpanan lebih dari satu row untuk setiap user.
- Schema database harus selaras dengan requirement form, terutama untuk field tanggal yang bersifat opsional.
- Komponen `components/modal.blade.php` harus dapat dipakai ulang untuk skenario create dan edit.
- Sebelum implementasi coding dimulai, pembagian tanggung jawab antara `EducationController`, request validation, model, dan view harus disepakati agar flow CRUD tetap rapi.

## Tahapan Implementasi
### Fase 1 - Penyelarasan Kontrak Data
- Samakan daftar field form dengan field final pada tabel `user_education_history`.
- Pastikan naming request, naming model, dan naming kolom database konsisten.

### Fase 2 - Fondasi MVC
- Siapkan `EducationController`, route CRUD, request validation, dan model yang terhubung ke `user_education_history`.
- Pastikan seluruh process logic education history tidak lagi ditaruh di `ProfileController`.

### Fase 3 - Pembuatan Halaman Daftar
- Bangun halaman `user/education-history-form.blade.php` dengan struktur content dashboard.
- Tampilkan daftar data pendidikan user dalam layout utama yang mudah dipindai dan mudah dioperasikan.

### Fase 4 - Modal Create dan Edit
- Hubungkan tombol tambah dan edit ke komponen modal yang reusable.
- Pastikan form modal mendukung old input, error state, dan prefilled value untuk edit.

### Fase 5 - Finalisasi CRUD
- Pastikan create, update, dan delete berjalan per row data milik user.
- Rapikan feedback sukses, konsistensi naming, dan kualitas pengalaman user.

## Kriteria Hasil
- Route `GET /my/education-history` menampilkan daftar riwayat pendidikan user.
- User dapat menambahkan lebih dari satu data riwayat pendidikan.
- User dapat mengedit satu data pendidikan berdasarkan `id`.
- User dapat menghapus satu data pendidikan berdasarkan `id` dengan konfirmasi.
- Form create dan edit tampil melalui `components/modal.blade.php`.
- Setelah simpan berhasil, modal tertutup dan daftar data tampil dalam kondisi terbaru.
- View `user/education-history-form.blade.php` menggunakan layout content yang konsisten dengan halaman profile.
- Validasi berjalan di sisi server dan ditampilkan tepat di bawah field terkait.
- Pesan error menggunakan bahasa Indonesia formal singkat.
- Field error memiliki border merah saat validasi gagal.
- Naming baru mengikuti pola `camelCase`.

## Catatan Implementasi
- Jangan menaruh logika bisnis atau validasi kompleks di Blade.
- Jangan memperluas scope ke fitur pencarian, sorting lanjutan, pagination, API, atau workflow lain di luar instruksi ini.
- Fokus pada CRUD education history berbasis modal, validasi server, rendering error, dan pengelolaan data `user_education_history`.
