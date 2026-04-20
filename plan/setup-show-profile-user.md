# Plan Admin User Detail View

## Tujuan
- Membuat halaman detail user admin pada `resources/views/admin/user/detail.blade.php` untuk menampilkan seluruh data penting user yang sudah terdaftar dalam satu halaman.
- Halaman harus menggabungkan data utama dari `users` dengan data relasional dari `user_profile`, `user_education_history`, dan `user_working_experience`.
- Implementasi harus mengikuti pola MVC dengan pembagian tanggung jawab yang jelas antara route, controller, model, dan view.

## Arah Arsitektur
- Gunakan `App\Models\User` sebagai entry point data utama untuk halaman detail admin.
- Tambahkan relasi Eloquent pada model `User` sebagai fondasi pengambilan data:
  - one-to-one ke `UserProfile`
  - one-to-many ke `UserEducationHistory`
  - one-to-many ke `WorkExperience`
- Gunakan eager loading melalui `with()` pada controller agar seluruh data user dan relasinya diambil dalam satu alur query yang efisien.
- Hindari query tambahan, join manual di view, atau logika data yang berat di Blade.

## Rencana Perubahan

### 1. Route
- Tambahkan route detail di dalam group `/admin/users/` dengan pola `/admin/users/{id}`.
- Gunakan route GET dan arahkan ke method `showAccountDetail` pada `UserController`.
- Pastikan route ini berada di dalam middleware admin yang sudah ada agar hanya admin yang dapat mengakses halaman detail user.

### 2. Model
- Lengkapi `App\Models\User` dengan relasi yang dibutuhkan untuk halaman detail:
  - `userProfile`
  - `educationHistories`
  - `workExperiences`
- Gunakan naming camelCase untuk seluruh nama relasi agar konsisten dengan standar project.
- Jika diperlukan, tambahkan helper ringan pada model hanya untuk kebutuhan representasi data yang berulang, tetapi jangan memindahkan tanggung jawab presentasi penuh ke model.

### 3. Controller
- Tambahkan method `showAccountDetail($id)` pada `UserController`.
- Tanggung jawab method ini:
  - menerima `id` user dari route
  - mengambil user berdasarkan ID dengan eager loading seluruh relasi yang relevan
  - menggunakan mekanisme `findOrFail` atau pendekatan setara agar otomatis menghasilkan 404 bila data tidak ditemukan
  - mengirim satu object user yang sudah lengkap ke view dengan nama variabel camelCase, misalnya `user`
- Jaga controller tetap tipis: fokus pada orkestrasi request, pengambilan data, dan return view.

### 4. View
- Buat view baru `resources/views/admin/user/detail.blade.php`.
- Gunakan layout admin yang sudah ada agar tampilan dan navigasi tetap konsisten dengan halaman admin lain.
- Gunakan struktur berbasis card agar pembacaan data lebih mudah pada desktop maupun mobile.
- Susun halaman menjadi beberapa section utama:
  - `Primary Info Card` untuk nama, email, foto profil, dan ringkasan data profile utama
  - `Profile Detail Card` untuk data biodata lengkap dari `user_profile`
  - `Education Card` untuk seluruh riwayat pendidikan
  - `Work Experience Card` untuk seluruh riwayat pekerjaan
- Gunakan list atau timeline sederhana untuk education dan work experience, tanpa interaksi kompleks pada versi awal.
- Tambahkan placeholder yang jelas bila bagian tertentu kosong, misalnya:
  - profile belum diisi
  - belum ada riwayat pendidikan
  - belum ada riwayat pekerjaan

## Prinsip Tampilan
- Prioritaskan keterbacaan dibanding kepadatan informasi.
- Gunakan pemisahan visual yang tegas antar card, misalnya border halus, shadow ringan, spacing konsisten, dan heading per section.
- Pastikan data panjang seperti alamat, pengalaman teknis, atau informasi teks bebas tetap nyaman dibaca.
- Responsivitas wajib dijaga: layout harus tetap rapi di mobile, tablet, dan desktop.

## Alur Data
- Admin membuka daftar user dari halaman `/admin/users`.
- Admin memilih salah satu user untuk melihat detail.
- Route detail mengirim ID ke `UserController@showAccountDetail`.
- Controller mengambil user beserta seluruh relasinya menggunakan eager loading.
- View menerima satu object `user` yang sudah lengkap dan hanya fokus pada rendering data.

## Kriteria Hasil
- Admin dapat melihat seluruh data utama user, profile, pendidikan, dan pengalaman kerja dalam satu halaman.
- Tidak ada query manual atau join manual di Blade.
- Jika user tidak ditemukan, sistem mengembalikan 404 dengan benar.
- Jika sebagian relasi kosong, halaman tetap tampil rapi dengan placeholder yang sesuai.
- Struktur UI berbasis card konsisten dengan dashboard admin dan mudah dipahami oleh pengguna internal.

## Catatan Implementasi
- Karena relasi Eloquent pada `User` belum tersedia saat ini, penambahan relasi harus dianggap sebagai langkah fondasi sebelum controller detail dibuat.
- Gunakan camelCase untuk nama method, variabel backend, nama relasi model, dan referensi object di view.
- Fokus implementasi pada halaman baca/detail terlebih dahulu; tidak perlu menambahkan fitur edit, delete, atau aksi admin lain di scope ini.
