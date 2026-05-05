# PRD Setup Admin User Profile Layout

## Tujuan
- Mengubah susunan layout halaman detail user admin pada `resources/views/admin/user/detail.blade.php`.
- Menampilkan foto profil, detail profile, riwayat pendidikan, dan pengalaman kerja dalam layout grid 3x6 sesuai instruksi.
- Menjaga look dan nuansa halaman tetap seperti kondisi saat ini.

## Latar Belakang
Halaman detail user admin saat ini sudah menampilkan data utama user, profile detail, education history, dan work experience dalam beberapa section card vertikal. Perubahan yang dibutuhkan hanya pada susunan layout agar foto profile ditempatkan di area kiri, sedangkan detail profile, riwayat pendidikan, dan pengalaman kerja ditumpuk di area kanan.

## Scope
- Mengubah layout di `resources/views/admin/user/detail.blade.php` saja.
- Mempertahankan komponen visual yang sudah ada, termasuk class Tailwind untuk card, border, warna, typography, shadow, spacing dasar, tombol `Ubah Data`, dan placeholder kosong.
- Menggunakan data yang sudah tersedia dari halaman saat ini:
  - `$user`
  - `$profile`
  - `$educationHistories`
  - `$workExperiences`
  - `$profilePictureUrl`
  - `$formatDate`
- Menampilkan detail profile berdasarkan field dari table `user_profile`.
- Menampilkan riwayat pendidikan dalam card berisi table.
- Menampilkan pengalaman kerja dalam card berisi table.

## Out of Scope
- Tidak menambah, mengubah, atau menghapus route.
- Tidak mengubah controller, model, migration, seeder, policy, middleware, atau query data.
- Tidak mengubah business logic, validasi, relasi Eloquent, atau format penyimpanan data.
- Tidak mengubah warna, font, tone visual, desain tombol, icon, atau nuansa dashboard admin.
- Tidak menambah fitur create, edit, delete, modal, search, filter, pagination, export, atau upload.
- Tidak mengubah navigasi halaman admin selain posisi layout konten detail user.

## Referensi File
- Halaman target: `resources/views/admin/user/detail.blade.php`
- Referensi field profile: `database/migrations/2026_04_16_000001_create_user_profile_table.php`
- Referensi field pendidikan: `database/migrations/2026_04_16_194037_create_table_education_history.php`
- Referensi field pengalaman kerja: `database/migrations/2026_04_16_211341_create_table_working_experience.php`
- Referensi tambahan company name: `database/migrations/2026_04_16_230734_add_company_name_in_table_user_working_experience.php`

## Layout Target
Gunakan layout grid 3x6 sebagai susunan utama konten setelah header/breadcrumb.

### Struktur Grid
- Grid utama menggunakan 6 kolom pada ukuran desktop.
- Area kiri memakai kolom 1 sampai 2.
- Area kanan memakai kolom 3 sampai 6.
- Pada mobile, layout harus tetap stack satu kolom agar responsif.

### Pembagian Area
- Grid 1 sampai 2:
  - Card foto profile.
  - Menggunakan logic gambar yang sudah ada dari `$profilePictureUrl`.
  - Jika tidak ada foto, tetap tampilkan placeholder `No Profile Picture`.
- Grid 3 sampai 6:
  - Stack 1: card profile detail.
  - Stack 2: card berisi table riwayat pendidikan.
  - Stack 3: card berisi table pengalaman kerja.

## Rencana Perubahan View

### 1. Header halaman
- Pertahankan breadcrumb, judul `Detail User`, deskripsi, dan tombol `Kembali ke daftar user` seperti kondisi saat ini.
- Tidak ada perubahan konten atau style pada area header.

### 2. Grid wrapper utama
- Ganti wrapper section vertikal utama menjadi grid responsif.
- Rekomendasi susunan class mengikuti style Tailwind yang sudah digunakan:
  - mobile: `grid-cols-1`
  - desktop: `lg:grid-cols-6`
  - gap tetap mengikuti spacing saat ini, misalnya `gap-5`
- Area foto menggunakan span 2 kolom pada desktop.
- Area konten kanan menggunakan span 4 kolom pada desktop dan `space-y-5` untuk stack card.

### 3. Card foto profile
- Pisahkan foto profile dari section `Primary Info` saat ini menjadi card tersendiri di area grid kiri.
- Gunakan look existing:
  - `rounded-2xl`
  - `border border-slate-200`
  - `bg-white`
  - `p-5`
  - `shadow-sm`
- Pertahankan tampilan gambar existing:
  - image `object-cover`
  - placeholder `No Profile Picture` jika `$profilePictureUrl` kosong
- Informasi ringkas seperti nama/email/status tidak perlu dipindahkan ke card foto kecuali sudah diperlukan untuk menjaga data penting tetap terbaca. Prioritas scope adalah foto profile di grid 1 sampai 2.

### 4. Card profile detail
- Gunakan section `Profile Detail` yang sudah ada sebagai stack pertama area kanan.
- Pertahankan tombol `Ubah Data` pada header card profile detail.
- Isi card harus mengacu pada table `user_profile`, yaitu field:
  - `profile_picture`
  - `full_name`
  - `furigana_name`
  - `birth_date`
  - `gender`
  - `height`
  - `weight`
  - `marital_status`
  - `nationality`
  - `place_of_origin`
  - `current_address`
  - `religion`
  - `is_wearing_hijab`
  - `prayer_requirement`
  - `pork_tolerance`
  - `alcohol_tolerance`
  - `entry_date`
  - `visa_expiry_date`
  - `current_visa_type`
  - `jlpt_level`
  - `has_driver_license`
  - `work_start_date`
  - `technical_experience`
- Field `profile_picture` cukup direpresentasikan oleh card foto profile di area kiri, sehingga tidak perlu dibuat ulang sebagai item teks di card kanan.
- Jika `$profile` kosong, pertahankan placeholder kosong seperti kondisi saat ini.

### 5. Card table riwayat pendidikan
- Ubah tampilan riwayat pendidikan dari list/article menjadi table di dalam card.
- Card tetap memakai heading `Education History` dan tombol `Ubah Data` yang sudah ada.
- Kolom table yang ditampilkan:
  - Education
  - Institution
  - Location
  - Entry
  - Graduation
  - Dropped Out
  - Status
- Gunakan `$formatDate` untuk field tanggal.
- Jika `$educationHistories` kosong, pertahankan placeholder `No data provided.`.
- Table harus tetap responsif dengan wrapper overflow horizontal bila lebar layar terbatas.

### 6. Card table pengalaman kerja
- Ubah tampilan pengalaman kerja dari list/article menjadi table di dalam card.
- Card tetap memakai heading `Work Experience` dan tombol `Ubah Data` yang sudah ada.
- Kolom table yang ditampilkan:
  - Field of Work
  - Company Name
  - Location
  - Date of Join
  - Date of Resign
  - Employment Status
  - Visa Type
- Gunakan `$formatDate` untuk field tanggal.
- Jika `$workExperiences` kosong, pertahankan placeholder `No data provided.`.
- Table harus tetap responsif dengan wrapper overflow horizontal bila lebar layar terbatas.

## Prinsip UI
- Pertahankan class warna existing seperti `text-slate-*`, `border-slate-*`, `bg-white`, dan `bg-slate-50`.
- Pertahankan radius, border, shadow, dan spacing visual yang sudah ada.
- Hindari memperkenalkan tema baru, variasi warna baru, atau gaya komponen baru.
- Perubahan hanya mengatur ulang posisi data dan mengubah list pendidikan/pengalaman kerja menjadi table sesuai instruksi.

## Responsivitas
- Mobile: semua card stack vertikal satu kolom.
- Tablet/desktop: grid aktif dengan foto profile di kiri dan stack data di kanan.
- Table pendidikan dan pengalaman kerja harus dibungkus container horizontal scroll agar tidak merusak layout mobile.

## Acceptance Criteria
- Halaman `resources/views/admin/user/detail.blade.php` memakai layout grid 3x6 pada desktop.
- Foto profile berada pada area grid 1 sampai 2.
- Area grid 3 sampai 6 berisi stack card profile detail, table riwayat pendidikan, dan table pengalaman kerja.
- Look dan nuansa visual tetap sama dengan halaman existing.
- Tidak ada perubahan pada route, controller, model, migration, atau logic data.
- Placeholder data kosong tetap tampil untuk profile, pendidikan, dan pengalaman kerja.
- Tombol `Ubah Data` pada profile detail, education history, dan work experience tetap tersedia.
- Halaman tetap responsif pada mobile.

## Checklist Implementasi
- Buka `resources/views/admin/user/detail.blade.php`.
- Pertahankan blok `@php` dan header halaman.
- Ubah wrapper konten utama menjadi grid 6 kolom pada desktop.
- Pindahkan markup foto profile ke card kiri.
- Tempatkan card `Profile Detail`, `Education History`, dan `Work Experience` dalam stack kanan.
- Ubah markup education history menjadi table.
- Ubah markup work experience menjadi table.
- Jalankan pengecekan render manual pada kondisi data lengkap dan data kosong.
