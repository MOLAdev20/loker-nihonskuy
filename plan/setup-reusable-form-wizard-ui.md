# Plan Setup Reusable Form Wizard UI

## Tujuan
- Menyusun rencana perubahan form wizard agar menjadi komponen reusable yang mudah dipanggil pada berbagai view Blade.
- Menyatukan perilaku state step, aturan akses antar step, dan pola navigasi tombol agar konsisten di seluruh alur pengisian profile user.
- Menjaga instruksi tetap high level, ringkas, dan cukup jelas untuk dikerjakan oleh junior programmer atau AI model dengan kemampuan terbatas.

## Ruang Lingkup
- Pembuatan komponen reusable untuk form wizard step.
- Penyelarasan pemakaian wizard pada halaman `user/profile-form.blade.php`, `user/education-history-form.blade.php`, dan `user/working-experience-form.blade.php`.
- Penetapan aturan state visual berdasarkan status selesai, aktif, dan terkunci.
- Penetapan aturan akses klik step dan perilaku tombol simpan, sebelumnya, dan selanjutnya.

## Prinsip Implementasi
- Jadikan wizard sebagai komponen terpisah yang cukup dipanggil dari view Blade yang membutuhkan.
- Pastikan komponen reusable menerima data step, status step, dan kontrol navigasi tanpa menanam logika berulang di setiap halaman.
- Pertahankan tampilan konsisten dengan dashboard user yang sudah ada.
- Fokus pada alur pengisian profile bertahap dan jangan memperluas scope ke fitur lain di luar wizard dan navigasi step.

## Target Penggunaan
- `user/profile-form.blade.php`
- `user/education-history-form.blade.php`
- `user/working-experience-form.blade.php`

## Struktur Komponen Wizard
### 1. Peran Komponen
- Komponen wizard bertugas merender daftar step, state visual, dan aturan interaksi dasar.
- Halaman pemanggil hanya perlu mengirim konfigurasi step dan status progres user.
- Hindari duplikasi array step, class state, dan aturan klik di setiap view.

### 2. Daftar Step
- Step 1: `Informasi Pribadi`
- Step 2: `Riwayat Pendidikan`
- Step 3: `Riwayat Pekerjaan`

### 3. Posisi Komponen
- Tempatkan wizard di atas section atau group utama konten form.
- Wizard harus menjadi bagian dari alur utama halaman, bukan elemen tambahan yang terpisah.

## Aturan State Visual
### 1. Step Belum Selesai
- Gunakan state nonaktif dengan indikator visual yang lebih lemah, misalnya outline slate.
- State ini menunjukkan data step belum memenuhi syarat selesai.

### 2. Step Sedang Dibuka tetapi Belum Selesai
- Gunakan indikator aktif yang menandai halaman sedang dibuka.
- Namun step ini tetap belum dianggap selesai sampai syarat datanya terpenuhi.

### 3. Step Sudah Selesai
- Gunakan indikator penuh hijau dengan teks atau angka putih.
- Jika user kembali membuka step lain, step yang sudah selesai tetap tampil aktif sebagai indikator progres yang sudah terpenuhi.
- Contohnya, jika riwayat pekerjaan sudah diisi lalu user sedang mereview data pribadi, step riwayat pekerjaan tetap tampil dalam state selesai penuh.

## Aturan Akses Step
### 1. Akses Step yang Sudah Terbuka
- User tetap bisa membuka kembali step yang sudah selesai atau step yang memang sudah terbuka untuk alurnya.

### 2. Blokir Step yang Belum Boleh Diakses
- Jika ada step sebelumnya yang belum selesai, step berikutnya harus dianggap terkunci.
- Klik pada step yang terkunci tidak boleh memindahkan user ke halaman tujuan.
- Secara perilaku, tautan dapat diarahkan ke `#` atau mekanisme lain yang setara untuk menolak perpindahan.

### 3. Aturan Dependensi Antar Step
- Step 2 hanya dapat diakses jika step 1 sudah selesai.
- Step 3 hanya dapat diakses jika step 1 dan step 2 sudah memenuhi syarat minimal yang ditetapkan.

## Aturan Status Selesai
### 1. Informasi Pribadi
- Step dianggap selesai jika data pribadi utama user sudah berhasil disimpan dan memenuhi kontrak data yang dibutuhkan.

### 2. Riwayat Pendidikan
- Step dianggap selesai jika user sudah memiliki minimal 1 data riwayat pendidikan.

### 3. Riwayat Pekerjaan
- Step dianggap selesai jika user sudah memiliki minimal 1 data riwayat pekerjaan.

## Aturan Tombol Navigasi
### 1. Halaman Informasi Pribadi
- Tombol simpan bertindak sebagai aksi simpan sekaligus melanjutkan user ke step 2.
- Setelah simpan berhasil, alur diarahkan ke halaman riwayat pendidikan.

### 2. Halaman Riwayat Pendidikan
- Sediakan tombol `Sebelumnya` dan `Selanjutnya`.
- Tombol `Sebelumnya` mengarah kembali ke step 1.
- Tombol `Selanjutnya` hanya aktif jika user sudah memasukkan minimal 1 data riwayat pendidikan.

### 3. Halaman Riwayat Pekerjaan
- Sediakan tombol `Sebelumnya` dan `Selanjutnya`.
- Tombol `Sebelumnya` mengarah kembali ke step 2.
- Tombol `Selanjutnya` hanya aktif jika user sudah memasukkan minimal 1 data riwayat pekerjaan.

## Rencana Arsitektur Data Wizard
- Siapkan satu sumber data progres yang dapat dipakai bersama oleh semua halaman step.
- Data progres minimal harus bisa menjawab tiga hal: step aktif saat ini, step mana yang selesai, dan step mana yang boleh diakses.
- Status progres harus dihitung dari data nyata user, bukan dari tampilan semata.

## Tahapan Implementasi
### Fase 1 - Penyatuan Kontrak Wizard
- Tetapkan struktur konfigurasi step yang akan dipakai bersama oleh seluruh halaman.
- Samakan definisi selesai, aktif, dan terkunci untuk setiap step.

### Fase 2 - Pembuatan Komponen Reusable
- Pindahkan markup wizard yang berulang ke komponen reusable.
- Pastikan komponen mudah dipanggil dan mudah menerima data status dari halaman pemanggil.

### Fase 3 - Integrasi ke Halaman Step
- Ganti implementasi wizard lama di halaman data pribadi, riwayat pendidikan, dan riwayat pekerjaan dengan komponen reusable.
- Pastikan ketiga halaman memakai sumber aturan yang sama.

### Fase 4 - Penyelarasan Navigasi Tombol
- Ubah perilaku tombol simpan dan tombol navigasi agar mendukung perpindahan antar step sesuai rule baru.
- Pastikan tombol selanjutnya pada step 2 dan 3 hanya aktif jika syarat minimal data sudah terpenuhi.

### Fase 5 - Finalisasi Akses Step
- Terapkan pembatasan akses untuk step yang belum boleh dibuka.
- Pastikan state wizard tetap akurat saat user berpindah antar halaman dan saat kembali mereview step sebelumnya.

## Kriteria Hasil
- Wizard step menjadi komponen reusable dan tidak lagi ditulis berulang di setiap view.
- `user/profile-form.blade.php`, `user/education-history-form.blade.php`, dan `user/working-experience-form.blade.php` memakai komponen wizard yang sama.
- Step yang sudah selesai tetap tampil penuh hijau meskipun user sedang membuka step lain.
- Step yang belum boleh diakses tidak dapat dibuka.
- Tombol simpan di data pribadi mengarahkan user ke step 2 setelah berhasil.
- Halaman riwayat pendidikan dan riwayat pekerjaan memiliki tombol sebelumnya dan selanjutnya.
- Tombol selanjutnya pada step 2 dan 3 hanya aktif jika user sudah memiliki minimal 1 data pada step tersebut.

## Catatan Implementasi
- Jangan memperluas pekerjaan ke perubahan desain besar di luar kebutuhan wizard reusable dan aturan navigasinya.
- Jangan menanam rule wizard secara terpisah di setiap halaman jika sudah bisa dipusatkan.
- Prioritaskan struktur yang mudah dipelihara, mudah dipanggil ulang, dan mudah diteruskan ke tahap implementasi coding berikutnya.
