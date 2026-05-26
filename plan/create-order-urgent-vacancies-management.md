# PRD / Plan Create Order Urgent Vacancies Management

## Tujuan
- Membuat fitur manajemen urutan loker prioritas/urgent dari sisi admin.
- Admin dapat memilih loker yang sudah ada di database untuk dimasukkan ke daftar loker urgent.
- Admin dapat mengatur urutan loker urgent dengan drag and drop, dari prioritas paling atas sampai bawah.
- Admin dapat menghapus loker dari daftar urgent tanpa menghapus data loker aslinya.
- Landing page `/` menampilkan loker urgent pada bagian `Dibutuhkan Segera` berdasarkan urutan yang dikelola admin.

## Ringkasan Produk
Fitur ini adalah halaman admin untuk mengelola loker yang ingin diprioritaskan di landing page. Data prioritas disimpan pada tabel `urgent_vacancies` yang berelasi ke tabel `vacancies` melalui kolom `job_id`.

Halaman ini tidak menggantikan CRUD loker existing. Fitur ini hanya mengatur daftar loker mana yang masuk ke section urgent dan urutan tampilnya.

## Target Pengguna
- Admin yang mengelola data lowongan kerja.
- Tim operasional yang menentukan lowongan mana yang harus ditampilkan sebagai prioritas di landing page.

## Ruang Lingkup
- Menambahkan tombol `Loker Prioritas` pada halaman daftar loker admin.
- Membuat halaman admin khusus untuk manajemen loker urgent/prioritas.
- Menampilkan daftar loker urgent yang sudah tersimpan di tabel `urgent_vacancies`.
- Menyediakan fitur tambah loker dari data `vacancies` ke daftar urgent.
- Menyediakan fitur drag and drop untuk mengubah urutan loker urgent.
- Menyediakan fitur hapus loker dari daftar urgent.
- Mengubah data section `Dibutuhkan Segera` di landing page agar memakai data dari `urgent_vacancies` sesuai urutan admin.
- Menambahkan validasi dan feedback dasar agar admin memahami hasil aksi yang dilakukan.

## Di Luar Scope
- Tidak membuat ulang halaman CRUD loker existing.
- Tidak mengubah struktur utama tabel `vacancies`.
- Tidak menghapus atau mengubah data loker ketika admin menghapus item dari daftar urgent.
- Tidak membuat sistem ranking kompleks selain urutan manual.
- Tidak menambahkan fitur schedule, tanggal mulai, tanggal akhir, atau auto-expire untuk urgent vacancy.
- Tidak membuat role/permission baru.
- Tidak mengubah desain besar landing page di luar sumber data section `Dibutuhkan Segera`.
- Tidak mengerjakan optimasi besar yang tidak diperlukan untuk fitur ini.

## Kondisi Existing Project
- Halaman daftar loker admin ada di `resources/views/admin/vacancy/all.blade.php`.
- Route admin loker berada di group `/admin/vacancy` pada `routes/web.php`.
- Controller utama loker admin saat ini menggunakan `VacancyController`.
- Landing page `/` ditangani oleh `LandingController@index`.
- Section `Dibutuhkan Segera` sudah ada di `resources/views/landing/main.blade.php`.
- Saat ini data urgent di landing masih berbasis tag `urgent` pada kolom `tags` di tabel `vacancies`.
- Migration `database/migrations/2026_05_25_083152_create_table_urgent_vacancies.php` sudah menyediakan tabel `urgent_vacancies` dengan kolom `job_id` dan `order`.

## Prinsip Implementasi
- Gunakan tabel `urgent_vacancies` sebagai source of truth untuk daftar dan urutan loker urgent.
- Relasi `urgent_vacancies.job_id` harus mengarah ke data `vacancies`.
- Urutan terkecil berarti prioritas paling atas.
- Jangan membuat duplikasi loker yang sama di daftar urgent.
- Hanya data vacancy yang valid dan masih ada yang boleh tampil sebagai urgent.
- Landing page hanya menampilkan loker urgent yang status vacancy-nya aktif.
- UI harus sederhana dan mudah digunakan oleh admin non-teknis.
- Pertahankan pola desain admin existing agar fitur terasa menyatu dengan aplikasi.

## Kebutuhan Fungsional

### 1. Tombol Akses dari Daftar Loker Admin
- Pada halaman daftar loker admin, tambahkan tombol `Loker Prioritas`.
- Tombol mengarah ke halaman manajemen loker urgent.
- Letakkan tombol pada area action halaman daftar loker, dekat tombol `Tambah Job` atau area action lain yang relevan.

### 2. Halaman Manajemen Loker Urgent
- Halaman menampilkan judul yang jelas, misalnya `Loker Prioritas` atau `Manajemen Loker Urgent`.
- Halaman menampilkan daftar loker yang sudah masuk ke tabel `urgent_vacancies`.
- Setiap item minimal menampilkan informasi penting loker seperti kode loker, judul, penempatan, status, dan ringkasan singkat lain yang sudah biasa dipakai pada admin loker.
- Setiap item memiliki handle/indikator drag and drop agar admin memahami bahwa urutan bisa diubah.
- Setiap item memiliki action hapus dari daftar urgent.

### 3. Tambah Loker ke Daftar Urgent
- Admin dapat memilih loker dari data `vacancies` yang sudah ada di database.
- Loker yang sudah masuk ke daftar urgent tidak boleh muncul lagi sebagai kandidat untuk ditambahkan, atau harus dicegah saat disimpan.
- Setelah loker ditambahkan, sistem memasukkannya ke urutan paling bawah secara default.
- Admin mendapat feedback sukses atau gagal setelah proses tambah.

### 4. Drag and Drop Urutan
- Admin dapat mengubah urutan daftar loker urgent dengan drag and drop.
- Setelah urutan berubah, sistem menyimpan nilai `order` pada tabel `urgent_vacancies`.
- Urutan tersimpan harus tetap sama ketika halaman direfresh.
- Jika terjadi kegagalan simpan, tampilkan feedback error dan jangan membuat UI membingungkan.

### 5. Hapus dari Daftar Urgent
- Admin dapat menghapus loker dari daftar urgent.
- Penghapusan hanya menghapus record di `urgent_vacancies`, bukan record pada `vacancies`.
- Setelah item dihapus, urutan item tersisa harus tetap rapi dan tidak menyebabkan konflik prioritas.
- Admin mendapat feedback setelah proses hapus.

### 6. Landing Page Section `Dibutuhkan Segera`
- Section `Dibutuhkan Segera` di halaman `/` harus mengambil data dari `urgent_vacancies`.
- Data ditampilkan sesuai urutan `order` dari tabel `urgent_vacancies`.
- Hanya vacancy aktif yang ditampilkan ke user publik.
- Jika tidak ada loker urgent aktif, section mengikuti perilaku existing: tidak perlu ditampilkan.
- Tampilan kartu dan layout section existing harus dipertahankan kecuali ada kebutuhan kecil untuk menyesuaikan data.

## Kebutuhan Data
- Gunakan tabel `urgent_vacancies` sesuai migration existing.
- Field penting:
  - `job_id`: relasi ke `vacancies.id`.
  - `order`: urutan tampil, semakin kecil semakin prioritas.
- Buat model/relasi yang diperlukan agar query tetap rapi dan mudah dibaca.
- Pastikan tidak ada loker yang sama masuk dua kali ke daftar urgent.
- Jika diperlukan, validasi duplikasi boleh dilakukan di level aplikasi tanpa mengubah scope besar database.

## Arah Backend
- Tambahkan route admin untuk halaman manajemen urgent vacancy.
- Tambahkan handler untuk menampilkan halaman, menambah item, menyimpan urutan, dan menghapus item.
- Query halaman admin harus mengambil data urgent beserta detail vacancy terkait.
- Query kandidat tambah loker harus mengambil data dari `vacancies` yang belum masuk daftar urgent.
- Query landing page harus join/relasi ke `urgent_vacancies` dan mengurutkan berdasarkan `urgent_vacancies.order`.
- Pastikan endpoint update urutan menerima daftar item yang jelas dan memvalidasi bahwa item tersebut memang record urgent vacancy.

## Arah UI/UX Admin
- Gunakan gaya visual yang konsisten dengan halaman admin existing.
- Halaman harus fokus pada dua pekerjaan utama: tambah loker urgent dan susun urutan.
- Gunakan dropdown/search sederhana untuk memilih loker dari database.
- Gunakan drag and drop yang mudah dikenali.
- Gunakan tombol hapus yang jelas, tetapi tidak dominan dibanding fungsi urutan.
- Tampilkan empty state ketika belum ada loker urgent.
- Tampilkan pesan sukses/error setelah tambah, reorder, atau hapus.

## Validasi dan Error Handling
- Tidak boleh menambahkan vacancy yang sama lebih dari sekali.
- Tidak boleh menambahkan vacancy yang tidak ditemukan.
- Tidak boleh menyimpan urutan untuk urgent vacancy yang tidak valid.
- Jika vacancy terkait sudah terhapus, record urgent harus tidak merusak halaman.
- Jika loker nonaktif ada di daftar urgent, admin masih boleh melihatnya di halaman manajemen, tetapi landing page publik tidak menampilkannya.

## Acceptance Criteria
- Admin melihat tombol `Loker Prioritas` dari halaman daftar loker admin.
- Admin dapat membuka halaman manajemen loker urgent.
- Admin dapat menambahkan loker dari database ke daftar urgent.
- Sistem mencegah duplikasi loker urgent.
- Admin dapat mengubah urutan loker urgent dengan drag and drop.
- Urutan yang disimpan tetap konsisten setelah refresh halaman.
- Admin dapat menghapus loker dari daftar urgent tanpa menghapus data vacancy asli.
- Landing page `/` menampilkan section `Dibutuhkan Segera` dari tabel `urgent_vacancies` sesuai urutan admin.
- Landing page tidak menampilkan loker urgent yang status vacancy-nya nonaktif.
- Jika tidak ada loker urgent aktif, section `Dibutuhkan Segera` tidak tampil.

## File yang Berpotensi Disesuaikan
- `routes/web.php`
- `app/Http/Controllers/VacancyController.php` atau controller admin khusus urgent vacancy jika ingin dipisah rapi.
- `app/Http/Controllers/LandingController.php`
- `app/Models/Vacancy.php`
- Model baru untuk `urgent_vacancies` jika diperlukan.
- `resources/views/admin/vacancy/all.blade.php`
- View admin baru untuk halaman manajemen loker urgent.
- `resources/views/landing/main.blade.php` jika perlu penyesuaian kecil.
- Test feature terkait admin urgent vacancy dan landing urgent vacancy.

## Tahapan Implementasi

### Fase 1 - Review Existing
- Review halaman daftar loker admin dan tentukan lokasi tombol `Loker Prioritas`.
- Review migration `urgent_vacancies` dan relasinya ke `vacancies`.
- Review section `Dibutuhkan Segera` existing pada landing page.

### Fase 2 - Backend Admin
- Siapkan model/relasi untuk urgent vacancy.
- Siapkan route dan handler admin untuk index, tambah, reorder, dan hapus.
- Pastikan validasi data dan duplikasi berjalan.

### Fase 3 - UI Admin
- Tambahkan tombol akses dari daftar loker admin.
- Buat halaman manajemen loker urgent.
- Tambahkan komponen pilih loker, daftar item, drag and drop, dan hapus.
- Tambahkan feedback sukses/error.

### Fase 4 - Integrasi Landing Page
- Ubah sumber data `urgentJobs` di landing page agar menggunakan `urgent_vacancies`.
- Pastikan urutan mengikuti kolom `order`.
- Pastikan hanya vacancy aktif yang tampil ke publik.
- Pertahankan tampilan section existing.

### Fase 5 - Testing dan Validasi
- Test tambah loker urgent.
- Test pencegahan duplikasi.
- Test reorder dan refresh halaman.
- Test hapus dari daftar urgent.
- Test landing page menampilkan data sesuai urutan.
- Test landing page tidak menampilkan section ketika tidak ada urgent vacancy aktif.

## Instruksi untuk Engineer Implementer
- Kerjakan sesuai scope dokumen ini saja.
- Jangan membuat fitur tambahan di luar kebutuhan manajemen urutan loker urgent.
- Jangan merombak desain admin atau landing page secara besar.
- Jangan mengubah flow CRUD loker existing kecuali sebatas menambahkan tombol akses ke fitur ini.
- Prioritaskan implementasi yang sederhana, stabil, dan mudah diuji.
- Jika menemukan kebutuhan yang belum tertulis di dokumen ini, catat sebagai pertanyaan atau follow-up, jangan langsung memperluas scope.
