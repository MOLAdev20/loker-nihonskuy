# Plan Setup Register Login User UI

## Tujuan
- Membuat layout baru untuk halaman register dan login user.
- Melakukan redesign tampilan halaman auth agar lebih modern, responsive, mobile first, dan clean.
- Menjaga perubahan hanya pada sisi front-end Blade dan Tailwind CSS tanpa mengubah alur backend yang sudah ada.

## Ruang Lingkup
- Redesign halaman `resources/views/auth/login.blade.php`.
- Redesign halaman `resources/views/auth/register.blade.php`.
- Menyesuaikan struktur layout, spacing, warna, tipografi, dan visual pendukung pada kedua halaman.
- Mempertahankan route, method form, nama field, validasi error, CSRF token, dan script existing yang masih dibutuhkan.

## Batasan Scope
- Tidak mengubah controller auth, route auth, request validation, model, database, atau logic backend lainnya.
- Tidak mengubah nama input yang sudah dipakai backend.
- Tidak menambah flow autentikasi baru seperti social login, OTP, verifikasi tambahan, atau perubahan reset password.
- Tidak mengubah behavior pengecekan kode referal selain memastikan tampilannya tetap rapi di layout baru.
- Tidak memperluas perubahan ke halaman auth lain seperti forgot password, reset password, verify email, atau confirm password.

## Prinsip Desain
- Gunakan Tailwind CSS sebagai fondasi styling.
- Terapkan pendekatan mobile first agar tampilan utama nyaman digunakan dari layar kecil.
- Gunakan nuansa visual yang modern, bersih, dan tidak terlalu ramai.
- Fokuskan halaman pada form utama, judul, subjudul, dan aksi submit.
- Pertahankan brand feel Nihonskuy dengan visual yang masih relevan dengan konteks Jepang dan karier.
- Pastikan kontras teks, field, tombol, dan pesan error mudah dibaca.

## Struktur Layout

### 1. Desktop dan Tablet Lebar
- Gunakan layout dua kolom.
- Kolom kiri berisi form utama.
- Kolom kanan berisi gambar atau visual pendukung.
- Komposisi kolom harus seimbang, dengan form tetap menjadi fokus utama.
- Area form memuat:
  - title halaman
  - sub-header atau deskripsi pendek
  - form input
  - tombol submit
  - link navigasi ke halaman auth pasangan

### 2. Mobile
- Sembunyikan kolom gambar.
- Tampilkan hanya form utama agar halaman lebih ringan dan fokus.
- Pastikan form memiliki padding yang cukup, field mudah disentuh, dan tombol submit terlihat jelas.
- Hindari layout yang membuat user perlu melakukan horizontal scroll.

## Arah Halaman Login
- Title utama menggunakan konteks login, misalnya `Login` atau `Masuk ke Akun`.
- Sub-header menjelaskan bahwa user dapat melanjutkan akses ke akun Nihonskuy.
- Form tetap menggunakan action `{{ route('login') }}` dan method `POST`.
- Field yang wajib dipertahankan:
  - `email`
  - `password`
- Tombol show/hide password tetap dapat digunakan.
- Link menuju register tetap mengarah ke `{{ route('register') }}`.

## Arah Halaman Register
- Title utama menggunakan konteks register, misalnya `Register` atau `Buat Akun Baru`.
- Sub-header menjelaskan bahwa user dapat mulai membuat akun Nihonskuy.
- Form tetap menggunakan action `{{ route('register') }}` dan method `POST`.
- Field yang wajib dipertahankan:
  - `fullname`
  - `email`
  - `password`
  - `confirm-pwd`
  - `ref_code`
- Pesan validasi error dari Laravel tetap ditampilkan di field terkait.
- Tombol show/hide password dan konfirmasi password tetap dapat digunakan.
- Pengecekan kode referal existing tetap dipertahankan.
- Link menuju login tetap mengarah ke `{{ route('login') }}`.

## Arah Visual Gambar
- Gunakan gambar pada sisi kanan hanya untuk viewport desktop atau tablet lebar.
- Gambar dapat menggunakan asset publik yang sudah tersedia di project jika relevan.
- Visual harus mendukung konteks Nihonskuy, Jepang, kerja, atau onboarding user.
- Pastikan gambar tidak mengganggu keterbacaan form.
- Pada mobile, gambar tidak perlu dirender secara visual agar user langsung fokus ke form.

## Komponen dan Styling
- Field input dibuat konsisten pada login dan register.
- Label, placeholder, error message, dan helper text harus memiliki jarak yang rapi.
- Button utama dibuat jelas sebagai action paling penting.
- Link auth pasangan dibuat terlihat tetapi tidak lebih dominan dari tombol submit.
- Gunakan border, shadow, background, dan radius secara secukupnya untuk menjaga tampilan clean.
- State focus pada input harus jelas untuk aksesibilitas dasar.

## Tahapan Implementasi

### Fase 1 - Review Struktur Existing
- Cek struktur Blade pada `login.blade.php` dan `register.blade.php`.
- Catat elemen yang harus dipertahankan karena terkait backend, seperti action form, CSRF, name input, error handling, dan script.

### Fase 2 - Setup Layout Umum
- Buat struktur wrapper responsive untuk dua kolom.
- Tempatkan form di sisi kiri pada desktop.
- Tempatkan visual pendukung di sisi kanan pada desktop.
- Sembunyikan area visual pada mobile.

### Fase 3 - Redesign Login
- Terapkan layout baru ke halaman login.
- Tambahkan title dan sub-header yang sesuai.
- Rapikan field email, password, tombol submit, toggle password, dan link register.

### Fase 4 - Redesign Register
- Terapkan layout baru ke halaman register.
- Tambahkan title dan sub-header yang sesuai.
- Rapikan field fullname, email, password, confirm password, referal code, tombol submit, toggle password, dan link login.
- Pastikan pesan error dan pesan referal tetap tampil dengan jelas.

### Fase 5 - Responsive Check
- Cek tampilan mobile, tablet, dan desktop.
- Pastikan gambar tersembunyi pada mobile.
- Pastikan form tetap terbaca, tidak terpotong, dan tidak menimbulkan horizontal scroll.

## Kriteria Hasil
- `resources/views/auth/login.blade.php` memiliki tampilan baru yang modern, responsive, mobile first, dan clean.
- `resources/views/auth/register.blade.php` memiliki tampilan baru yang modern, responsive, mobile first, dan clean.
- Pada desktop, halaman menggunakan layout dua kolom dengan form di kiri dan gambar di kanan.
- Pada mobile, gambar tidak ditampilkan dan halaman fokus pada form utama.
- Title dan sub-header tersedia pada halaman login dan register.
- Semua action form, CSRF token, name input, error message, dan script front-end existing yang relevan tetap berjalan.
- Tidak ada perubahan pada backend, route, controller, model, database, atau flow autentikasi.

## Catatan Implementasi
- Kerjakan hanya sesuai scope halaman login dan register user.
- Jangan melewati instruksi dengan menambahkan fitur auth baru.
- Bila perlu memilih asset gambar, prioritaskan asset yang sudah tersedia di folder `public`.
- Jika asset existing tidak cocok, gunakan pendekatan visual sederhana yang tetap clean tanpa mengubah scope backend.
