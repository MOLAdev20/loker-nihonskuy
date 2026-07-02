# PRD Add User Certificate Upload Page

## Tujuan
- Membuat fitur upload sertifikat untuk user/kandidat.
- Menyediakan halaman khusus agar user dapat melihat, menambah, membuka, dan menghapus sertifikat yang sudah diupload.
- Menjaga implementasi tetap mengikuti layout dan arsitektur fitur dokumen user yang sudah ada.
- Menyediakan arahan high level untuk Fullstack Laravel Developer atau AI model yang lebih murah agar pekerjaan tidak melewati scope.

## Latar Belakang
- Fitur dokumen user sudah menjadi acuan layout dan pola implementasi untuk upload lampiran.
- Sertifikat kandidat perlu dikelola sebagai lampiran terpisah dari dokumen identitas.
- Migration `2026_06_25_084137_create_table_certificate.php` sudah tersedia.
- Tabel yang digunakan adalah `user_certificate` dengan kolom utama `user_id`, `certificate_type`, dan `file`.
- Model, controller, route, dan view untuk sertifikat user belum tersedia.

## Ruang Lingkup
- Membuat model `App\Models\User\UserCertificate`.
- Membuat controller `App\Http\Controllers\User\CertificateController`.
- Menambahkan route user untuk halaman sertifikat.
- Membuat view `resources/views/user/certificate.blade.php`.
- Menambahkan mekanisme upload sertifikat dengan modal.
- Menambahkan validasi agar satu jenis sertifikat hanya boleh diupload satu kali per user.
- Menambahkan fitur membuka atau melihat sertifikat yang sudah diupload.
- Menambahkan fitur hapus sertifikat dengan konfirmasi user.
- Menghubungkan menu atau navigasi user ke halaman sertifikat jika sudah tersedia di sidebar atau area dashboard.

## Di Luar Scope
- Jangan mengubah migration yang sudah tersedia kecuali ada blocker teknis yang benar-benar menghambat implementasi.
- Jangan membuat fitur admin untuk mengelola sertifikat user.
- Jangan membuat API baru.
- Jangan menambah fitur edit metadata sertifikat.
- Jangan menambah fitur replace langsung; user harus menghapus sertifikat lama sebelum upload ulang.
- Jangan menambah jenis sertifikat di luar daftar yang ditentukan.
- Jangan menggabungkan fitur sertifikat ke fitur dokumen.
- Jangan mengubah flow profil, pendidikan, pengalaman kerja, interview, dokumen, atau konfirmasi kecuali hanya untuk menjaga konsistensi navigasi user.

## Prinsip Implementasi
- Ikuti pola MVC, naming, validasi, redirect, flash message, dan layout yang sudah digunakan pada fitur dokumen user.
- Gunakan `layouts.user-dashboard` untuk halaman sertifikat.
- Simpan file pada disk storage yang konsisten dengan upload dokumen user existing.
- Controller bertanggung jawab mengambil sertifikat milik user login, validasi upload, penyimpanan file, dan penghapusan file.
- View bertanggung jawab untuk layout, modal upload, daftar sertifikat, tombol lihat, tombol hapus, dan feedback error/sukses.
- Semua akses sertifikat harus dibatasi hanya untuk pemilik sertifikat yang sedang login.

## Arah Arsitektur

### Model
- Buat model `UserCertificate` pada namespace `App\Models\User`.
- Model merepresentasikan tabel `user_certificate`.
- Model memiliki relasi ke `User` melalui `user_id`.
- Model memiliki field yang dapat diisi sesuai migration: `user_id`, `certificate_type`, dan `file`.
- Jika dibutuhkan, model boleh menyediakan helper sederhana untuk daftar jenis sertifikat, label jenis sertifikat, dan URL file, selama tetap mengikuti pola model dokumen existing.

### Controller
- Buat `CertificateController` sebagai controller khusus halaman sertifikat user.
- Controller minimal menangani:
  - Menampilkan halaman sertifikat.
  - Menyimpan upload sertifikat baru.
  - Membuka atau menampilkan file sertifikat.
  - Menghapus sertifikat existing.
- Saat halaman ditampilkan, controller mengambil semua sertifikat milik user login dan mengirimkannya ke view.
- Saat upload, controller memvalidasi jenis sertifikat, file, dan memastikan jenis sertifikat belum pernah diupload oleh user tersebut.
- Saat validasi duplikasi gagal, tampilkan feedback seperti: `sertifikat N5 sudah ada. Hapus terlebih dahulu untuk menggantinya`.
- Saat hapus, controller memastikan sertifikat milik user login, menghapus file fisik dari storage, lalu menghapus record database.

### Route
- Tambahkan route dalam middleware `auth` untuk fitur sertifikat user.
- Gunakan path yang sederhana dan konsisten, misalnya `/certificate`.
- Route minimal mencakup:
  - `GET` halaman sertifikat.
  - `POST` upload sertifikat.
  - `GET` lihat sertifikat.
  - `DELETE` hapus sertifikat.
- Gunakan route name yang konsisten dengan pola user existing, misalnya `user.certificate`, `user.certificate.store`, `user.certificate.show`, dan `user.certificate.destroy`.
- Jika sidebar user memiliki menu sertifikat, arahkan menu tersebut ke route halaman sertifikat dan berikan active state.

### View
- Buat `resources/views/user/certificate.blade.php`.
- Gunakan layout dashboard user existing.
- Tampilkan heading halaman dan tombol `Tambah Sertifikat` di atas card utama.
- Tombol `Tambah Sertifikat` membuka modal upload.
- Modal upload berisi:
  - Dropdown jenis sertifikat.
  - Input file.
  - Tombol submit.
  - Tombol batal atau tutup.
- Card utama menampilkan sertifikat yang sudah diupload dalam grid 12 kolom.
- Pada desktop, setiap sertifikat menggunakan `col-span-3` agar tampil 4 item per baris.
- Pada tablet dan mobile, grid harus responsif agar sertifikat tetap mudah dibaca.
- Setiap item sertifikat menampilkan jenis sertifikat, nama atau ringkasan file, tombol lihat, dan tombol hapus merah dengan ikon X.
- Tombol hapus wajib meminta konfirmasi user sebelum submit delete.

## Daftar Jenis Sertifikat
- `N5`
- `N4`
- `N3`
- `N2`
- `N1`
- `SSW Pengolahan Makanan`
- `SSW Pertanian`
- `SSW Kaigo/Perawat Lansia`

## Mekanisme Upload
- User membuka halaman sertifikat.
- User menekan tombol `Tambah Sertifikat`.
- Sistem menampilkan modal upload.
- User memilih jenis sertifikat dan file.
- User submit form.
- Sistem melakukan validasi server.
- Jika jenis sertifikat sudah pernah ada untuk user tersebut, sistem menolak upload dan menampilkan pesan duplikasi.
- Jika validasi berhasil, sistem menyimpan file, membuat record sertifikat, dan mengembalikan user ke halaman sertifikat dengan feedback sukses.

## Mekanisme Lihat Sertifikat
- User dapat menekan sertifikat atau tombol `Lihat` pada item sertifikat.
- Sistem membuka file sertifikat melalui URL storage atau route proxy yang aman.
- Mekanisme dapat menggunakan tab baru atau link langsung selama user dapat melihat lampiran dengan jelas.
- Pastikan file sertifikat milik user lain tidak dapat diakses oleh user yang sedang login.

## Mekanisme Hapus Sertifikat
- User menekan tombol hapus merah dengan ikon X pada item sertifikat.
- UI menampilkan konfirmasi sebelum delete dikirim.
- Jika user batal, tidak ada perubahan.
- Jika user konfirmasi, sistem menghapus file dari storage dan menghapus record dari database.
- Setelah berhasil, user kembali ke halaman sertifikat dengan feedback sukses.

## Validasi
- `certificate_type` wajib diisi dan hanya boleh salah satu dari daftar jenis sertifikat yang ditentukan.
- `file` wajib diisi saat upload.
- Batasi tipe file ke format dokumen/gambar yang wajar untuk lampiran sertifikat, seperti PDF, JPG, JPEG, dan PNG.
- Batasi ukuran file dengan angka yang wajar dan konsisten dengan upload dokumen existing.
- Validasi duplikasi wajib berdasarkan kombinasi `user_id` dan `certificate_type`.
- Pesan duplikasi harus mengikuti format: `sertifikat {jenis} sudah ada. Hapus terlebih dahulu untuk menggantinya`.

## Rencana UI/UX
- Halaman harus terasa satu keluarga dengan halaman dokumen user existing.
- Card utama menjadi area daftar lampiran sertifikat.
- Empty state ditampilkan jika user belum upload sertifikat apa pun.
- Tombol `Tambah Sertifikat` harus terlihat jelas di atas card utama.
- Modal harus sederhana dan fokus pada dua input utama: jenis sertifikat dan file.
- Item sertifikat harus mudah discan, dengan jenis sertifikat sebagai informasi utama.
- Tombol hapus harus memakai warna merah dan ikon X agar jelas sebagai aksi destruktif.
- Jangan membuat desain baru yang menyimpang besar dari dashboard user existing.

## Rencana Alur Data

### Tampil Halaman
- User membuka menu `Sertifikat`.
- Controller mengambil daftar sertifikat milik user login.
- View menampilkan sertifikat dalam grid atau empty state bila belum ada data.

### Upload Sertifikat
- User memilih jenis sertifikat dan file dari modal.
- Controller memvalidasi input dan duplikasi jenis sertifikat.
- File disimpan ke storage.
- Record baru dibuat di tabel `user_certificate`.
- User diarahkan kembali ke halaman sertifikat dengan feedback sukses.

### Lihat Sertifikat
- User menekan item sertifikat atau tombol `Lihat`.
- Controller memastikan sertifikat milik user login jika memakai route proxy.
- Sistem menampilkan atau membuka file sertifikat.

### Hapus Sertifikat
- User mengonfirmasi hapus sertifikat.
- Controller memastikan sertifikat milik user login.
- File dihapus dari storage bila masih tersedia.
- Record database dihapus.
- User diarahkan kembali ke halaman sertifikat dengan feedback sukses.

## Kriteria Hasil
- Model `UserCertificate` tersedia dan terhubung ke tabel `user_certificate`.
- Controller `CertificateController` tersedia dan menangani halaman, upload, lihat, dan delete.
- Route sertifikat tersedia dalam area user yang membutuhkan autentikasi.
- View `user/certificate.blade.php` tersedia dan memakai layout dashboard user.
- User dapat upload sertifikat sesuai daftar jenis yang ditentukan.
- User tidak dapat upload dua sertifikat dengan jenis yang sama.
- Pesan duplikasi tampil sesuai ketentuan.
- User dapat melihat sertifikat yang sudah diupload.
- User dapat menghapus sertifikat setelah konfirmasi.
- File fisik ikut dihapus saat record sertifikat dihapus.
- Halaman tetap responsif dan konsisten dengan UI dokumen user existing.

## Catatan Untuk Implementor
- Kerjakan hanya scope fitur sertifikat user.
- Ikuti pola code fitur dokumen user terlebih dahulu sebelum membuat helper atau abstraction baru.
- Jangan membuat perubahan besar pada dashboard, wizard, halaman profil, atau fitur dokumen.
- Jangan mengubah daftar jenis sertifikat tanpa arahan baru.
- Pastikan semua query sertifikat selalu dibatasi ke `auth()->id()`.
- Jika menemukan perbedaan naming route atau style controller di repo, ikuti pola terbaru yang sudah digunakan pada halaman user.
