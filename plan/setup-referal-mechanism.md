# Plan Setup Referal Mechanism

## Tujuan
- Menyusun rencana penambahan mekanisme kode referal pada proses registrasi akun baru.
- Memastikan user baru dapat memasukkan kode referal saat mendaftar.
- Memastikan pemilik kode referal memperoleh bonus insentif ketika ada akun baru yang berhasil mendaftar menggunakan kode referalnya.
- Menjaga dokumen tetap high level, ringkas, dan mudah diimplementasikan oleh junior programmer atau AI model dengan kemampuan terbatas.

## Ruang Lingkup
- Penambahan kolom `ref_code` pada tabel `users`.
- Penambahan input kode referal pada halaman registrasi.
- Pembuatan pengecekan kode referal berbasis Ajax dengan sumber data dari `referal.json`.
- Penambahan indikator visual valid dan tidak valid pada field input referal.
- Penambahan teks bantuan formal di bawah field input sesuai hasil pengecekan.
- Penyesuaian alur registrasi agar kode referal yang valid dapat ikut diproses untuk kebutuhan bonus insentif.

## Prinsip Implementasi
- Fokus hanya pada kebutuhan yang tertulis di brief dan jangan menambah fitur lain di luar scope.
- Pertahankan alur registrasi yang sudah ada; cukup sisipkan mekanisme referal pada titik yang relevan.
- Gunakan sumber pengecekan kode referal dari `public/referal.json` sesuai instruksi.
- Jadikan `ref_code` sebagai field opsional agar registrasi tetap bisa dilanjutkan tanpa kode referal.
- Tampilkan feedback validasi yang jelas, formal, dan mudah dipahami user.
- Hindari redesign halaman registrasi; perubahan UI cukup pada penambahan field dan state validasinya.

## Arah Perubahan
### 1. Database
- Buat migration `add_ref_code_in_users`.
- Tambahkan kolom `ref_code` pada tabel `users`.
- Gunakan tipe `string` dengan panjang `12` dan status `nullable`.
- Pastikan migration hanya menambah kolom yang dibutuhkan tanpa mengubah struktur lain pada tabel `users`.

### 2. Form Registrasi
- Tambahkan field input kode referal pada view `auth/register.blade.php`.
- Tempatkan field baru di bawah input `Konfirmasi Kata Sandi` sesuai brief.
- Perlakukan field ini sebagai input opsional.
- Sediakan area kecil di bawah field untuk menampilkan status hasil pengecekan kode referal.

### 3. Pengecekan Ajax
- Tambahkan mekanisme pengecekan kode referal secara asynchronous saat user mengisi field referal.
- Gunakan `referal.json` sebagai sumber data untuk mengecek apakah kode tersedia atau tidak.
- Jika kode tersedia, tampilkan indikator border hijau pada field input.
- Jika kode tidak tersedia, tampilkan indikator border merah pada field input.
- Tampilkan pesan kecil berbahasa Indonesia formal yang sesuai dengan status valid atau tidak valid.

### 4. Alur Registrasi dan Insentif
- Pastikan kode referal yang sudah lolos pengecekan dapat ikut terbaca dalam alur registrasi.
- Saat registrasi berhasil menggunakan kode referal yang valid, alur sistem harus dapat menandai bahwa pemilik kode referal berhak menerima bonus insentif.
- Mekanisme pemberian bonus mengikuti kebutuhan bisnis yang berlaku tanpa memperluas scope ke fitur tambahan lain.

## Dampak Alur Data
### 1. Input
- User baru dapat mengisi kode referal saat mendaftar, tetapi tetap bisa melanjutkan registrasi jika field dibiarkan kosong.
- User memperoleh feedback langsung mengenai status kode yang dimasukkan.

### 2. Validasi
- Sistem mengecek kode referal ke `referal.json` melalui Ajax.
- Hasil validasi langsung memengaruhi tampilan border field dan teks bantuan di bawahnya.

### 3. Proses Registrasi
- Jika kode referal valid, data tersebut ikut diproses saat akun baru dibuat.
- Jika field kosong, registrasi tetap berjalan normal.
- Jika kode tidak valid, alur harus diarahkan agar tidak menganggap kode tersebut sebagai referal yang sah.

### 4. Insentif
- Pendaftaran yang berhasil dengan kode referal valid menjadi dasar pemberian bonus insentif kepada pemilik kode.
- Pemberian manfaat ini hanya berlaku untuk kode yang tersedia dan diakui sistem.

## Tahapan Implementasi
### Fase 1 - Penyesuaian Database
- Buat migration `add_ref_code_in_users`.
- Tambahkan kolom `ref_code` sebagai field opsional di tabel `users`.

### Fase 2 - Penyesuaian Form Registrasi
- Tambahkan input kode referal di halaman `auth/register.blade.php`.
- Tempatkan field sesuai posisi yang diminta dan sediakan area feedback di bawahnya.

### Fase 3 - Pengecekan Ajax
- Hubungkan field referal dengan mekanisme pengecekan asynchronous ke sumber data `referal.json`.
- Tampilkan state valid dan tidak valid melalui border field serta teks bantuan formal.

### Fase 4 - Integrasi Alur Registrasi
- Pastikan hasil pengecekan kode referal terhubung ke proses submit registrasi.
- Pastikan kode valid dapat dipakai sebagai dasar proses bonus insentif.

### Fase 5 - Finalisasi
- Cek konsistensi field input, feedback validasi, proses registrasi, dan pengenalan kode referal valid.
- Pastikan perubahan tetap terbatas pada mekanisme referal sesuai brief.

## Kriteria Hasil
- Tabel `users` memiliki kolom `ref_code` bertipe `string(12)` dan `nullable`.
- Halaman `auth/register.blade.php` memiliki field input kode referal di bawah `Konfirmasi Kata Sandi`.
- Field referal dapat melakukan pengecekan Ajax terhadap `referal.json`.
- Kode referal yang tersedia menampilkan border hijau dan pesan formal yang sesuai.
- Kode referal yang tidak tersedia menampilkan border merah dan pesan formal yang sesuai.
- Registrasi tetap dapat dilakukan tanpa mengisi kode referal.
- Registrasi yang menggunakan kode referal valid dapat menjadi dasar pemberian bonus insentif kepada pemilik kode.

## Catatan Implementasi
- Jangan memperluas scope ke redesign halaman registrasi, perubahan auth flow besar, atau sistem reward yang lebih kompleks.
- Jangan mengganti sumber data pengecekan referal ke tempat lain selain `referal.json`.
- Fokus pada empat area utama: migration database, input registrasi, validasi Ajax, dan keterhubungan kode valid dengan bonus insentif.
