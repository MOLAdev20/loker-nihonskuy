# PRD Add Profile Text Fields

## Tujuan
- Menambahkan input profil tambahan agar kandidat dapat menjelaskan ringkasan diri, alasan pindah kerja, dan informasi tambahan.
- Menyediakan field yang sama pada form profil kandidat dan form profil user di admin.
- Menjaga implementasi tetap terbatas pada field yang sudah disiapkan di migration existing.

## Ruang Lingkup
- Migration penambahan kolom sudah tersedia di `database/migrations/2026_06_02_074831_add_2_columns_in_table_user_profile.php`.
- Kolom yang perlu digunakan pada tabel `user_profile`:
  - `summary`
  - `reason_for_leaving`
  - `additional_info`
- Penambahan form input pada:
  - `resources/views/user/profile-form.blade.php`
  - `resources/views/admin/user/profile-form.blade.php`
- Penyesuaian alur penyimpanan dan pengisian ulang data profil bila dibutuhkan oleh form existing.

## Batasan Scope
- Jangan membuat migration baru karena migration sudah tersedia.
- Jangan menambah kolom lain di tabel `user_profile`.
- Jangan mengubah layout besar halaman profil.
- Jangan mengubah flow profil lain di luar kebutuhan membaca, menampilkan, dan menyimpan tiga field ini.
- Jangan menambahkan validasi kompleks di luar kebutuhan textarea standar.
- Jangan mengubah label atau posisi field selain yang disebutkan di dokumen ini.

## Prinsip Implementasi
- Ikuti pola field dan naming yang sudah digunakan pada form profil kandidat dan form profil admin.
- Gunakan `textarea` untuk semua field baru.
- Pastikan nilai lama tetap tampil saat user membuka form edit.
- Pastikan nilai input tetap tampil kembali saat validasi form gagal.
- Perlakukan perubahan ini sebagai penambahan field profil biasa, bukan fitur baru dengan flow terpisah.
- Jaga implementasi tetap sederhana agar mudah dikerjakan oleh Junior FrontEnd Engineer atau AI model murah.

## Field yang Ditambahkan

| Kolom | Label | Tipe Input | Posisi |
| --- | --- | --- | --- |
| `summary` | Jelaskan ringkasan mengenai dirimu | Textarea | Di atas field `Detail pengalaman Magang/skill` |
| `reason_for_leaving` | Alasan pindah kerja | Textarea | Di bawah field `Detail pengalaman Magang/skill` |
| `additional_info` | Informasi tambahan | Textarea | Di bawah field `Alasan pindah kerja` |

## Arah Perubahan

### 1. Database
- Gunakan migration existing yang sudah menambahkan kolom `summary`, `reason_for_leaving`, dan `additional_info`.
- Pastikan implementasi tidak membuat migration tambahan untuk requirement ini.
- Jika migration existing perlu dicek, fokus hanya pada kesesuaian nama kolom dengan form dan controller.

### 2. Form Profil Kandidat
- Tambahkan field `summary` pada `resources/views/user/profile-form.blade.php`.
- Letakkan field `summary` di atas field `Detail pengalaman Magang/skill`.
- Tambahkan field `reason_for_leaving` di bawah field `Detail pengalaman Magang/skill`.
- Tambahkan field `additional_info` di bawah field `Alasan pindah kerja`.
- Pastikan semua field menggunakan `textarea` dan mengikuti style form existing.

### 3. Form Profil Admin
- Tambahkan field yang sama pada `resources/views/admin/user/profile-form.blade.php`.
- Posisi field harus sama dengan form profil kandidat.
- Label, tipe input, dan perilaku input harus konsisten antara form user dan admin.

### 4. Penyimpanan Data
- Pastikan data dari tiga field baru ikut tersimpan ke tabel `user_profile`.
- Pastikan form edit dapat membaca data existing dari kolom `summary`, `reason_for_leaving`, dan `additional_info`.
- Pastikan alur submit user kandidat dan submit admin sama-sama mendukung field baru.

## Alur Pengguna
- Kandidat membuka form profil.
- Kandidat dapat mengisi ringkasan diri, detail pengalaman atau skill, alasan pindah kerja, dan informasi tambahan.
- Kandidat menyimpan profil.
- Admin membuka form profil user.
- Admin dapat melihat dan mengubah field tambahan yang sama.
- Data tersimpan dan tampil kembali saat form dibuka ulang.

## File yang Berpotensi Disesuaikan
- `resources/views/user/profile-form.blade.php`
- `resources/views/admin/user/profile-form.blade.php`
- Controller penyimpanan profil kandidat jika belum menerima field baru.
- Controller penyimpanan profil admin jika belum menerima field baru.
- Model profil user jika perlu menambahkan field ke daftar mass assignment.

## Tahapan Implementasi

### Fase 1 - Review Existing
- Review migration existing untuk memastikan nama kolom sudah sesuai.
- Review field `Detail pengalaman Magang/skill` sebagai titik penempatan field baru.
- Review alur submit profil user dan admin yang saat ini digunakan.

### Fase 2 - Penyesuaian Form
- Tambahkan field `summary`, `reason_for_leaving`, dan `additional_info` pada form kandidat.
- Tambahkan field yang sama pada form admin.
- Pastikan urutan field sesuai requirement.

### Fase 3 - Penyesuaian Data Flow
- Pastikan request membaca tiga field baru.
- Pastikan data tersimpan ke profil user.
- Pastikan data existing tampil kembali di form edit.
- Pastikan nilai input tetap aman saat validasi gagal.

### Fase 4 - Validasi Akhir
- Cek form kandidat bisa menampilkan dan menyimpan tiga field baru.
- Cek form admin bisa menampilkan dan menyimpan tiga field baru.
- Cek urutan field sesuai requirement.
- Cek tidak ada perubahan perilaku pada field profil lain.

## Kriteria Hasil
- Field `Jelaskan ringkasan mengenai dirimu` tampil sebagai textarea di atas field `Detail pengalaman Magang/skill`.
- Field `Alasan pindah kerja` tampil sebagai textarea di bawah field `Detail pengalaman Magang/skill`.
- Field `Informasi tambahan` tampil sebagai textarea di bawah field `Alasan pindah kerja`.
- Ketiga field tersedia di form profil kandidat.
- Ketiga field tersedia di form profil admin.
- Data `summary`, `reason_for_leaving`, dan `additional_info` dapat tersimpan dan tampil kembali saat form dibuka ulang.
- Implementasi tidak melebar ke perubahan lain di luar tiga field profil ini.

## Catatan Implementasi
- Kerjakan sesuai notes dan jangan melewati scope instruksi.
- Jangan membuat redesign halaman profil.
- Jangan menambah field, section, atau validasi baru yang tidak diminta.
- Gunakan pola komponen, class, dan struktur form existing agar hasil konsisten.
- Jika ditemukan perbedaan naming antara input form dan kolom database, gunakan mapping yang jelas tanpa mengubah nama kolom database.
