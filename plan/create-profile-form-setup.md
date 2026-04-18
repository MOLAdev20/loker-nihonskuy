# Plan Create Profile Form

## Tujuan
- Menyusun rencana pembuatan UI form input user profile pada route `/my/fill-profile` dengan pendekatan arsitektur MVC.
- Menyiapkan alur submit `POST /my/fill-profile` untuk menyimpan data request user ke tabel `user_profile`.
- Menjaga agar implementasi tetap high level, terstruktur, dan cukup jelas untuk dikerjakan oleh junior fullstack programmer atau AI model dengan kemampuan terbatas.

## Ruang Lingkup
- Pembuatan halaman form input profile user.
- Penyesuaian route untuk halaman form dan proses submit.
- Penyusunan alur MVC antara route, controller, request validation, model, dan view.
- Validasi input di sisi server beserta penampilan error pada UI.
- Penyimpanan data request ke tabel `user_profile`.

## Prinsip Implementasi
- Gunakan pendekatan MVC secara tegas agar tanggung jawab route, controller, request validation, model, dan view tetap terpisah.
- Gunakan naming `camelCase` untuk variabel, function, method, dan identifier baru.
- Pastikan halaman form mengikuti layout dasar area content yang sudah digunakan pada halaman profile dashboard.
- Fokus pada pengalaman input yang rapi, ringan, responsif, dan mudah dipahami user.
- Hindari logika validasi langsung di Blade; validasi harus berada di sisi server.
- Jangan menambah fitur di luar scope form profile dan penyimpanan ke `user_profile`.

## Arah Arsitektur MVC
### 1. Route
- Sediakan route `GET /my/profile` untuk menampilkan form profile.
- Sediakan route `POST /my/fill-profile` untuk menerima submit form profile.
- Pastikan route berada dalam area user yang membutuhkan autentikasi.

### 2. Controller
- Gunakan controller user profile sebagai titik orkestrasi alur form.
- Controller bertugas menampilkan form, menerima request yang sudah tervalidasi, memetakan data ke model, lalu menyimpan ke tabel `user_profile`.
- Controller hanya mengelola flow aplikasi, bukan memuat detail validasi panjang atau logika tampilan.

### 3. Request Validation
- Gunakan request object khusus agar aturan validasi terpisah dari controller.
- Seluruh aturan validasi harus mengikuti requirement field yang sudah ditentukan.
- Pesan error harus formal, singkat, berbahasa Indonesia, dan relevan dengan jenis kesalahan input.

### 4. Model
- Gunakan model yang merepresentasikan tabel `user_profile`.
- Pastikan field yang disimpan dari request dipetakan secara jelas dan konsisten ke struktur tabel.
- Hindari pencampuran field lama dari tabel atau model profile sebelumnya jika naming schema sudah berubah.

### 5. View
- Gunakan view `user/profile-form.blade.php`.
- Layout dasar mengikuti pola section content dari halaman profile yang sudah ada agar tampilan tetap konsisten.
- Blade difokuskan untuk rendering form, old input, state error, dan feedback visual validasi.

## Struktur Halaman
### 1. Layout Konten
- Tempatkan form di dalam card atau panel utama yang konsisten dengan gaya dashboard user.
- Sediakan judul halaman, subjudul singkat, dan area form utama.
- Pertahankan tampilan modern, minimalist, soft, dan tetap dekat dengan pola input Bootstrap yang bersih.

### 2. Responsivitas
- Gunakan block layout dari atas ke bawah untuk mobile.
- Gunakan grid untuk medium sampai large screen agar form lebih ringkas dan nyaman dipindai.
- Pastikan jarak antar field, label, helper state, dan tombol submit tetap konsisten di semua ukuran layar.

### 3. Pola Komponen Input
- Setiap field memiliki label yang jelas, elemen input utama, dan area error text di bawah input.
- Saat validasi gagal, border field berubah merah dan error text ditampilkan dengan ukuran kecil (`text-xs`).
- Nilai input sebelumnya harus tetap tampil kembali agar user tidak perlu mengisi ulang seluruh form.

## Spesifikasi Field Form
| Field | Tipe Input | Aturan Utama | Label |
| --- | --- | --- | --- |
| `fullName` | Text | min 3, max 255, required | Nama Lengkap |
| `furiganaName` | Text | min 3, max 255, required | Furigana |
| `birthDate` | Date | required | Tanggal Lahir |
| `gender` | Radio | required, `male` / `female` | Jenis Kelamin |
| `height` | Number | required | Tinggi Badan |
| `weight` | Number | required | Berat Badan |
| `maritalStatus` | Radio | required, `single` / `married` / `divorce` | Status Pernikahan |
| `nationality` | Text | min 3, max 255, required | Kewarganegaraan |
| `placeOfOrigin` | Text | min 3, max 255, required | Tempat Asal |
| `currentAddress` | Textarea | min 3, max 255, required | Alamat Saat Ini |
| `religion` | Select | required | Agama |
| `isWearingHijab` | Text | min 3, max 255, required | Apakah Menggunakan Hijab? |
| `prayerRequirement` | Text | min 3, max 255, required | Kebutuhan Ibadah |
| `porkTolerance` | Text | min 3, max 255, required | Toleransi Terhadap Daging Babi |
| `alcoholTolerance` | Text | min 3, max 255, required | Toleransi Terhadap Alkohol |
| `entryDate` | Date | mengikuti requirement form | Tanggal Masuk Jepang |
| `visaExpiryDate` | Date | mengikuti requirement form | Masa Berlaku VISA |
| `currentVisaType` | Text | min 3, max 255, required | Jenis Visa Saat Ini |
| `jlptLevel` | Select | required | Level Kemampuan Bahasa Jepang (JLPT) |
| `hasDriverLicense` | Text | min 3, max 255, required | Memiliki SIM? |
| `workStartDate` | Date | required | Tanggal Siap Mulai Kerja |
| `technicalExperience` | Textarea | required | Detail Pengalaman Magang/Skill |

## Rencana Validasi Server
- Validasi harus dilakukan penuh di sisi server sebelum data disimpan.
- Gunakan aturan validasi yang konsisten dengan tipe field, batas minimal, batas maksimal, dan status required.
- Untuk radio dan select, pastikan hanya nilai yang diizinkan yang dapat diterima.
- Untuk date dan number, pastikan format data sesuai tipe yang diharapkan.
- Tampilkan pesan validasi tepat di bawah field terkait, bukan dikumpulkan menjadi satu blok global saja.

## Rencana UI dan UX Form
- Gunakan Tailwind CSS dengan pendekatan visual yang bersih, lembut, dan modern.
- Input text, textarea, select, radio, dan date harus memiliki tinggi, padding, border, radius, dan focus state yang seragam.
- Error state harus terlihat jelas tetapi tetap halus, terutama melalui border merah dan text error kecil di bawah field.
- Tombol submit harus mudah ditemukan, kontras secukupnya, dan tetap selaras dengan visual dashboard.
- Pastikan form tetap nyaman diisi pada mobile tanpa membuat user harus melakukan zoom atau horizontal scroll.

## Rencana Alur Data
### 1. Tampil Form
- User mengakses `GET /my/profile`.
- Sistem menampilkan `user/profile-form.blade.php` di area content dashboard user.

### 2. Submit Form
- User mengirim form ke `POST /my/fill-profile`.
- Request tervalidasi lebih dulu di server.
- Jika validasi gagal, user kembali ke form yang sama dengan old input, border error, dan pesan validasi per field.

### 3. Simpan Data
- Jika validasi lolos, controller meneruskan data ke model yang terhubung ke tabel `user_profile`.
- Data disimpan secara konsisten sesuai mapping field yang sudah disepakati.
- Setelah berhasil, user diarahkan ke halaman yang relevan dengan feedback sukses yang ringkas.

## Dependency Penting
- Tabel `user_profile` yang sudah direncanakan sebelumnya harus benar-benar tersedia sebelum alur penyimpanan dijalankan.
- Field form saat ini memuat `height` dan `weight`, sementara keduanya belum terlihat pada migration `user_profile` yang ada saat ini.
- Tabel `user_profile` saat ini juga memuat field wajib seperti `profile_picture`, tetapi field tersebut belum ada dalam requirement form ini.
- Requirement form untuk `entryDate` dan `visaExpiryDate` tidak menandai keduanya sebagai required, sedangkan schema `user_profile` sebelumnya menetapkannya sebagai wajib.
- Sebelum implementasi coding dimulai, mapping field form dan schema database harus disejajarkan agar tidak terjadi kegagalan simpan atau kebutuhan hidden workaround.

## Tahapan Implementasi
### Fase 1 - Penyelarasan Kontrak Data
- Samakan daftar field form dengan field final pada tabel `user_profile`.
- Pastikan naming request, naming model, dan naming kolom database konsisten.

### Fase 2 - Fondasi MVC
- Siapkan route, controller method, request validation, dan model yang terhubung ke `user_profile`.
- Pastikan tanggung jawab masing-masing layer tetap bersih.

### Fase 3 - Pembuatan UI Form
- Bangun halaman `user/profile-form.blade.php` dengan struktur content dashboard.
- Terapkan layout responsif block di mobile dan grid di layar lebih besar.

### Fase 4 - Validasi dan Error State
- Hubungkan request validation ke UI form.
- Pastikan old input, pesan error, dan state border merah tampil per field.

### Fase 5 - Finalisasi Alur Simpan
- Pastikan submit form berhasil masuk ke tabel `user_profile`.
- Rapikan feedback sukses, konsistensi naming, dan kualitas pengalaman user.

## Kriteria Hasil
- Route `GET /my/profile` menampilkan form profile user.
- Route `POST /my/fill-profile` menerima dan memproses submit form.
- View `user/profile-form.blade.php` menggunakan layout content yang konsisten dengan halaman profile.
- Form tampil responsif: block di mobile, grid di medium-large.
- Validasi berjalan di sisi server dan ditampilkan tepat di bawah field terkait.
- Pesan error menggunakan bahasa Indonesia formal singkat.
- Field error memiliki border merah saat validasi gagal.
- Data request yang valid tersimpan ke tabel `user_profile` melalui alur MVC yang rapi.
- Naming baru mengikuti pola `camelCase`.

## Catatan Implementasi
- Jangan mencampur pola field lama seperti `nama_lengkap` atau `furigana` jika kontrak barunya memakai naming lain.
- Jangan menaruh logika bisnis atau validasi kompleks di Blade.
- Jangan memperluas scope ke fitur edit profile, upload file, API, atau workflow lain di luar instruksi ini.
- Fokus pada form create profile, validasi server, rendering error, dan penyimpanan ke `user_profile`.
