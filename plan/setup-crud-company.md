# PRD Setup CRUD Company

## Tujuan
- Membuat halaman manajemen data perusahaan Jepang di sisi admin.
- Menyediakan fitur CRUD perusahaan dengan pola MVC Laravel.
- Menampilkan seluruh data perusahaan yang diinput admin ke halaman publik `/jp-company`.
- Menghubungkan setiap card perusahaan publik ke halaman detail perusahaan.
- Memberikan arahan high level untuk Junior Fullstack Developer atau AI model murah agar implementasi tidak melewati scope.

## Latar Belakang
- Halaman publik `resources/views/landing/jp-company.blade.php` dan `resources/views/landing/jp-company-detail.blade.php` sudah tersedia.
- Saat ini halaman publik masih perlu diarahkan agar membaca data perusahaan dari database.
- Migration `2026_06_26_062833_create_table_company.php` sudah tersedia.
- Migration tersebut menjadi sumber utama field yang digunakan; implementor tidak perlu merancang field baru.
- Tabel yang digunakan adalah `company`.
- Admin membutuhkan halaman terpisah untuk daftar, tambah, detail, edit, update, dan hapus data perusahaan.

## Ruang Lingkup
- Membuat model `Company`.
- Membuat controller `CompanyController`.
- Menambahkan routes admin di path `admin/jp-company`.
- Membuat view admin di folder `resources/views/admin/company`.
- Membuat halaman admin daftar perusahaan dalam bentuk table.
- Membuat halaman admin create perusahaan.
- Membuat halaman admin detail perusahaan.
- Membuat halaman admin edit perusahaan.
- Menambahkan proses store, update, dan delete perusahaan.
- Menampilkan data perusahaan dari database ke halaman publik `landing/jp-company.blade.php`.
- Menampilkan detail perusahaan dari database ke halaman publik `landing/jp-company-detail.blade.php`.

## Di Luar Scope
- Jangan membuat fitur relasi perusahaan dengan lowongan.
- Jangan membuat fitur approval perusahaan.
- Jangan membuat fitur status aktif/nonaktif kecuali kolom tersebut sudah tersedia.
- Jangan membuat API baru.
- Jangan membuat role admin baru.
- Jangan mengubah desain besar layout admin atau landing.
- Jangan mengubah migration kecuali ada blocker teknis yang benar-benar menghambat implementasi.
- Jangan menambah field database di luar yang tersedia pada migration.

## Data Yang Digunakan
- Gunakan tabel `company`.
- Gunakan hanya field dari migration `2026_06_26_062833_create_table_company.php`:
  - `name`
  - `logo`
  - `bio`
  - `location`
  - `website`
  - `field`
  - `facility`
  - `established`

## Prinsip Implementasi
- Ikuti pola MVC Laravel yang sudah digunakan pada fitur admin existing.
- Gunakan middleware admin yang sudah berlaku untuk halaman admin.
- Gunakan TailwindCSS dan nuansa layout admin existing.
- Semua label field input pada halaman admin menggunakan bahasa Indonesia.
- Simpan file logo menggunakan mekanisme upload file dan storage yang konsisten dengan upload file existing.
- Semua halaman admin perusahaan berada di folder `resources/views/admin/company`.
- Halaman publik tetap memakai file yang sudah ada, yaitu `landing/jp-company.blade.php` dan `landing/jp-company-detail.blade.php`.
- Jangan membuat ulang layout landing dari nol; cukup ubah sumber data dari array statis menjadi data database.

## Arah Arsitektur

### Model
- Buat model `Company`.
- Model merepresentasikan tabel `company`.
- Model mendukung mass assignment untuk field yang tersedia pada migration.
- Jika dibutuhkan, model boleh menyediakan helper sederhana untuk URL logo.
- Kolom `logo` menyimpan path file logo yang sudah diupload, bukan URL manual dari input teks.
- Jika halaman publik membutuhkan slug detail, gunakan pendekatan yang konsisten dan sederhana tanpa menambah scope besar.

### Controller
- Buat `CompanyController`.
- Controller admin minimal menangani:
  - Menampilkan daftar perusahaan.
  - Menampilkan form create.
  - Menyimpan data perusahaan baru.
  - Menampilkan detail perusahaan.
  - Menampilkan form edit.
  - Memperbarui data perusahaan.
  - Menghapus data perusahaan.
- Untuk halaman publik, gunakan controller publik yang sudah ada jika memungkinkan.
- Jika `LandingController` saat ini masih memakai data array statis, ubah agar mengambil data dari model `Company`.

### Routes
- Route admin ditempatkan di area admin yang sudah menggunakan middleware admin.
- Gunakan path `admin/jp-company`.
- Route admin minimal:
  - `GET admin/jp-company` untuk daftar table.
  - `GET admin/jp-company/create` untuk form create.
  - `POST admin/jp-company` untuk store.
  - `GET admin/jp-company/{company}` untuk detail.
  - `GET admin/jp-company/{company}/edit` untuk form edit.
  - `PUT/PATCH admin/jp-company/{company}` untuk update.
  - `DELETE admin/jp-company/{company}` untuk delete.
- Route publik tetap:
  - `/jp-company`
  - `/jp-company/{slug atau id}`

## View Admin

### Daftar Perusahaan
- Buat halaman table di `resources/views/admin/company/index.blade.php`.
- Tampilkan daftar perusahaan dengan kolom utama:
  - Logo
  - Nama
  - Lokasi
  - Website
  - Bidang
  - Tahun berdiri
  - Aksi
- Aksi minimal:
  - Detail
  - Edit
  - Hapus
- Tombol tambah perusahaan harus terlihat jelas di atas table.
- Hapus wajib memakai konfirmasi user.

### Create Perusahaan
- Buat halaman form create di `resources/views/admin/company/create.blade.php`.
- Form mengikuti style input admin existing.
- Field form mengikuti field database dari migration.
- Label input harus memakai bahasa Indonesia, misalnya `Nama Perusahaan`, `Logo`, `Profil Perusahaan`, `Lokasi`, `Website`, `Bidang`, `Fasilitas`, dan `Tahun Berdiri`.
- Logo menggunakan input file, bukan input teks.
- Setelah sukses, redirect ke daftar atau detail dengan flash message.

### Detail Perusahaan
- Buat halaman detail di `resources/views/admin/company/show.blade.php`.
- Tampilkan seluruh data perusahaan secara mudah dibaca.
- Sertakan logo, nama, bio, lokasi, website, bidang, fasilitas, dan tahun berdiri.
- Sediakan tombol kembali ke list dan tombol edit.

### Edit Perusahaan
- Buat halaman form edit di `resources/views/admin/company/edit.blade.php`.
- Form menampilkan data existing.
- Label input harus tetap memakai bahasa Indonesia seperti pada halaman create.
- Logo lama tetap dipakai jika admin tidak upload logo baru.
- Jika logo diganti, hapus file logo lama jika mekanisme storage existing mendukung hal tersebut.
- Setelah sukses, redirect ke daftar atau detail dengan flash message.

## View Publik

### Halaman List `/jp-company`
- Gunakan `resources/views/landing/jp-company.blade.php`.
- Tampilkan seluruh data perusahaan dari database.
- Card perusahaan minimal menampilkan logo, nama, lokasi, dan bidang.
- Setiap card dapat diklik ke halaman detail perusahaan.
- Jika belum ada perusahaan, tampilkan empty state sederhana.

### Halaman Detail `/jp-company/{slug atau id}`
- Gunakan `resources/views/landing/jp-company-detail.blade.php`.
- Tampilkan detail perusahaan dari database.
- Mapping field publik:
  - `bio` sebagai deskripsi/profil perusahaan.
  - `field` sebagai bidang/industri.
  - `facility` sebagai fasilitas.
  - `established` sebagai tahun berdiri.
- Jangan bergantung lagi pada data array statis di controller.

## Validasi
- `name` wajib diisi.
- `logo` wajib diisi saat create dan opsional saat edit.
- `bio` wajib diisi.
- `location` wajib diisi.
- `website` wajib diisi.
- `field` wajib diisi.
- `facility` wajib diisi.
- `established` wajib diisi.
- Batasi format logo ke gambar yang wajar seperti JPG, JPEG, PNG, WEBP, atau SVG sesuai pola upload existing.
- Batasi ukuran file logo dengan angka yang wajar dan konsisten dengan upload existing.

## Mekanisme Upload Logo
- Pada halaman create, admin wajib mengupload logo perusahaan.
- Pada halaman edit, admin boleh tidak mengupload logo baru; jika kosong, logo lama tetap dipakai.
- Jika admin mengupload logo baru saat edit, sistem menyimpan logo baru dan mengganti nilai kolom `logo`.
- Jika logo lama tersimpan di storage lokal dan bukan asset bawaan, hapus logo lama setelah update berhasil.
- Simpan file logo pada folder storage yang jelas, misalnya `company-logos`.
- Pastikan logo yang sudah tersimpan dapat ditampilkan di halaman admin dan publik.
- Jangan menggunakan input teks untuk mengisi kolom `logo`.

## Rencana Alur Data

### Admin Create
- Admin membuka halaman `admin/jp-company/create`.
- Admin mengisi form berbahasa Indonesia dan upload logo.
- Sistem memvalidasi input.
- Sistem menyimpan logo dan membuat record company.
- Sistem redirect dengan flash message sukses.

### Admin Edit
- Admin membuka halaman edit perusahaan.
- Sistem menampilkan data existing.
- Admin memperbarui data melalui form berbahasa Indonesia dan opsional mengganti logo.
- Sistem memvalidasi input.
- Sistem update record company.
- Sistem redirect dengan flash message sukses.

### Admin Delete
- Admin menekan hapus di daftar atau detail.
- Sistem meminta konfirmasi.
- Jika dikonfirmasi, sistem hapus logo bila diperlukan dan hapus record company.
- Sistem redirect dengan flash message sukses.

### Publik List dan Detail
- User membuka `/jp-company`.
- Controller mengambil semua data perusahaan dari database.
- View menampilkan daftar card perusahaan.
- User klik card perusahaan.
- Controller mengambil data perusahaan sesuai parameter route.
- View detail menampilkan informasi perusahaan.

## Kriteria Hasil
- Model `Company` tersedia.
- Controller `CompanyController` tersedia.
- Route admin `admin/jp-company` tersedia lengkap untuk CRUD.
- View admin tersedia di folder `resources/views/admin/company`.
- Admin dapat melihat daftar perusahaan dalam table.
- Admin dapat membuat perusahaan baru.
- Admin dapat melihat detail perusahaan.
- Admin dapat mengedit perusahaan.
- Admin dapat menghapus perusahaan dengan konfirmasi.
- Logo perusahaan tersimpan dan tampil di admin maupun publik.
- Logo perusahaan diupload melalui input file pada form admin.
- Seluruh field input admin menggunakan label bahasa Indonesia.
- Halaman `/jp-company` membaca data perusahaan dari database.
- Halaman detail perusahaan publik membaca data dari database.
- Tampilan admin konsisten dengan layout admin existing.
- Tampilan publik tetap memakai halaman landing yang sudah tersedia.

## Catatan Untuk Implementor
- Kerjakan hanya scope CRUD perusahaan Jepang.
- Ikuti pola route, controller, flash message, validasi, dan view admin existing.
- Jangan membuat redesign besar pada halaman admin atau landing.
- Jangan menambah field baru di luar migration `2026_06_26_062833_create_table_company.php`.
- Jangan membuat fitur relasi perusahaan dengan vacancy.
- Jika field existing di view publik berbeda dengan field migration, lakukan mapping sederhana di controller atau view.
- Pastikan perubahan publik mengganti sumber data dari array statis menjadi database, bukan membuat data dummy baru.
- Pastikan form admin memakai bahasa Indonesia untuk label dan feedback yang terlihat user.
