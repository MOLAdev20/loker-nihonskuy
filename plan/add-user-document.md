# PRD Add User Document Upload Page

## Tujuan
- Membuat fitur upload dokumen untuk user/kandidat.
- Menyediakan halaman khusus agar user dapat melihat, menambah, membuka, dan menghapus dokumen yang sudah diupload.
- Menjaga implementasi tetap mengikuti layout dan arsitektur halaman user existing, terutama pola halaman `Data Pribadi`.
- Menyediakan arahan high level untuk Fullstack Laravel Developer atau AI model yang lebih murah agar pekerjaan tidak melewati scope.

## Latar Belakang
- Dashboard user sudah memiliki area profil dan halaman data pribadi.
- Pada sidebar user sudah ada item `Dokumen`, tetapi belum diarahkan ke halaman dokumen.
- Migration `2026_06_23_021126_create-user-document-table.php` sudah tersedia.
- Model, controller, route, dan view untuk dokumen user belum tersedia.

## Ruang Lingkup
- Membuat model `App\Models\User\UserDocument`.
- Membuat controller `App\Http\Controllers\User\DocumentController`.
- Menambahkan route user untuk halaman dokumen.
- Membuat view `resources/views/user/document.blade.php`.
- Menambahkan mekanisme upload dokumen dengan modal.
- Menambahkan validasi agar satu jenis dokumen hanya boleh diupload satu kali per user.
- Menambahkan fitur membuka atau melihat dokumen yang sudah diupload.
- Menambahkan fitur hapus dokumen dengan konfirmasi user.
- Menghubungkan menu `Dokumen` pada sidebar user ke route dokumen.

## Di Luar Scope
- Jangan mengubah migration yang sudah ada kecuali ada blocker teknis yang benar-benar menghambat implementasi.
- Jangan membuat fitur admin untuk mengelola dokumen user.
- Jangan membuat API baru.
- Jangan menambah fitur edit metadata dokumen.
- Jangan menambah fitur replace langsung; user harus menghapus dokumen lama sebelum upload ulang.
- Jangan menambah jenis dokumen di luar `KTP`, `KK`, dan `Akte Kelahiran`.
- Jangan mengubah flow data pribadi, pendidikan, pekerjaan, interview, atau konfirmasi kecuali hanya untuk menjaga konsistensi navigasi user.

## Prinsip Implementasi
- Ikuti pola MVC, naming, validasi, redirect, flash message, dan layout yang sudah digunakan di area `App\Http\Controllers\User`, `App\Models\User`, dan `resources/views/user`.
- Gunakan `layouts.user-dashboard` untuk halaman dokumen.
- Simpan file pada disk storage yang konsisten dengan upload file user existing.
- Controller bertanggung jawab untuk mengambil dokumen milik user login, validasi upload, penyimpanan file, dan penghapusan file.
- View bertanggung jawab untuk layout, modal upload, daftar dokumen, tombol lihat, tombol hapus, dan feedback error/sukses.
- Semua akses dokumen harus dibatasi hanya untuk pemilik dokumen yang sedang login.

## Arah Arsitektur
### Model
- Buat model `UserDocument` pada namespace `App\Models\User`.
- Model merepresentasikan tabel `user_document`.
- Model memiliki relasi ke `User` melalui `user_id`.
- Model memiliki field yang dapat diisi sesuai migration: `user_id`, `file_type`, dan `file`.
- Jika dibutuhkan, model boleh menyediakan helper sederhana untuk label jenis dokumen dan URL file, selama tetap mengikuti pola model existing.

### Controller
- Buat `DocumentController` sebagai controller khusus halaman dokumen user.
- Controller minimal menangani:
  - Menampilkan halaman dokumen.
  - Menyimpan upload dokumen baru.
  - Menghapus dokumen existing.
- Saat halaman ditampilkan, controller mengambil semua dokumen milik user login dan mengirimkannya ke view.
- Saat upload, controller memvalidasi jenis dokumen, file, dan memastikan jenis dokumen belum pernah diupload oleh user tersebut.
- Saat validasi duplikasi gagal, tampilkan feedback seperti: `Dokumen KTP sudah ada. Hapus terlebih dahulu untuk menggantinya`.
- Saat hapus, controller memastikan dokumen milik user login, menghapus file fisik dari storage, lalu menghapus record database.

### Route
- Tambahkan route dalam middleware `auth` untuk fitur dokumen user.
- Gunakan prefix atau path yang sederhana dan konsisten, misalnya `/document`.
- Route minimal mencakup:
  - `GET` halaman dokumen.
  - `POST` upload dokumen.
  - `DELETE` hapus dokumen.
- Gunakan route name yang konsisten dengan pola user existing, misalnya `user.document`, `user.document.store`, dan `user.document.destroy`.
- Update menu `Dokumen` di sidebar agar menuju route halaman dokumen dan memiliki active state.

### View
- Buat `resources/views/user/document.blade.php`.
- Gunakan layout dashboard user existing.
- Tampilkan heading halaman dan tombol `Tambah Dokumen` di atas card utama.
- Tombol `Tambah Dokumen` membuka modal upload.
- Modal upload berisi:
  - Dropdown jenis dokumen: `KTP`, `KK`, `Akte Kelahiran`.
  - Input file.
  - Tombol submit.
  - Tombol batal/tutup.
- Card utama menampilkan dokumen yang sudah diupload dalam grid 12 kolom.
- Pada desktop, setiap dokumen menggunakan `col-span-3` agar tampil 4 item per baris.
- Pada tablet dan mobile, grid harus responsif agar dokumen tetap mudah dibaca.
- Setiap item dokumen menampilkan jenis dokumen, nama atau ringkasan file, tombol lihat, dan tombol hapus merah dengan ikon X.
- Tombol hapus wajib meminta konfirmasi user sebelum submit delete.

## Mekanisme Upload
- User membuka halaman dokumen.
- User menekan tombol `Tambah Dokumen`.
- Sistem menampilkan modal upload.
- User memilih jenis dokumen dan file.
- User submit form.
- Sistem melakukan validasi server.
- Jika jenis dokumen sudah pernah ada untuk user tersebut, sistem menolak upload dan menampilkan pesan duplikasi.
- Jika validasi berhasil, sistem menyimpan file, membuat record dokumen, dan mengembalikan user ke halaman dokumen dengan feedback sukses.

## Mekanisme Lihat Dokumen
- User dapat menekan dokumen atau tombol `Lihat` pada item dokumen.
- Sistem membuka file dokumen melalui URL storage yang dapat diakses.
- Mekanisme dapat menggunakan tab baru atau link langsung selama user dapat melihat lampiran dengan jelas.
- Pastikan URL file tidak digunakan untuk membuka dokumen milik user lain melalui controller atau ownership check bila implementasi memakai route proxy.

## Mekanisme Hapus Dokumen
- User menekan tombol hapus merah dengan ikon X pada item dokumen.
- UI menampilkan konfirmasi sebelum delete dikirim.
- Jika user batal, tidak ada perubahan.
- Jika user konfirmasi, sistem menghapus file dari storage dan menghapus record dari database.
- Setelah berhasil, user kembali ke halaman dokumen dengan feedback sukses.

## Validasi
- `file_type` wajib diisi dan hanya boleh salah satu dari `KTP`, `KK`, `Akte Kelahiran`.
- `file` wajib diisi saat upload.
- Batasi tipe file ke format dokumen/gambar yang wajar untuk lampiran kandidat, seperti PDF, JPG, JPEG, dan PNG.
- Batasi ukuran file dengan angka yang wajar dan konsisten dengan upload existing di aplikasi.
- Validasi duplikasi wajib berdasarkan kombinasi `user_id` dan `file_type`.
- Pesan duplikasi harus mengikuti format: `Dokumen {jenis} sudah ada. Hapus terlebih dahulu untuk menggantinya`.

## Rencana UI/UX
- Halaman harus terasa satu keluarga dengan halaman `Data Pribadi` dan dashboard user existing.
- Card utama menjadi area daftar lampiran.
- Empty state ditampilkan jika user belum upload dokumen apa pun.
- Tombol `Tambah Dokumen` harus terlihat jelas di atas card utama.
- Modal harus sederhana dan fokus pada dua input utama: jenis dokumen dan file.
- Item dokumen harus mudah discan, dengan jenis dokumen sebagai informasi utama.
- Tombol hapus harus memakai warna merah dan ikon X agar jelas sebagai aksi destruktif.
- Jangan membuat desain baru yang menyimpang besar dari dashboard user existing.

## Rencana Alur Data
### Tampil Halaman
- User membuka menu `Dokumen`.
- Controller mengambil daftar dokumen milik user login.
- View menampilkan dokumen dalam grid atau empty state bila belum ada data.

### Upload Dokumen
- User memilih jenis dokumen dan file dari modal.
- Controller memvalidasi input dan duplikasi jenis dokumen.
- File disimpan ke storage.
- Record baru dibuat di tabel `user_document`.
- User diarahkan kembali ke halaman dokumen dengan feedback sukses.

### Hapus Dokumen
- User mengonfirmasi hapus dokumen.
- Controller memastikan dokumen milik user login.
- File dihapus dari storage bila masih tersedia.
- Record database dihapus.
- User diarahkan kembali ke halaman dokumen dengan feedback sukses.

## Kriteria Hasil
- Model `UserDocument` tersedia dan terhubung ke tabel `user_document`.
- Controller `DocumentController` tersedia dan menangani halaman, upload, dan delete.
- Route dokumen tersedia dalam area user yang membutuhkan autentikasi.
- View `user/document.blade.php` tersedia dan memakai layout dashboard user.
- Menu `Dokumen` pada sidebar mengarah ke halaman dokumen.
- User dapat upload dokumen jenis `KTP`, `KK`, dan `Akte Kelahiran`.
- User tidak dapat upload dua dokumen dengan jenis yang sama.
- Pesan duplikasi tampil sesuai ketentuan.
- User dapat melihat dokumen yang sudah diupload.
- User dapat menghapus dokumen setelah konfirmasi.
- File fisik ikut dihapus saat record dokumen dihapus.
- Halaman tetap responsif dan konsisten dengan UI user existing.

## Catatan Untuk Implementor
- Kerjakan hanya scope fitur dokumen user.
- Ikuti pola code existing terlebih dahulu sebelum membuat helper atau abstraction baru.
- Jangan membuat perubahan besar pada dashboard, wizard, atau halaman profil.
- Jangan mengubah daftar jenis dokumen tanpa arahan baru.
- Pastikan semua query dokumen selalu dibatasi ke `auth()->id()`.
- Jika menemukan perbedaan naming route atau style controller di repo, ikuti pola terbaru yang sudah digunakan pada halaman user.
