# Plan Admin Edit Profile User

## Tujuan
- Membuat alur admin untuk menginput dan mengedit data user berdasarkan `userId`, mencakup `user_profile`, `user_education_history`, dan `user_working_experience`.
- Menjadikan halaman detail user admin sebagai pusat observasi dan titik masuk aksi edit agar admin dapat melihat dan memperbarui seluruh data user dari area `/admin/users/{id}`.
- Menjaga implementasi tetap mengikuti pola MVC dengan pembagian tanggung jawab yang tegas antara route, controller, model, dan view.

## Scope Fitur
- Tambahkan tombol aksi edit dengan ikon pensil dan label `Ubah Data` pada halaman `resources/views/admin/user/detail.blade.php`.
- Sediakan halaman/form admin terpisah untuk:
  - data profile user
  - riwayat pendidikan user
  - riwayat pengalaman kerja user
- Gunakan route group yang sudah tersedia di bawah `/admin/users/{id}`:
  - `profile`
  - `education`
  - `working-experience`
- Untuk data yang multi-record seperti pendidikan dan pengalaman kerja, gunakan pendekatan modal-based input/edit/delete dengan referensi pola dari form user-side yang sudah ada.
- Tambahkan wizard atau step indicator agar admin memahami urutan pengelolaan data saat berpindah antar bagian.

## Arah Arsitektur
- Tetapkan `App\Models\User` sebagai aggregate root untuk proses admin edit user.
- Pertahankan `UserController@showAccountDetail` sebagai halaman detail utama yang menampilkan snapshot lengkap data user dan menyediakan entry point ke halaman edit masing-masing domain data.
- Pisahkan tanggung jawab mutasi data ke controller yang sesuai:
  - `UserProfileController` untuk profile pribadi
  - `UserEducationController` untuk riwayat pendidikan
  - `UserWorkingExpController` untuk riwayat pekerjaan
- Semua pengambilan data harus memanfaatkan relasi Eloquent yang sudah atau akan tersedia pada model, sehingga tidak ada query manual di Blade.
- Gunakan camelCase untuk nama variabel, method, parameter, dan key data yang dikirim ke view.

## Struktur Route

### Detail sebagai halaman induk
- Pertahankan route detail admin user pada `/admin/users/{id}` sebagai halaman ringkasan utama.
- Dari halaman ini, admin dapat berpindah ke form profile, pendidikan, dan pengalaman kerja melalui tombol aksi yang jelas.

### Route group per domain data
- Gunakan group route yang sudah disediakan agar struktur URL tetap konsisten dan mudah dipahami.
- Pola yang disarankan:
  - `/admin/users/{id}/profile/...` untuk create/update profile
  - `/admin/users/{id}/education/...` untuk list, tambah, ubah, dan hapus riwayat pendidikan
  - `/admin/users/{id}/working-experience/...` untuk list, tambah, ubah, dan hapus riwayat pekerjaan
- Setiap route harus mengarah ke controller domain yang relevan, bukan ditangani di `UserController`, agar `UserController` tetap fokus pada halaman list/detail.

## Pembagian Controller

### UserController
- Tetap bertanggung jawab untuk:
  - menampilkan daftar user admin
  - menampilkan detail lengkap user melalui `showAccountDetail`
- Pada halaman detail, controller hanya perlu menyiapkan data read-only lengkap dan informasi navigasi menuju proses edit.

### UserProfileController
- Bertanggung jawab atas alur input dan edit data `user_profile`.
- Menangani skenario:
  - membuka form profile admin
  - membuat data profile bila belum ada
  - memperbarui data profile bila sudah ada
- Pastikan controller menerima konteks `userId`, memverifikasi user target ada, lalu mengikat proses simpan ke user tersebut.

### UserEducationController
- Bertanggung jawab atas seluruh operasi riwayat pendidikan.
- Menangani skenario:
  - menampilkan halaman/form riwayat pendidikan berbasis daftar
  - menambah entry pendidikan baru
  - mengubah entry yang ada
  - menghapus entry
- Karena datanya one-to-many, controller ini sebaiknya mengelola lifecycle per record tanpa mencampur logika profile atau pengalaman kerja.

### UserWorkingExpController
- Bertanggung jawab atas seluruh operasi riwayat pengalaman kerja.
- Menangani skenario:
  - menampilkan halaman/form riwayat pekerjaan berbasis daftar
  - menambah entry pekerjaan baru
  - mengubah entry yang ada
  - menghapus entry
- Struktur dan UX sebaiknya paralel dengan halaman pendidikan agar konsisten untuk admin.

## Strategi View

### 1. Halaman detail admin user
- Update `resources/views/admin/user/detail.blade.php` agar setiap section utama memiliki CTA `Ubah Data`.
- Tombol edit sebaiknya ditempatkan dekat judul section terkait, sehingga admin langsung memahami area data mana yang akan diedit.
- CTA dapat dibagi menjadi:
  - edit profile
  - kelola pendidikan
  - kelola pengalaman kerja

### 2. View form admin profile
- Buat `resources/views/admin/user/profile-form.blade.php`.
- Tujuannya untuk input atau edit satu record profile user.
- Gunakan layout admin yang konsisten dengan dashboard yang sudah ada.
- Sertakan wizard step agar admin tetap bisa memahami posisi tahap input walaupun form ini dapat diakses langsung dari halaman detail.

### 3. View form admin pendidikan
- Buat `resources/views/admin/user/education-history-form.blade.php`.
- Gunakan pendekatan list + modal untuk tambah/edit, mengacu pada pola user-side yang sudah tersedia.
- Karena data pendidikan dapat lebih dari satu, halaman ini perlu berfungsi sebagai area manajemen record, bukan sekadar satu form statis.
- Tetap tampilkan wizard step untuk menjaga alur dan orientasi admin.

### 4. View form admin pengalaman kerja
- Buat `resources/views/admin/user/working-experience-form.blade.php`.
- Gunakan pendekatan list + modal yang paralel dengan halaman pendidikan.
- Struktur interaksi sebaiknya mencakup:
  - daftar data yang sudah ada
  - tombol tambah
  - tombol edit per record
  - tombol hapus per record
- Wizard step harus tetap tersedia agar konsisten dengan form admin profile dan pendidikan.

## Strategi Wizard / Step
- Wizard berfungsi sebagai orientasi proses, bukan sebagai hard lock antar halaman.
- Step yang disarankan:
  - Profile
  - Riwayat Pendidikan
  - Riwayat Pekerjaan
  - Detail User atau Review Kembali
- Wizard harus menandai step aktif sesuai halaman saat ini dan memberi jalur navigasi yang jelas ke step lain bila memang diizinkan.
- Karena admin bekerja atas data user yang sudah ada, wizard lebih tepat diposisikan sebagai navigasi terstruktur daripada proses onboarding penuh.

## Alur Data dan Navigasi
- Admin membuka `/admin/users`.
- Admin memilih salah satu user dan masuk ke `/admin/users/{id}`.
- Halaman detail menampilkan seluruh data user yang sudah di-eager-load oleh `UserController@showAccountDetail`.
- Dari detail, admin memilih `Ubah Data` pada section yang relevan.
- Admin diarahkan ke halaman domain yang sesuai:
  - profile form
  - education history form
  - working experience form
- Setelah proses simpan, update, atau hapus berhasil, admin dikembalikan ke halaman domain terkait atau ke halaman detail dengan status feedback yang jelas.

## Prinsip Data dan Model
- Gunakan relasi model yang sudah ada sebagai fondasi pengambilan data untuk profile, pendidikan, dan pengalaman kerja.
- Hindari join manual di view atau penggabungan data menggunakan array sementara di Blade.
- Untuk halaman detail, gunakan eager loading agar seluruh relasi utama sudah siap saat render.
- Untuk halaman pendidikan dan pengalaman kerja, muat data berdasarkan `userId` dan relasi yang sesuai agar controller tetap bersih dan konsisten.

## Prinsip UX dan UI
- Pertahankan bahasa visual admin dashboard yang sudah ada agar fitur baru terasa native.
- Gunakan card-based layout untuk area profile, pendidikan, dan pengalaman kerja.
- Pada halaman multi-record, prioritaskan keterbacaan tabel/daftar dan kejelasan aksi per row.
- Modal create/edit harus fokus, ringkas, dan tidak memaksa admin meninggalkan konteks halaman daftar.
- Tampilkan placeholder yang sopan jika belum ada data profile, pendidikan, atau pengalaman kerja.

## Validasi dan Error Handling
- Jika `userId` tidak valid atau user tidak ditemukan, sistem harus mengembalikan 404.
- Jika relasi tertentu belum memiliki data, halaman tetap harus tampil stabil tanpa error.
- Semua proses simpan, ubah, dan hapus harus mengembalikan feedback status yang jelas ke admin.
- Validasi tetap dilakukan di layer controller/request yang relevan, bukan di Blade.

## Kriteria Hasil
- Admin dapat mengelola profile, pendidikan, dan pengalaman kerja user dari area `/admin/users/{id}` dengan alur yang konsisten.
- Halaman detail user memiliki tombol `Ubah Data` yang jelas untuk setiap section penting.
- Route tertata rapi menggunakan prefix `profile`, `education`, dan `working-experience`.
- Tanggung jawab controller terpisah per domain data dan tidak menumpuk di `UserController`.
- Halaman pendidikan dan pengalaman kerja mendukung create, edit, dan delete berbasis modal.
- Wizard/step tampil konsisten di halaman form admin untuk membantu orientasi navigasi.
- Tidak ada query manual di Blade, dan penamaan backend/frontend tetap camelCase.

## Catatan Implementasi
- Secara arsitektur, controller domain `UserProfileController`, `UserEducationController`, dan `UserWorkingExpController` perlu dianggap sebagai bagian dari scope implementasi bila belum tersedia di codebase.
- Nama file view pada implementasi Laravel sebaiknya mengikuti standar Blade, sehingga target operasional yang direkomendasikan adalah:
  - `admin/user/profile-form.blade.php`
  - `admin/user/education-history-form.blade.php`
  - `admin/user/working-experience-form.blade.php`
- Fokus plan ini adalah struktur, alur, dan pembagian tanggung jawab. Detail teknis validasi field, markup modal, dan wiring action per method dapat diturunkan oleh implementor pada tahap development.
