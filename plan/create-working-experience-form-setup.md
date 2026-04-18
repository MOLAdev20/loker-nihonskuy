# Plan Create Working Experience Form

## Tujuan
- Menyusun rencana pembuatan halaman riwayat pengalaman kerja user pada route `/working-experience` dengan pendekatan arsitektur MVC.
- Menyiapkan alur CRUD riwayat pengalaman kerja agar 1 user dapat menambah, melihat, mengubah, dan menghapus lebih dari satu data pengalaman kerja mereka.
- Menjaga agar implementasi tetap high level, terstruktur, dan cukup jelas untuk dikerjakan oleh junior fullstack programmer atau AI model dengan kemampuan terbatas.

## Ruang Lingkup
- Pembuatan halaman daftar riwayat pengalaman kerja user.
- Pembuatan form create dan edit riwayat pengalaman kerja berbasis modal.
- Penyesuaian route untuk tampil data, simpan data baru, ubah data, dan hapus data.
- Penyusunan alur MVC antara route, controller, request validation, model, dan view.
- Validasi input di sisi server beserta penampilan error pada UI.
- Penyimpanan, perubahan, dan penghapusan data pada tabel `user_working_experience`.

## Prinsip Implementasi
- Gunakan pendekatan MVC secara tegas agar tanggung jawab route, controller, request validation, model, dan view tetap terpisah.
- Tempatkan process logic working experience pada `User/WorkExperienceController.php`.
- Gunakan model terpisah `User/WorkExperience.php` untuk representasi tabel `user_working_experience`.
- Gunakan naming `camelCase` untuk variabel, function, method, dan identifier baru.
- Pastikan halaman mengikuti layout dasar area content yang sudah digunakan pada halaman profile dashboard.
- Fokus pada pengalaman input yang rapi, ringan, responsif, dan mudah dipahami user.
- Hindari logika validasi langsung di Blade; validasi harus berada di sisi server.
- Jangan menambah fitur di luar scope CRUD working experience pada `user_working_experience`.

## Arah Arsitektur MVC
### 1. Route
- Sediakan route `GET /working-experience` untuk menampilkan halaman daftar riwayat pengalaman kerja.
- Sediakan route `POST /working-experience` untuk menyimpan data pengalaman kerja baru.
- Sediakan route update untuk mengubah satu data pengalaman kerja berdasarkan `id`.
- Sediakan route delete untuk menghapus satu data pengalaman kerja berdasarkan `id`.
- Pastikan seluruh route berada dalam area user yang membutuhkan autentikasi.

### 2. Controller
- Gunakan `User/WorkExperienceController` sebagai titik orkestrasi seluruh flow working experience.
- Controller bertugas menampilkan daftar data milik user, menerima request create dan update yang sudah tervalidasi, lalu memproses delete per data.
- Controller harus memastikan setiap aksi edit atau hapus hanya bisa dilakukan pada data yang dimiliki user yang sedang login.
- Controller hanya mengelola flow aplikasi, bukan memuat detail validasi panjang atau logika tampilan.

### 3. Request Validation
- Gunakan request object khusus agar aturan validasi terpisah dari controller.
- Seluruh aturan validasi harus mengikuti requirement field yang sudah ditentukan.
- Pesan error harus formal, singkat, berbahasa Indonesia, dan relevan dengan jenis kesalahan input.
- Validasi create dan update harus konsisten agar perilaku form tetap seragam.

### 4. Model
- Gunakan model `User/WorkExperience` yang merepresentasikan tabel `user_working_experience`.
- Pastikan relasi data ke user terhubung dengan bersih melalui `user_id`.
- Pastikan query data selalu dibatasi pada milik user yang sedang login agar aman untuk aksi edit dan hapus.

### 5. View
- Gunakan view `user/working-experience-form.blade.php`.
- Layout dasar mengikuti pola section content dari `profile.blade.php` agar tampilan tetap konsisten dengan dashboard user.
- Blade difokuskan untuk rendering daftar data, tombol aksi, modal create/edit, old input, state error, dan feedback visual validasi.

## Struktur Halaman
### 1. Layout Konten
- Tempatkan halaman di dalam card atau panel utama yang konsisten dengan gaya dashboard user.
- Sediakan judul halaman, subjudul singkat, tombol tambah riwayat pekerjaan, dan area daftar data.
- Pertahankan tampilan modern, minimalist, soft, dan tetap dekat dengan pola input Bootstrap yang bersih.

### 2. Komponen Modal
- Gunakan `components/modal.blade.php` sebagai dasar modal create dan edit.
- Saat tombol tambah diklik, modal muncul berisi form input pengalaman kerja baru.
- Saat tombol edit diklik, modal muncul berisi form dengan data existing dari row yang dipilih.
- Setelah simpan berhasil, modal tertutup otomatis dan daftar data pada halaman utama tampil dalam kondisi terbaru.

### 3. Tampilan Daftar Data
- Tampilkan data pengalaman kerja yang sudah diinput dalam layout yang paling mudah dipindai dan diubah.
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
| `fieldOfWork` | Text | min 3, max 255, required | Bidang Pekerjaan |
| `location` | Text | required | Lokasi Kerja/Perusahaan |
| `dateOfJoin` | Date | required | Tanggal Bergabung |
| `dateOfResign` | Date | Boleh tidak diisi | Tanggal Resign/Berhenti |
| `employmentStatus` | Radio | required, `permanent` / `contract` / `fullTime` / `partTime` / `freelance` | Status Kepegawaian |
| `visaType` | Select | Boleh tidak dipilih | Jenis Visa |

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
- User mengakses `GET /working-experience`.
- Sistem menampilkan halaman daftar riwayat pengalaman kerja milik user di area content dashboard.

### 2. Tambah Data
- User menekan tombol tambah riwayat pekerjaan.
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
- Tabel `user_working_experience` harus mendukung penyimpanan lebih dari satu row untuk setiap user.
- Komponen `components/modal.blade.php` harus dapat dipakai ulang untuk skenario create dan edit.
- Sebelum implementasi coding dimulai, pembagian tanggung jawab antara `WorkExperienceController`, request validation, model, dan view harus disepakati agar flow CRUD tetap rapi.

## Tahapan Implementasi
### Fase 1 - Penyelarasan Kontrak Data
- Samakan daftar field form dengan field final pada tabel `user_working_experience`.
- Pastikan naming request, naming model, dan naming kolom database konsisten.
- Tegaskan rule bisnis untuk kondisi `visaType` agar tidak memunculkan interpretasi ganda saat implementasi.

### Fase 2 - Fondasi MVC
- Siapkan `WorkExperienceController`, route CRUD, request validation, dan model `WorkExperience` yang terhubung ke `user_working_experience`.
- Pastikan seluruh process logic working experience tidak dicampur ke controller profile atau controller lain.

### Fase 3 - Pembuatan Halaman Daftar
- Bangun halaman `user/working-experience-form.blade.php` dengan struktur content dashboard.
- Tampilkan daftar data pengalaman kerja user dalam layout utama yang mudah dipindai dan mudah dioperasikan.

### Fase 4 - Modal Create dan Edit
- Hubungkan tombol tambah dan edit ke komponen modal yang reusable.
- Pastikan form modal mendukung old input, error state, dan prefilled value untuk edit.

### Fase 5 - Finalisasi CRUD
- Pastikan create, update, dan delete berjalan per row data milik user.
- Rapikan feedback sukses, konsistensi naming, dan kualitas pengalaman user.

## Kriteria Hasil
- Route `GET /working-experience` menampilkan daftar riwayat pengalaman kerja user.
- User dapat menambahkan lebih dari satu data riwayat pengalaman kerja.
- User dapat mengedit satu data pengalaman kerja berdasarkan `id`.
- User dapat menghapus satu data pengalaman kerja berdasarkan `id` dengan konfirmasi.
- Form create dan edit tampil melalui `components/modal.blade.php`.
- Setelah simpan berhasil, modal tertutup dan daftar data tampil dalam kondisi terbaru.
- View `user/working-experience-form.blade.php` menggunakan layout content yang konsisten dengan halaman profile.
- Validasi berjalan di sisi server dan ditampilkan tepat di bawah field terkait.
- Pesan error menggunakan bahasa Indonesia formal singkat.
- Field error memiliki border merah saat validasi gagal.
- Naming baru mengikuti pola `camelCase`.

## Catatan Implementasi
- Jangan menaruh logika bisnis atau validasi kompleks di Blade.
- Jangan memperluas scope ke fitur pencarian, sorting lanjutan, pagination, API, atau workflow lain di luar instruksi ini.
- Fokus pada CRUD working experience berbasis modal, validasi server, rendering error, dan pengelolaan data `user_working_experience`.
