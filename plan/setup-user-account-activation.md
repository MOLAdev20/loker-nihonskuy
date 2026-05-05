# Plan Setup User Account Activation

## Tujuan
- Membuat sistem aktivasi akun melalui email sebelum user dapat beraktivitas di akun miliknya.
- Memanfaatkan fitur email verification bawaan Laravel Breeze yang sudah tersedia di project.
- Menjaga implementasi tetap mengikuti route, controller, model, dan view auth yang sudah ada.

## Ruang Lingkup
- Mengaktifkan mekanisme verifikasi email untuk data user pada tabel `users`.
- Menggunakan alur Laravel Breeze untuk:
  - pengiriman email aktivasi setelah register
  - halaman pemberitahuan verifikasi email
  - link aktivasi email
  - kirim ulang email aktivasi
- Membatasi akses user ke area akun sampai email berhasil diverifikasi.
- Menyesuaikan template email aktivasi agar mengacu pada `resources/views/mail.html`.
- Memastikan fitur kirim ulang email aktivasi memiliki rate limiting agar tidak bisa digunakan untuk spam.

## Batasan Scope
- Tidak membuat sistem aktivasi akun custom dari nol.
- Tidak menambah tabel baru jika fitur bawaan Breeze dan kolom `email_verified_at` pada tabel `users` sudah mencukupi.
- Tidak mengubah struktur besar auth flow di luar kebutuhan aktivasi email.
- Tidak mengubah sistem login admin.
- Tidak membahas konfigurasi SMTP detail karena konfigurasi email sudah tersedia di file `.env`.
- Tidak menambah fitur OTP, approval manual admin, atau status akun tambahan di luar verifikasi email.

## Kondisi Existing Project
- Laravel Breeze sudah menyediakan route verifikasi email di `routes/auth.php`.
- Controller bawaan Breeze untuk verifikasi email sudah tersedia.
- Event `Registered` sudah dipanggil setelah user berhasil register.
- Model `User` sudah memiliki cast `email_verified_at`.
- Template email aktivasi tersedia di `resources/views/mail.html`.
- Rate limiting resend email sudah dapat memanfaatkan middleware throttle yang tersedia di route Breeze.

## Prinsip Implementasi
- Gunakan fitur email verification bawaan Laravel, bukan membuat flow baru.
- Aktifkan kontrak verifikasi email pada model `User` agar Breeze dapat mengirim email aktivasi.
- Gunakan middleware `verified` pada route user yang membutuhkan akun aktif.
- Pertahankan controller dan route Breeze yang sudah ada selama masih memenuhi kebutuhan.
- Email activation harus memakai signed URL dari Laravel agar link aktivasi aman dan memiliki masa berlaku.
- Tampilan email harus mengikuti struktur dan gaya dari `resources/views/mail.html`.
- Kirim ulang email aktivasi harus dibatasi dengan rate limiting agar tidak disalahgunakan.

## Arah Implementasi

### 1. Aktivasi Verifikasi Email User
- Pastikan model `User` mendukung fitur verifikasi email bawaan Laravel.
- Gunakan kolom `email_verified_at` sebagai penanda akun sudah aktif.
- User yang belum memiliki nilai `email_verified_at` dianggap belum aktif.

### 2. Alur Register
- Setelah register berhasil, sistem tetap membuat user baru seperti flow existing.
- Setelah user dibuat, sistem memicu event register agar Breeze mengirim email aktivasi.
- User diarahkan ke halaman pemberitahuan verifikasi email, bukan langsung memakai fitur akun utama.
- Jangan mengubah validasi register yang tidak berhubungan dengan aktivasi akun.

### 3. Pembatasan Akses Akun
- Route area user yang membutuhkan akun aktif harus dilindungi dengan middleware `verified`.
- User yang sudah login tetapi belum verifikasi email diarahkan ke halaman notice verifikasi email.
- User baru dapat mengakses dashboard dan fitur akun setelah aktivasi email berhasil.

### 4. Template Email Aktivasi
- Gunakan `resources/views/mail.html` sebagai acuan tampilan body email aktivasi.
- Pastikan template menerima data user dan URL aktivasi.
- CTA email harus mengarah ke signed verification URL dari Laravel.
- Isi email harus tetap fokus pada aktivasi akun dan tidak melebar ke promosi atau fitur lain.

### 5. Kirim Ulang Email Aktivasi
- Gunakan route/controller kirim ulang email verification dari Breeze.
- Pastikan resend email activation memiliki rate limiting.
- Jika user terlalu sering mengirim ulang email, sistem harus menahan request sesuai aturan throttle.
- Berikan feedback yang jelas ketika email aktivasi berhasil dikirim ulang.

### 6. Konfigurasi Email
- Gunakan konfigurasi SMTP yang sudah tersedia di `.env`.
- Jangan hardcode credential email di kode.
- Pastikan pengiriman email memakai konfigurasi mail Laravel yang sudah berjalan.

## Dampak Alur User
- User melakukan registrasi akun.
- Sistem membuat akun dan mengirim email aktivasi.
- User melihat halaman instruksi untuk cek email.
- User klik link aktivasi dari email.
- Sistem menandai `email_verified_at` pada user.
- User baru dapat masuk dan beraktivitas di area akun.
- Jika email belum diterima, user dapat kirim ulang email aktivasi dengan batas rate limiting.

## File yang Berpotensi Disesuaikan
- `app/Models/User.php`
- `routes/web.php`
- `routes/auth.php`
- `app/Http/Controllers/Auth/RegisteredUserController.php`
- `app/Http/Controllers/Auth/EmailVerificationNotificationController.php`
- `resources/views/auth/verify-email.blade.php`
- `resources/views/mail.html`

## Tahapan Implementasi

### Fase 1 - Review Fitur Breeze Existing
- Pastikan route verifikasi email, resend email, dan halaman notice sudah tersedia.
- Pastikan controller Breeze yang berkaitan dengan verifikasi email masih digunakan.
- Pastikan kolom `email_verified_at` tersedia pada tabel `users`.

### Fase 2 - Aktifkan Email Verification
- Aktifkan dukungan email verification pada model `User`.
- Pastikan event register tetap berjalan setelah user berhasil dibuat.
- Pastikan email aktivasi terkirim setelah registrasi.

### Fase 3 - Batasi Akses User
- Tentukan route user yang harus membutuhkan akun aktif.
- Tambahkan middleware verifikasi email pada route area akun.
- Pastikan user belum aktif diarahkan ke halaman verifikasi email.

### Fase 4 - Sesuaikan Email Activation
- Gunakan template `resources/views/mail.html` sebagai body email aktivasi.
- Pastikan data user dan URL aktivasi tersedia untuk template.
- Pastikan link aktivasi bekerja memakai signed URL Laravel.

### Fase 5 - Rate Limiting Resend
- Pastikan fitur kirim ulang email aktivasi memakai throttle.
- Tentukan batas request resend yang wajar agar tidak menjadi spam.
- Pastikan feedback resend tetap jelas untuk user.

### Fase 6 - Validasi Akhir
- Cek alur register sampai email aktivasi terkirim.
- Cek user belum verifikasi tidak dapat mengakses area akun.
- Cek link aktivasi mengaktifkan akun.
- Cek resend email dibatasi oleh rate limiting.
- Cek user yang sudah verifikasi dapat menggunakan akun normal.

## Kriteria Hasil
- User baru menerima email aktivasi setelah registrasi.
- Email aktivasi menggunakan template yang mengacu pada `resources/views/mail.html`.
- User yang belum aktivasi email tidak dapat mengakses area akun utama.
- User yang belum aktivasi diarahkan ke halaman notice verifikasi email.
- User dapat mengaktifkan akun melalui link aktivasi email.
- Kolom `email_verified_at` terisi setelah aktivasi berhasil.
- Fitur kirim ulang email aktivasi tersedia dan memiliki rate limiting.
- Sistem tetap menggunakan route, controller, model, dan mekanisme Laravel Breeze yang sudah tersedia.
- SMTP tetap memakai konfigurasi dari `.env` tanpa hardcode credential.

## Catatan Implementasi
- Kerjakan hanya sistem aktivasi akun user berbasis email.
- Jangan mengubah auth admin.
- Jangan membuat flow aktivasi custom jika Breeze sudah menyediakan mekanisme yang dibutuhkan.
- Jangan melewati scope dengan menambahkan OTP, approval admin, atau status akun tambahan.
- Instruksi ini sengaja high level agar dapat diimplementasikan oleh junior programmer atau AI model dengan biaya lebih rendah.
