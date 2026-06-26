# PRD Add Jikoshoukai YouTube Field

## Tujuan
- Menambahkan fitur input link YouTube untuk video jikoshoukai atau perkenalan diri kandidat.
- Menampilkan thumbnail atau embed YouTube pada halaman detail kandidat jika user sudah menyimpan link jikoshoukai.
- Menjaga implementasi tetap mengikuti pola halaman profil kandidat yang sudah ada di `resources/views/user/profile.blade.php`.
- Memberikan arahan high level untuk Junior FrontEnd Engineer atau AI model murah agar implementasi tidak melewati scope.

## Latar Belakang
- Halaman detail kandidat sudah menampilkan data profil kandidat.
- Kolom database untuk link jikoshoukai sudah tersedia.
- Migration `2026_06_25_081706_add_jikoshoukai_column_in_user_profile.php` sudah dibuat dan dijalankan.
- Nama kolom yang harus digunakan adalah `jikoshoukai` pada tabel `user_profile`.

## Ruang Lingkup
- Menambahkan field input link YouTube jikoshoukai di halaman detail kandidat `resources/views/user/profile.blade.php`.
- Menampilkan nilai link existing jika user sudah pernah mengisi link jikoshoukai.
- Menyimpan link YouTube ke kolom `jikoshoukai` pada tabel `user_profile`.
- Menampilkan thumbnail atau embed YouTube dari link yang sudah tersimpan.
- Menambahkan validasi sederhana agar input berupa link YouTube yang valid.
- Menjaga UI tetap konsisten dengan layout dan komponen profil kandidat yang sudah ada.

## Di Luar Scope
- Jangan membuat migration baru.
- Jangan mengganti nama kolom `jikoshoukai`.
- Jangan membuat fitur upload file video.
- Jangan menyimpan file video ke server.
- Jangan membuat fitur admin baru untuk mengelola jikoshoukai.
- Jangan membuat halaman baru khusus jikoshoukai.
- Jangan mengubah flow besar profil, pendidikan, pengalaman kerja, dokumen, atau dashboard user.
- Jangan membuat redesign halaman detail kandidat.

## Prinsip Implementasi
- Gunakan kolom existing `user_profile.jikoshoukai`.
- Ikuti pola controller, request validation, route, flash message, dan view yang sudah digunakan pada fitur profil user.
- Field input cukup berupa input text atau URL untuk link YouTube.
- Jika profil sudah memiliki link jikoshoukai, tampilkan link tersebut sebagai nilai awal field.
- Jika link jikoshoukai tersedia, tampilkan thumbnail atau embed YouTube pada area yang mudah dilihat user.
- Jika link belum tersedia, tampilkan empty state sederhana atau area input saja sesuai pola halaman existing.
- Jangan menambah abstraction baru kecuali memang sudah menjadi pola existing di halaman profil.

## Mekanisme Input
- User membuka halaman detail kandidat di `resources/views/user/profile.blade.php`.
- User melihat field input link YouTube jikoshoukai.
- User mengisi atau mengubah link YouTube.
- User menyimpan perubahan melalui mekanisme form profil yang paling konsisten dengan flow existing.
- Sistem memvalidasi input.
- Jika validasi berhasil, sistem menyimpan link ke kolom `jikoshoukai`.
- Setelah berhasil disimpan, halaman menampilkan feedback sukses sesuai pola existing.

## Mekanisme Tampilan Thumbnail
- Jika `jikoshoukai` kosong, jangan tampilkan thumbnail video.
- Jika `jikoshoukai` berisi link YouTube yang valid, tampilkan thumbnail atau embed video dari link tersebut.
- Thumbnail atau embed harus berada dekat dengan field input agar user memahami hubungan antara input dan preview.
- Jika implementasi memilih thumbnail, pastikan thumbnail dapat diklik untuk membuka video.
- Jika implementasi memilih embed, pastikan video dapat diputar dari halaman tanpa merusak layout.
- Tampilan harus tetap responsif di desktop dan mobile.

## Validasi
- Field `jikoshoukai` boleh kosong jika user belum ingin menambahkan video.
- Jika diisi, nilai harus berupa URL YouTube yang valid.
- Terima format YouTube umum seperti:
  - `https://www.youtube.com/watch?v=...`
  - `https://youtu.be/...`
  - `https://www.youtube.com/embed/...`
  - `https://www.youtube.com/shorts/...`
- Jika input tidak valid, tampilkan feedback error menggunakan pola error form existing.
- Jangan menerima URL dari platform lain untuk scope ini.

## Arah Perubahan

### 1. Database
- Gunakan migration existing `2026_06_25_081706_add_jikoshoukai_column_in_user_profile.php`.
- Gunakan kolom `jikoshoukai` pada tabel `user_profile`.
- Jangan membuat migration tambahan untuk requirement ini.

### 2. Model dan Data Flow
- Pastikan model profil user dapat membaca dan menyimpan kolom `jikoshoukai`.
- Jika model menggunakan mass assignment, pastikan `jikoshoukai` didukung.
- Jika dibutuhkan, tambahkan helper sederhana untuk mengubah link YouTube menjadi URL thumbnail atau embed.
- Jaga helper tetap sederhana dan khusus untuk kebutuhan link YouTube.

### 3. Controller dan Route
- Gunakan flow penyimpanan profil yang paling sesuai dengan arsitektur existing.
- Jika halaman profil sudah memiliki endpoint update yang relevan, tambahkan field ini ke flow tersebut.
- Jika lebih konsisten memakai endpoint kecil terpisah, buat endpoint khusus dengan naming yang mengikuti pola route user existing.
- Pastikan hanya user login yang dapat menyimpan link jikoshoukai miliknya sendiri.

### 4. View Profil Kandidat
- Tambahkan field input pada `resources/views/user/profile.blade.php`.
- Tempatkan field pada bagian detail kandidat yang relevan dengan profil atau media perkenalan diri.
- Tampilkan value existing dari `jikoshoukai`.
- Tampilkan thumbnail atau embed jika link sudah ada.
- Gunakan class, spacing, card, tombol, dan feedback yang konsisten dengan halaman tersebut.

## Kriteria Hasil
- Field input link YouTube jikoshoukai tampil di halaman detail kandidat.
- Field menampilkan nilai existing jika user sudah pernah menyimpan link.
- User dapat menyimpan link YouTube ke kolom `jikoshoukai`.
- Input kosong tetap diperbolehkan jika user belum ingin menambahkan video.
- Input selain link YouTube valid ditolak dengan pesan error yang jelas.
- Jika link valid sudah tersimpan, thumbnail atau embed YouTube tampil di halaman profil.
- Tampilan tetap responsif dan konsisten dengan UI profil existing.
- Tidak ada migration baru.
- Tidak ada fitur upload video file.
- Tidak ada perubahan besar di luar scope jikoshoukai.

## Catatan Untuk Implementor
- Kerjakan hanya scope field link YouTube jikoshoukai.
- Jangan mengubah struktur besar halaman profil.
- Jangan menambah fitur hapus, upload video, atau multi video kecuali ada instruksi baru.
- Jangan mengubah nama kolom database.
- Ikuti pola code existing sebelum menambahkan pola baru.
- Pastikan implementasi bisa diuji minimal dengan skenario: kosong, link YouTube valid, dan link non-YouTube.
