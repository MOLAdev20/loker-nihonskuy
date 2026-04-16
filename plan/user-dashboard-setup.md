# Plan UI Admin Dashboard User

## Tujuan
- Menyusun UI admin dashboard user yang modern, minimalis, responsif, dan dominan putih.
- Menggunakan Blade untuk struktur view, Tailwind CSS untuk styling, dan SVG icon pada `components/icons` dengan referensi gaya dari Lucide.
- Menyiapkan layout yang rapi, mudah dikembangkan, dan cukup sederhana untuk diimplementasikan oleh junior programmer atau AI model dengan kemampuan terbatas.

## Ruang Lingkup
- Topbar
- Sidebar
- Area konten utama
- Modal form
- Struktur layout responsif desktop dan mobile

## Prinsip Implementasi
- Gunakan pendekatan mobile first.
- Fokus pada komponen reusable agar mudah dipakai ulang di halaman lain.
- Hindari logika rumit di view; utamakan struktur Blade yang jelas dan terpisah.
- Gunakan animasi ringan dan halus, bukan efek berlebihan.
- Pertahankan konsistensi warna, spacing, radius, shadow, dan tipografi di seluruh dashboard.

## Arah Visual
- Dominan warna putih untuk topbar, content, dan modal.
- Sidebar menggunakan warna slate dengan teks dan icon putih.
- Gunakan shadow tipis, border halus, dan sudut rounded agar tampilan modern tetapi tetap bersih.
- Pastikan layout tetap lega, tidak padat, dan nyaman dibaca pada layar kecil maupun besar.

## Rencana Struktur Layout
### 1. Layout Utama
- Buat satu layout dashboard sebagai kerangka utama.
- Layout terdiri dari topbar di atas, sidebar di kiri, dan content di area utama.
- Area konten harus fleksibel agar dapat dipakai untuk banyak halaman user dashboard ke depan.

### 2. Topbar
- Posisi tetap di bagian atas sebagai area navigasi utama.
- Sisi kiri berisi logo dan tombol toggle sidebar khusus mobile.
- Sisi kanan berisi email user dan foto profil.
- Tampilan topbar harus bersih, putih, dan memiliki pembeda visual ringan dari content, misalnya shadow tipis atau border halus.

### 3. Sidebar
- Sidebar menjadi navigasi utama dengan 4 grouping menu.
- Setiap grouping dapat berisi menu tunggal atau menu dengan sub menu.
- Sub menu harus bisa expand/collapse dengan animasi halus.
- Pada mobile, sidebar default dalam kondisi tersembunyi lalu muncul dari kiri ke kanan saat tombol toggle ditekan.
- Saat sidebar mobile aktif, pastikan pengalaman pengguna tetap fokus dan mudah menutup kembali sidebar.

### 4. Content Area
- Sediakan area header konten yang memiliki judul utama dan subjudul.
- Sediakan area isi utama yang fleksibel untuk menampung card, table, form, atau konten lain.
- Jaga agar struktur konten mudah diganti tanpa perlu mengubah layout utama.

### 5. Modal
- Buat modal reusable dengan overlay dan animasi fade/smooth popup.
- Isi modal harus fleksibel agar bisa dipakai untuk berbagai kebutuhan.
- Sebagai contoh awal, gunakan form data diri sederhana berisi 4 field input.
- Modal harus tetap nyaman digunakan di layar mobile.

## Rencana Komponen
- `Dashboard Layout` untuk kerangka utama halaman.
- `Topbar` untuk logo, toggle sidebar, email, dan avatar.
- `Sidebar` untuk grouping menu dan sub menu.
- `Content Header` untuk judul dan subjudul halaman.
- `Modal` untuk popup reusable.
- `Icon Components` untuk seluruh icon SVG agar konsisten dan mudah dirawat.

## Rencana Menu Sidebar
- Bagi sidebar menjadi 4 grup navigasi agar struktur terlihat rapi.
- Siapkan kombinasi menu langsung dan menu dengan sub menu agar mencerminkan kebutuhan dashboard nyata.
- Pastikan state aktif, hover, expand, dan collapse terlihat jelas tetapi tetap minimalis.

## Tahapan Implementasi
### Fase 1 — Fondasi Layout
- Siapkan layout dashboard utama dan pembagian area topbar, sidebar, serta content.
- Pastikan struktur dasar sudah responsif sebelum masuk ke detail komponen.

### Fase 2 — Komponen Navigasi
- Bangun topbar dan sidebar terlebih dahulu karena menjadi fondasi interaksi utama.
- Pastikan toggle mobile, collapse sidebar, dan expand sub menu berjalan dengan halus.

### Fase 3 — Area Konten
- Tambahkan header dan subheader konten.
- Siapkan wrapper isi agar halaman turunan cukup mengisi slot konten tanpa mengubah struktur dasar.

### Fase 4 — Modal Reusable
- Bangun modal generik yang dapat menerima isi dinamis.
- Gunakan contoh form 4 field untuk validasi tampilan dan alur interaksi.

### Fase 5 — Finalisasi UI
- Rapikan konsistensi spacing, warna, shadow, radius, dan responsivitas.
- Pastikan seluruh komponen memiliki pengalaman visual yang seragam.

## Kriteria Hasil
- Dashboard tampil modern, ringan, dan dominan putih.
- Topbar, sidebar, content, dan modal sudah terpisah secara jelas sebagai komponen.
- Sidebar mobile dapat dibuka dari kiri dengan animasi halus dan dapat ditutup dengan mudah.
- Menu dengan sub menu dapat expand/collapse secara smooth.
- Area content sudah memiliki header, subheader, dan slot isi yang fleksibel.
- Modal reusable tampil halus dan memiliki contoh form sederhana 4 field.
- Seluruh UI nyaman digunakan di mobile maupun desktop.

## Catatan Implementasi
- Prioritaskan keterbacaan struktur file dan nama komponen.
- Jangan mulai dari detail kecil; selesaikan kerangka besar lebih dulu.
- Jika ada keterbatasan waktu, prioritaskan layout utama, sidebar mobile, dan modal reusable.
- Pastikan semua icon disusun konsisten dalam folder `components/icons`.
- Kerjakan sesuai scope!
