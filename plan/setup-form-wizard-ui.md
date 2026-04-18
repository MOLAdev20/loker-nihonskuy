# Plan Setup Form Wizard UI

## Tujuan
- Menyusun rencana penambahan komponen form wizard berbentuk step angka pada area form user.
- Menempatkan wizard di atas section atau group komponen form input agar alur pengisian terasa berurutan.
- Menjaga instruksi tetap high level, ringkas, dan aman untuk dikerjakan oleh junior programmer atau AI model dengan kemampuan terbatas.

## Ruang Lingkup
- Penambahan UI wizard step di halaman form terkait.
- Penyesuaian urutan step dan tautan antar halaman form.
- Penyediaan route placeholder yang belum ada di `web.php`.
- Penetapan aturan state visual step berdasarkan kondisi aktif dan status terisi.

## Prinsip Implementasi
- Fokus hanya pada komponen wizard step dan route pendukungnya.
- Jangan menambah controller, model, view baru, atau business logic di luar kebutuhan wizard.
- Pertahankan gaya implementasi tetap sederhana, mudah dibaca, dan konsisten dengan layout dashboard user yang sudah ada.
- Pastikan wizard dapat dipakai ulang pada halaman form yang termasuk dalam alur yang sama.

## Struktur Wizard
### 1. Posisi Komponen
- Tempatkan wizard step di atas section atau group komponen form input.
- Wizard harus tampil sebagai bagian dari header area form, bukan sebagai elemen terpisah yang mengganggu isi halaman.

### 2. Daftar Step
- Step 1: `Informasi Pribadi` mengarah ke `/profile`.
- Step 2: `Riwayat Pendidikan` mengarah ke `/education-history`.
- Step 3: `Riwayat Pekerjaan` mengarah ke `/working-experience`.

### 3. Bentuk Komponen
- Setiap step menggunakan lingkaran ber-outline dengan angka di tengah.
- Label step ditampilkan jelas agar user memahami isi tiap tahap.
- Step dapat diklik untuk berpindah ke route masing-masing.

## Aturan State Visual
### 1. Step Belum Diisi
- Gunakan warna slate atau warna indikator nonaktif yang setara untuk garis lingkaran.
- Angka dan label tetap mudah dibaca, tetapi tidak lebih dominan dari step aktif.

### 2. Step Aktif tetapi Belum Diisi
- Gunakan warna hijau pada garis lingkaran dan angka.
- State ini menunjukkan halaman sedang dibuka, tetapi data tahap tersebut belum dianggap selesai.

### 3. Step Sudah Diisi
- Gunakan lingkaran hijau penuh.
- Gunakan angka putih agar kontras dan mudah dikenali sebagai status selesai.

## Rencana Route
- Pastikan wizard memakai route yang konsisten untuk tiga tahap pengisian.
- Sediakan route placeholder untuk `/education-history` dan `/working-experience` di `web.php`.
- Jangan menambahkan controller, model, view, atau logic lanjutan untuk dua route placeholder tersebut pada scope ini.
- Jika implementasi saat ini masih memakai route profile lama, selaraskan tujuan wizard ke jalur `/*` tanpa memperluas scope pekerjaan.

## Tahapan Implementasi
### Fase 1 - Penyelarasan Struktur Navigasi
- Tetapkan tiga step wizard dan urutan finalnya.
- Pastikan setiap step memiliki label dan tujuan route yang jelas.

### Fase 2 - Pemasangan Komponen Wizard
- Tambahkan komponen wizard di atas group form input pada halaman terkait.
- Pastikan komponen cukup fleksibel untuk dipakai ulang di halaman step lain dalam alur yang sama.

### Fase 3 - Penerapan State Visual
- Terapkan pembeda visual untuk state belum diisi, aktif, dan selesai.
- Jaga konsistensi warna dan keterbacaan agar user mudah memahami progres.

### Fase 4 - Penyediaan Route Placeholder
- Tambahkan route yang belum tersedia di `web.php`.
- Batasi perubahan hanya pada definisi route agar pekerjaan tetap sesuai scope.

## Kriteria Hasil
- Wizard step tampil di atas section atau group form input.
- Wizard terdiri dari 3 step: informasi pribadi, riwayat pendidikan, dan riwayat pekerjaan.
- Setiap step dapat diklik dan mengarah ke route yang sudah ditentukan.
- State visual step membedakan kondisi belum diisi, aktif, dan sudah diisi.
- Route `/education-history` dan `/working-experience` sudah disediakan di `web.php` sebagai placeholder.
- Tidak ada penambahan controller, model, view, atau business logic di luar scope instruksi ini.

## Catatan Implementasi
- Jangan memperluas pekerjaan ke validasi data, penyimpanan data, atau indikator progress berbasis business logic yang kompleks.
- Jangan mengubah alur form selain kebutuhan penempatan wizard dan penyediaan route placeholder.
- Prioritaskan struktur yang mudah diimplementasikan dan mudah diteruskan ke tahap coding berikutnya.
