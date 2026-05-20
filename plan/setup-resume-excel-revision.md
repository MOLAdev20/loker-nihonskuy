# Plan Revisi Layout Excel Report CV Jepang

## Tujuan
- Menyusun arahan modifikasi layout Excel report CV Jepang yang sudah ada.
- Memastikan perubahan hanya fokus pada penambahan kontak kandidat, penempatan foto profile, dan background abu-abu sesuai referensi gambar.
- Dokumen ini dibuat sebagai brief high level untuk junior programmer atau AI model dengan kemampuan terbatas.

## File Terdampak
- `app/Http/Controllers/User/ResumeController.php`

## Ruang Lingkup
- Modifikasi hanya dilakukan pada layout Excel report CV Jepang yang sudah ada.
- Tidak membuat report baru, export baru, controller baru, atau struktur data baru.
- Tidak mengubah flow download/export CV selain bagian layout yang disebutkan pada dokumen ini.

## Arah Perubahan
### 1. Penambahan Kontak Kandidat
- Tambahkan baris kontak kandidat tepat di bawah area `技能試験 &技能実習経験`.
- Gunakan label Jepang `電話番号` pada cell `E15`.
- Gunakan nilai nomor telepon kandidat pada area `F15` sampai `G15` dengan format merge cell.
- Untuk acuan awal, nilai yang ditampilkan adalah `083140318095` sesuai brief.
- Pastikan penambahan kontak tidak merusak posisi informasi lain pada layout report.

### 2. Penempatan Foto Profile
- Gunakan area foto profile yang sudah tersedia pada cell `H5` sampai `I15`.
- Isi area tersebut menggunakan data `user_profile.profile_picture`.
- Foto harus tampil di dalam area yang sudah disediakan tanpa membuat area layout baru.
- Jika data foto tidak tersedia, pertahankan fallback existing bila sudah ada, atau biarkan area tetap aman tanpa error export.

### 3. Background Abu-Abu pada Cell
- Terapkan background warna abu-abu pada cell yang relevan dengan struktur layout, mengacu pada referensi gambar.
- Gunakan warna abu-abu yang konsisten dengan visual report pada gambar, terutama untuk area label/header dan section pembatas.
- Jangan mengganti keseluruhan desain report; cukup sesuaikan background cell yang diperlukan agar tampilan mendekati referensi.

## Prinsip Implementasi
- Pertahankan struktur Excel report CV Jepang yang sudah ada.
- Fokus perubahan hanya di `ResumeController.php` sesuai scope brief.
- Gunakan pola styling, merge cell, border, dan image insertion yang sudah dipakai pada report existing.
- Hindari refactor besar, perubahan nama method besar, atau pemindahan logic ke file baru.
- Pastikan perubahan tetap kompatibel dengan proses export yang sedang berjalan.

## Kriteria Hasil
- Cell `E15` menampilkan label `電話番号`.
- Cell `F15` sampai `G15` tergabung dan menampilkan nomor telepon kandidat sesuai data/brief.
- Area `H5` sampai `I15` menampilkan foto dari `user_profile.profile_picture`.
- Cell yang perlu diberi warna abu-abu sudah mengikuti arahan visual dari referensi gambar.
- Export Excel tetap berhasil dibuat dan layout utama tidak rusak.
- Tidak ada perubahan fitur di luar revisi layout Excel CV Jepang ini.

## Batasan Scope
- Jangan membuat tabel database baru.
- Jangan menambahkan field form baru.
- Jangan membuat endpoint, route, atau controller baru.
- Jangan mengubah modul export lain di luar CV Jepang ini.
- Jangan melakukan redesign total pada report.
- Jangan menambahkan package baru kecuali benar-benar dibutuhkan oleh mekanisme Excel existing.

## Catatan Untuk Implementer
- Gunakan gambar referensi hanya sebagai acuan visual untuk background abu-abu dan posisi elemen.
- Jika ada konflik posisi cell karena layout existing berbeda, prioritaskan agar kontak kandidat tetap berada di bawah `技能試験 &技能実習経験` dan foto tetap berada di area `H5:I15`.
- Setelah implementasi, lakukan export manual untuk memastikan file Excel dapat dibuka dan tampilan sesuai brief.
