# Plan Setup Resume Excel

## Tujuan
- Menyusun rencana pembuatan fitur export resume Excel berbasis data database dengan library `Laravel Excel`.
- Menyiapkan brief implementasi agar file Excel dapat diproses melalui route `/print-resume` dan langsung diunduh oleh user.
- Menjaga agar instruksi tetap high level, fokus, dan cukup jelas untuk dikerjakan oleh junior programmer atau AI model dengan kemampuan terbatas.

## Ruang Lingkup
- Integrasi library `SpartnerNL/Laravel-Excel`.
- Penyediaan route `/print-resume` sebagai pemicu generate dan download file Excel.
- Pengambilan data dari tabel `user_profile`, `user_education_history`, dan `user_working_experience`.
- Penyusunan layout sheet Excel sesuai struktur sel, merge, label, gambar, dan area data yang diminta.
- Penempatan data profile, riwayat pendidikan, dan riwayat pekerjaan ke posisi sheet yang sudah ditentukan.

## Prinsip Implementasi
- Gunakan pendekatan yang rapi dan terpisah antara route, controller pemicu export, dan class export agar flow mudah dirawat.
- Gunakan `Laravel Excel` sebagai library utama, bukan membuat file spreadsheet manual di luar library tersebut.
- Pastikan sumber data hanya mengambil data milik user yang sedang login.
- Fokus pada 1 file export resume sesuai format yang diminta, tanpa menambah fitur lain di luar scope.
- Pertahankan brief tetap high level; detail teknis kecil tidak perlu dijabarkan di dokumen plan ini.

## Arah Arsitektur
### 1. Route
- Sediakan route `GET /print-resume` untuk memproses dan mengunduh file resume Excel.
- Tempatkan route di area yang memerlukan autentikasi agar data resume tidak dapat diakses sembarang user.

### 2. Controller
- Gunakan controller khusus atau endpoint terpisah untuk menangani trigger export resume.
- Controller hanya mengorkestrasi pengambilan data user, memanggil class export, lalu mengembalikan response download.
- Hindari menaruh logika layout spreadsheet langsung di route.

### 3. Export Class
- Gunakan class export sebagai pusat penyusunan sheet Excel.
- Class export bertugas membentuk struktur sheet, mapping data, merge cell, styling dasar, penempatan gambar, dan penulisan nilai ke sel.
- Pisahkan logika pembentukan data dari logika pemanggilan HTTP agar lebih mudah diuji dan dirapikan.

## Sumber Data
### 1. User Profile
- Gunakan tabel `user_profile` sebagai sumber data identitas utama resume.
- Data profile mengisi blok informasi utama pada area `B5` sampai `G15`.
- Gunakan `profile_picture` sebagai kandidat sumber pas foto jika implementasi ingin mengisi area foto user, sedangkan `public/nihonskuy-cv.png` digunakan untuk gambar logo/template di area header sesuai brief.

### 2. Education History
- Gunakan tabel `user_education_history` berdasarkan `user_id`.
- Data pendidikan mengisi blok `学歴` mulai header di row 17 dan berlanjut ke bawah sesuai jumlah data.

### 3. Working Experience
- Gunakan tabel `user_working_experience` berdasarkan `user_id`.
- Data pekerjaan mengisi blok `職歴` mulai area setelah section pendidikan, sesuai jumlah data yang tersedia.

## Struktur Laporan Excel
### 1. Header Atas
- Biarkan `A1:I1` dan `A2:I2` kosong.
- Merge `E3:F3` untuk judul `履歴書` dengan ukuran 16pt, rata tengah, dan middle align.
- Merge `H3:I3` untuk gambar `public/nihonskuy-cv.png` dengan ukuran yang disesuaikan agar proporsional.
- Tempatkan label `Tanggal :` di `G4` dengan rata kanan.
- Merge `H4:I4` untuk tanggal saat ini dengan center dan middle align.

### 2. Blok Informasi Utama
- Isi label tetap pada kolom `B5:B15` dan `E5:E14` sesuai urutan yang diminta.
- Merge `C:D` per baris untuk nilai data profile sisi kiri.
- Merge `F:G` per baris untuk nilai data profile sisi kanan.
- Merge `H5:I15` sebagai area kotak besar pas foto.

### 3. Blok Pendidikan
- Merge `B16:I16` untuk judul section `学歴`.
- Gunakan row header di `17` lalu isi data pendidikan dari row berikutnya secara berurutan.
- Pertahankan pola merge pada kolom yang diminta, terutama `B:C` dan `H:I`.

### 4. Blok Pekerjaan
- Merge `B21:I21` untuk judul section `職歴` jika tata letak memang dipertahankan tetap.
- Gunakan row header di `22` lalu isi data pekerjaan dari row berikutnya secara berurutan.
- Pertahankan pola merge pada kolom `B:C` untuk nama perusahaan.

## Mapping Data Tingkat Tinggi
### 1. Mapping User Profile
- Isi data profile ke posisi sel yang sudah ditentukan, termasuk nilai turunan seperti umur dari `birth_date`.
- Gunakan formatting yang konsisten untuk field tanggal agar tampilan resume mudah dibaca.
- Biarkan sel yang memang diminta kosong tetap kosong, termasuk `F15:G15`.

### 2. Mapping Education History
- Ambil seluruh riwayat pendidikan user dan urutkan secara konsisten.
- Map `education`, `institution`, `location`, `date_of_entry`, `date_of_graduation`, dan `status` ke blok `学歴`.
- Jika jumlah data lebih dari satu, lanjutkan pengisian ke row berikutnya tanpa merusak struktur kolom.

### 3. Mapping Working Experience
- Ambil seluruh riwayat pekerjaan user dan urutkan secara konsisten.
- Map `company_name`, `field_of_work`, `location`, `date_of_join`, `date_of_resign`, `employment_status`, dan `visa_type` ke blok `職歴`.
- Jika jumlah data lebih dari satu, lanjutkan pengisian ke row berikutnya tanpa merusak struktur kolom.

## Aturan Formatting
- Gunakan merge cell hanya pada area yang memang dibutuhkan oleh brief.
- Terapkan alignment, ukuran font, dan peletakan gambar pada level yang cukup untuk meniru layout resume yang diminta.
- Pastikan text Jepang, label, dan nilai data tetap terbaca rapi saat file dibuka di Excel.
- Gunakan formatting tanggal yang konsisten antara data profile, pendidikan, dan pekerjaan.

## Rencana Alur Export
### 1. Trigger
- User mengakses route `/print-resume`.
- Sistem mengambil seluruh data profile, education history, dan working experience milik user yang sedang login.

### 2. Penyusunan Sheet
- Sistem membangun satu sheet resume sesuai struktur sel yang telah ditentukan.
- Sistem menempatkan header, label tetap, merge cell, nilai data, dan gambar template.

### 3. Download
- Setelah sheet selesai dibentuk, sistem langsung mengirim file sebagai download response ke browser user.

## Dependency Penting
- Library `Laravel Excel` harus terpasang dan terkonfigurasi dengan benar.
- File `public/nihonskuy-cv.png` harus tersedia; saat ini aset tersebut sudah ada.
- Tabel `user_working_experience` harus benar-benar memiliki kolom `company_name` agar mapping blok `職歴` sesuai brief.
- Perlu penyelarasan aturan posisi blok `職歴` jika data `学歴` bersifat lebih dari beberapa baris.
- Area pas foto user perlu disepakati: apakah hanya berupa kotak kosong, atau benar-benar diisi dari `user_profile.profile_picture`.

## Risiko dan Penyelarasan Sebelum Implementasi
- Brief menempatkan section `職歴` di row tetap `21`, sementara data `学歴` bersifat dinamis. Sebelum coding dimulai, perlu diputuskan apakah row `21` tetap dipertahankan dengan batas maksimal baris pendidikan, atau section pekerjaan bergeser dinamis mengikuti jumlah data pendidikan.
- Perlu disepakati format tampilan untuk nilai enum atau status agar output resume tetap ramah dibaca dan tidak menampilkan kode internal mentah.
- Perlu dipastikan fallback untuk data nullable seperti tanggal visa, tanggal resign, tanggal lulus, atau foto profile agar export tidak gagal saat data belum lengkap.

## Tahapan Implementasi
### Fase 1 - Persiapan Fondasi
- Pasang dan siapkan `Laravel Excel`.
- Siapkan route download dan titik orkestrasi export.

### Fase 2 - Penyelarasan Mapping Data
- Cocokkan seluruh field dari tiga tabel dengan kebutuhan layout resume.
- Tegaskan aturan nilai turunan seperti umur dan tanggal saat ini.
- Finalkan keputusan posisi blok `職歴` terhadap jumlah row `学歴`.

### Fase 3 - Penyusunan Layout Sheet
- Bentuk struktur merge cell, label tetap, alignment, ukuran font, dan area gambar.
- Pastikan layout utama resume sudah sesuai sebelum semua data dinamis dipasang.

### Fase 4 - Integrasi Data Dinamis
- Isi data profile, education history, dan working experience ke area masing-masing.
- Pastikan data multi-row tidak merusak struktur sheet.

### Fase 5 - Finalisasi Download
- Rapikan nama file export, pengalaman download, dan validasi hasil akhir saat dibuka di Excel.

## Kriteria Hasil
- Route `/print-resume` tersedia dan dapat memicu download file Excel.
- File Excel dibuat menggunakan `Laravel Excel`.
- Data resume mengambil sumber dari `user_profile`, `user_education_history`, dan `user_working_experience`.
- Struktur sheet mengikuti layout sel, merge, label, dan area gambar sesuai brief.
- Judul `履歴書`, tanggal saat ini, dan gambar header tampil pada posisi yang diminta.
- Data profile tampil di blok identitas utama.
- Data pendidikan tampil di blok `学歴`.
- Data pekerjaan tampil di blok `職歴`.
- File hasil export dapat dibuka dengan baik dan tetap terbaca rapi.

## Catatan Implementasi
- Jangan menambah fitur filter, export massal, multi-sheet, atau dashboard report lain di luar scope ini.
- Jangan memperluas scope ke pembuatan template PDF atau format dokumen lain.
- Fokus pada 1 flow download resume Excel per user dengan struktur yang sudah ditentukan.
