# PRD Add Matching Job Class Detail Pages

## Tujuan
- Membuat 3 halaman detail program Matching Job yang menjelaskan masing-masing program secara lebih fokus.
- Setiap halaman harus menampilkan informasi program, manfaat utama, dan CTA untuk menghubungi admin melalui WhatsApp.
- Halaman yang dibuat adalah:
  - Career Education
  - Matching Job
  - Full Bundling
- Dokumen ini dibuat sebagai arahan high level untuk Junior FrontEnd Engineer atau AI model dengan kemampuan terbatas. Jangan mengerjakan hal di luar scope yang tertulis di dokumen ini.

## Latar Belakang
- Landing page utama Matching Job sudah tersedia dan dapat dijadikan referensi visual.
- Route, controller, dan view awal untuk 3 halaman detail program sudah disiapkan.
- Implementasi berikutnya hanya perlu melengkapi tampilan dan konten halaman detail berdasarkan pola halaman public yang sudah ada.

## Route Halaman
- Career Education: `/matching-job/education-program`
- Matching Job: `/matching-job/basic-program`
- Full Bundling: `/matching-job/full-program`

## File Acuan
- Controller: `app/Http/Controllers/MatchingJobLandingController.php`
- Layout utama public page: `resources/views/layouts/landing.blade.php`
- Referensi halaman Matching Job utama: `resources/views/landing/matching-job/main.blade.php`
- View Career Education: `resources/views/landing/matching-job/education.blade.php`
- View Matching Job: `resources/views/landing/matching-job/basic.blade.php`
- View Full Bundling: `resources/views/landing/matching-job/full.blade.php`

## Scope Fitur
- Lengkapi 3 view halaman detail program yang sudah tersedia.
- Pastikan setiap view menggunakan Blade base layout public yang sama dengan halaman Matching Job utama.
- Gunakan Tailwind CSS untuk styling.
- Tambahkan jumbotron pada setiap halaman dengan layout yang mengikuti jumbotron di halaman Matching Job utama.
- Pindahkan atau gunakan kembali section rundown dari halaman Matching Job utama ke ketiga halaman detail program.
- Tambahkan CTA WhatsApp pada setiap halaman agar user dapat membeli atau bertanya seputar program.

## Konten Program
### 1. Career Education
- Deskripsikan sebagai program edukasi karir yang membantu peserta mempersiapkan, memperbaiki, dan meningkatkan peluang diterima kerja di Jepang.
- Fokus komunikasi halaman ini adalah persiapan dan edukasi sebelum peserta aktif mencari kerja.
- CTA diarahkan untuk konsultasi atau pembelian program Career Education.

### 2. Matching Job
- Deskripsikan sebagai program pencocokan karir untuk peserta yang sudah merasa siap kerja di Jepang.
- Fokus komunikasi halaman ini adalah bantuan pencocokan kerja, konsultasi TSK, dan dukungan proses menuju pekerjaan.
- CTA diarahkan untuk konsultasi atau pembelian program Matching Job.

### 3. Full Bundling
- Deskripsikan sebagai program terlengkap yang membimbing peserta dari nol sampai mendapatkan kerja di Jepang.
- Fokus komunikasi halaman ini adalah solusi lengkap yang menggabungkan persiapan, edukasi, pencocokan kerja, dan pendampingan lanjutan.
- CTA diarahkan untuk konsultasi atau pembelian program Full Bundling.

## Struktur Halaman
### 1. Jumbotron
- Setiap halaman wajib memiliki jumbotron.
- Layout jumbotron mengikuti pola di `resources/views/landing/matching-job/main.blade.php`.
- Isi jumbotron disesuaikan dengan nama dan positioning masing-masing program.
- Jumbotron harus memiliki headline, deskripsi singkat, visual yang selaras dengan halaman utama, dan CTA WhatsApp.

### 2. Informasi Program
- Tambahkan section yang menjelaskan ringkasan program.
- Konten harus mudah dibaca, tidak terlalu panjang, dan langsung menjawab manfaat utama program.
- Hindari membuat struktur informasi yang terlalu kompleks.

### 3. Benefit atau Highlight Program
- Tambahkan section benefit/highlight sesuai program.
- Gunakan daftar benefit yang relevan dengan masing-masing program.
- Pastikan user dapat memahami perbedaan tiap program tanpa harus kembali ke halaman utama.

### 4. Rundown Program
- Gunakan section rundown yang saat ini berada di `resources/views/landing/matching-job/main.blade.php`.
- Section rundown harus tersedia di ketiga halaman detail.
- Pertahankan pola visual dan pengalaman interaksi rundown agar konsisten dengan halaman utama.
- Jika ada script atau dependency yang dibutuhkan rundown, pastikan tetap mengikuti pola existing halaman public.

### 5. CTA Penutup
- Tambahkan CTA penutup pada setiap halaman.
- CTA harus mengarah ke WhatsApp admin.
- Copy CTA disesuaikan dengan program yang sedang dibuka.
- Tujuannya adalah membuat user mudah bertanya atau membeli program tanpa harus mencari kontak admin.

## Arah Implementasi
- Gunakan `resources/views/layouts/landing.blade.php` sebagai base layout.
- Jangan membuat layout baru untuk kebutuhan ini.
- Pertahankan tone visual yang sama dengan halaman public existing.
- Gunakan Tailwind CSS secara langsung di Blade sesuai pola halaman existing.
- Gunakan data konten yang sederhana dan jelas; tidak perlu membuat sistem CMS, database baru, atau admin panel.
- Jika controller method untuk ketiga halaman masih kosong, isi hanya untuk mengarah ke view yang sesuai dan mengirim data yang diperlukan halaman.

## Prinsip Desain
- Tampilan harus responsive dan nyaman dibaca di mobile maupun desktop.
- Gunakan visual hierarchy yang jelas: headline, deskripsi, benefit, rundown, CTA.
- Jaga agar halaman tetap clean, profesional, dan konsisten dengan halaman Matching Job utama.
- Jangan melakukan redesign besar pada halaman utama Matching Job.
- Jangan mengubah header, footer, topbar, atau layout global kecuali memang dibutuhkan untuk memperbaiki bug langsung yang menghambat halaman ini.

## Kriteria Hasil
- Route `/matching-job/education-program` menampilkan halaman Career Education.
- Route `/matching-job/basic-program` menampilkan halaman Matching Job.
- Route `/matching-job/full-program` menampilkan halaman Full Bundling.
- Ketiga halaman memakai base layout public yang sama dengan halaman Matching Job utama.
- Ketiga halaman memiliki jumbotron dengan layout yang konsisten dengan halaman utama.
- Ketiga halaman memiliki informasi program, benefit/highlight, section rundown, dan CTA WhatsApp.
- Section rundown dari halaman utama tersedia di ketiga halaman detail.
- Tampilan responsive dan tidak rusak di ukuran mobile.
- Implementasi tidak menambah fitur di luar kebutuhan 3 halaman detail program.

## Batasan Scope
- Jangan membuat fitur pembayaran online.
- Jangan membuat form pendaftaran baru.
- Jangan membuat dashboard admin atau CMS.
- Jangan mengubah struktur database.
- Jangan melakukan redesign total halaman `/matching-job`.
- Jangan mengganti sistem layout public yang sudah ada.
- Jangan menambahkan package baru kecuali benar-benar diperlukan oleh komponen existing.

## Catatan Untuk Implementer
- Kerjakan hanya file yang relevan dengan 3 halaman detail program ini.
- Gunakan halaman Matching Job utama sebagai acuan utama, bukan membuat desain dari nol.
- Jika menemukan data atau copywriting yang belum lengkap, gunakan placeholder konten yang rapi dan masih sesuai dengan deskripsi program di dokumen ini.
- Setelah selesai, cek ketiga route secara manual dan pastikan CTA WhatsApp dapat diklik.
