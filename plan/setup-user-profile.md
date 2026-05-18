# Plan Show Profile User Dashboard

## Tujuan
- Mengubah tampilan konten pada `resources/views/user/profile.blade.php` agar halaman dashboard user menampilkan detail data yang sudah diisi user.
- Data yang ditampilkan mencakup data pribadi, riwayat pendidikan, dan riwayat pengalaman kerja.
- Halaman ini menjadi ringkasan utama profil user sebelum data digunakan untuk kebutuhan CV dan proses ke perusahaan Jepang.

## Scope Fitur
- Fokus perubahan berada pada bagian konten view `resources/views/user/profile.blade.php`.
- Gunakan Tailwind CSS dan pertahankan layout dashboard user yang sudah ada.
- Gunakan route `/dashboard` yang sudah berada di dalam route group user/auth.
- Gunakan `App\Http\Controllers\User\ProfileController@showProfile` sebagai sumber data halaman.
- Gunakan model yang sudah tersedia untuk mengambil data:
  - `user_profile`
  - `user_education_history`
  - `user_working_experience`

## Arah Implementasi
- Controller `showProfile` perlu menyiapkan data profile, education histories, dan work experiences milik user yang sedang login.
- View hanya bertanggung jawab untuk menampilkan data yang sudah dikirim controller.
- Hindari query langsung di Blade.
- Gunakan naming camelCase untuk variable, method, dan data yang dikirim ke view.

## Layout Halaman

### Kondisi User Sudah Mengisi Profile
- Gunakan layout grid 6 kolom pada desktop.
- Area grid 1 sampai 2 digunakan untuk foto profile user.
- Area grid 3 sampai 6 digunakan untuk stack card informasi.
- Pada mobile, layout turun menjadi satu kolom agar tetap nyaman dibaca.

### Area Foto Profile
- Tampilkan foto profile dari data `user_profile`.
- Jika foto belum tersedia, tampilkan fallback visual yang rapi dan tetap konsisten dengan dashboard.
- Area foto tidak perlu memuat informasi berlebihan; fokusnya sebagai identitas visual user.

### Stack 1: Card Informasi Pribadi
- Tampilkan seluruh detail informasi pribadi dari table `user_profile`.
- Card ini menjadi card utama di area kanan.
- Letakkan tombol `Download CV` di pojok kanan atas card.
- Tombol `Download CV` harus mengarah ke `/print-resume` atau route yang sudah tersedia untuk print resume.
- Informasi pribadi sebaiknya ditampilkan dalam struktur yang mudah dipindai, misalnya daftar label dan value.

### Stack 2: Card Riwayat Pendidikan
- Tampilkan seluruh data pendidikan user dari table `user_education_history`.
- Jika ada lebih dari satu riwayat pendidikan, tampilkan semuanya dalam daftar yang rapi.
- Jika data pendidikan kosong, tampilkan placeholder singkat agar halaman tetap stabil.

### Stack 3: Card Riwayat Pengalaman Kerja
- Tampilkan seluruh data pengalaman kerja user dari table `user_working_experience`.
- Jika ada lebih dari satu pengalaman kerja, tampilkan semuanya dalam daftar yang rapi.
- Jika data pengalaman kerja kosong, tampilkan placeholder singkat agar halaman tetap stabil.

## Empty State
- Jika user belum menginput data minimal profile, tampilkan layout full grid.
- Gunakan satu card utama dengan header:
  - `Isi Data profile anda`
- Gunakan sub header:
  - `Data profil membantu kami membuat CV dan memproses anda ke pihak perusahaan Jepang`
- Empty state harus memberi arah yang jelas agar user memahami bahwa mereka perlu mengisi data profile.
- Jika sudah ada route/form pengisian profile, card boleh menyediakan CTA menuju form tersebut, selama tidak keluar dari scope halaman profile.

## Route dan Controller
- Route dashboard tetap menggunakan `/dashboard`.
- Route tetap mengarah ke `ProfileController@showProfile`.
- Controller bertanggung jawab mengambil data user login dan relasi/data pendukung yang dibutuhkan.
- Jika data profile belum ada, controller tetap mengirim data kosong dengan aman agar view bisa menampilkan empty state.

## Prinsip UI
- Gunakan Tailwind CSS dengan styling yang konsisten dengan dashboard user.
- Gunakan card untuk tiga kelompok data utama:
  - informasi pribadi
  - riwayat pendidikan
  - pengalaman kerja
- Prioritaskan keterbacaan, spacing yang konsisten, dan tampilan yang rapi di mobile.
- Hindari komponen interaktif tambahan di luar kebutuhan menampilkan data dan tombol download CV.

## Kriteria Hasil
- Halaman `/dashboard` menampilkan data profile user yang sedang login.
- Jika profile tersedia, halaman memiliki layout grid 6 dengan foto profile di kiri dan stack card di kanan.
- Card informasi pribadi menampilkan tombol `Download CV` di pojok kanan atas.
- Riwayat pendidikan dan pengalaman kerja tampil lengkap berdasarkan data user.
- Jika profile belum tersedia, halaman menampilkan empty state full grid sesuai teks yang ditentukan.
- Tidak ada query data langsung di Blade.
- Naming variable dan method tetap menggunakan camelCase.

## Batasan Scope
- Tidak membuat migration baru.
- Tidak menambah fitur edit data dari halaman ini.
- Tidak mengubah struktur layout dashboard utama di luar bagian konten `profile.blade.php`.
- Tidak mengubah flow pembuatan CV atau logic download CV.
