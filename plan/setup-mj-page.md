# Plan Setup Matching Job Page

## Tujuan
- Menambahkan landing page publik untuk informasi kelas konsultasi matching job kerja di Jepang.
- Menyediakan halaman yang fokus pada penjelasan layanan, alur konsultasi, pilihan paket, dan ajakan kontak melalui WhatsApp.
- Menjaga nuansa visual tetap selaras dengan landing page utama yang sudah ada di `landing/main.blade.php`.

## Scope Fitur
- Tambahkan halaman baru pada route publik `/matching-job`.
- Route tersebut harus ditangani melalui `LandingController`.
- Tempatkan view halaman di `resources/views/landing/matching-job.blade.php`.
- Gunakan Tailwind CSS dengan pendekatan responsive dan prioritas mobile first.
- Arah visual harus clean, modern, dan masih terasa satu keluarga dengan halaman landing yang sudah ada.

## Arah Implementasi
- Pisahkan halaman matching job dari landing page utama agar tanggung jawab halaman tetap jelas.
- Gunakan method khusus pada `LandingController` untuk menampilkan halaman `/matching-job`, bukan menumpuk isi halaman ini ke method homepage yang sudah ada.
- Pertahankan penggunaan layout landing yang sama agar header, footer, dan pola visual tetap konsisten.

## Struktur Halaman

### 1. Jumbotron
- Jadikan jumbotron sebagai area pembuka utama yang langsung menjelaskan manfaat kelas konsultasi matching job.
- Sertakan visual model foto manusia agar halaman terasa lebih personal dan relevan dengan konteks karier.
- Pastikan jumbotron memiliki headline, subheadline, dan CTA utama yang jelas.

### 2. Section Informasi
- Sediakan template section konten yang dapat menampung beberapa paragraf informasi lengkap dengan judul.
- Section ini dipakai untuk menjelaskan gambaran program, manfaat, target peserta, atau nilai pembeda layanan.
- Susunan konten harus mudah dibaca di mobile dan tetap rapi saat melebar ke desktop.

### 3. Timeline
- Tambahkan section timeline untuk menggambarkan urutan proses atau tahapan konsultasi matching job.
- Timeline harus mudah dipahami secara visual dan tetap nyaman dibaca di layar kecil.
- Fokusnya adalah memberi gambaran alur, bukan detail teknis operasional.

### 4. Pricing
- Tambahkan section pricing berisi 3 paket.
- Masing-masing paket harus menampilkan:
  - nama paket
  - harga
  - daftar benefit dalam format checklist
- Susunan pricing perlu dibuat mudah dibandingkan dan tetap jelas saat dilihat dari perangkat mobile.

### 5. CTA WhatsApp
- Sediakan CTA button yang mengarah ke WhatsApp sebagai aksi utama konversi.
- CTA dapat ditempatkan di area hero dan/atau penutup halaman agar pengguna selalu memiliki jalur kontak yang jelas.
- Penempatan CTA harus terasa natural dan tidak mengganggu alur baca.

## Route dan Controller
- Tambahkan atau sesuaikan route `/matching-job` agar mengarah ke method khusus di `LandingController`.
- Method tersebut hanya bertanggung jawab menampilkan halaman matching job.
- Jangan campurkan kebutuhan halaman ini dengan logika listing lowongan pada homepage utama.

## View dan Styling
- Buat file view baru di `resources/views/landing/matching-job.blade.php`.
- Gunakan pola layout, spacing, tone warna, dan komponen visual yang serasi dengan `landing/main.blade.php`.
- Tailwind CSS digunakan sebagai fondasi styling dengan fokus pada:
  - mobile first
  - keterbacaan konten
  - komposisi section yang bersih
  - tampilan modern tanpa elemen berlebihan

## Prinsip Konten
- Konten harus diarahkan untuk membantu pengunjung memahami layanan dengan cepat.
- Setiap section perlu punya judul yang jelas dan isi yang langsung ke poin utama.
- Hindari struktur halaman yang terlalu padat atau terlalu banyak variasi komponen di luar kebutuhan scope ini.

## Kriteria Hasil
- Halaman `/matching-job` dapat diakses secara publik dari route yang benar.
- `LandingController` menangani halaman ini melalui method yang terpisah dari homepage utama.
- View tersedia di `landing/matching-job.blade.php`.
- Halaman memuat section:
  - jumbotron dengan model foto manusia
  - informasi berbasis judul dan paragraf
  - timeline
  - pricing 3 paket dengan benefit checklist
  - CTA button ke WhatsApp
- Tampilan responsive, mobile first, dan visualnya tetap sejalan dengan landing page utama.

## Batasan Scope
- Fokus plan ini hanya pada penambahan halaman landing matching job.
- Tidak membahas integrasi backend tambahan, form kompleks, dashboard admin, atau perubahan fitur di luar route/controller/view yang dibutuhkan untuk halaman ini.
- Instruksi tetap dijaga high level agar implementasi bisa dilanjutkan oleh junior programmer atau AI model dengan biaya lebih rendah.
