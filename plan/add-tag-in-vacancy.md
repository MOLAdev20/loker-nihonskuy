# Plan Tag Khusus pada Vacancy

## Tujuan
- Menambahkan sistem tag sederhana pada data lowongan agar admin dapat memberi klasifikasi strategis, dimulai dari tag `urgent`.
- Menampilkan lowongan bertag `urgent` pada landing page di section khusus `🔥 Dibutuhkan Segera`.
- Menjaga implementasi tetap mengikuti pola MVC, sederhana untuk dioperasikan, dan cukup fleksibel untuk penambahan tag lain di masa berikutnya.

## Arah Arsitektur
- Gunakan kolom `tags` di tabel `vacancies` sebagai penyimpanan string terdelimitasi, misalnya `urgent|tag2`.
- Pertahankan `Vacancy` sebagai sumber data utama untuk logika tag, bukan memindahkan parsing string ke view.
- Form admin create dan update menjadi titik input tag, sedangkan `LandingController` menjadi titik konsumsi data untuk publik.
- Gunakan asset frontend melalui Vite dan npm package, sehingga integrasi `swiper` masuk ke pipeline yang sudah dipakai landing page dan tidak bergantung pada CDN.

## Rencana Perubahan

### 1. Database
- Buat migration baru untuk menambahkan kolom `tags` bertipe `string` dan `nullable` pada tabel `vacancies`.
- Jangan ubah struktur tabel lain di luar scope ini.
- Anggap format isi kolom sebagai daftar tag berbasis delimiter `|`, sehingga implementasi awal tetap ringan tanpa tabel relasi tambahan.

### 2. Model
- Tambahkan `tags` ke `fillable` pada model `Vacancy`.
- Siapkan helper ringan pada model untuk:
  - membaca string `tags` menjadi array terstruktur
  - mengecek apakah sebuah vacancy memiliki tag tertentu seperti `urgent`
- Tujuannya agar parsing string tidak diulang di controller atau Blade.

### 3. Admin Vacancy Flow
- Tambahkan input `Tag Khusus` berbentuk checkbox pada form create dan update vacancy.
- Untuk versi awal, hanya tampilkan satu opsi:
  - label: `Dibutuhkan Segera`
  - value: `urgent`
- Saat submit create dan update:
  - request checkbox dikonversi menjadi string terdelimitasi
  - jika tidak ada tag dipilih, simpan sebagai `null`
- Pastikan nilai tag lama dapat tampil kembali pada form edit dan saat validasi gagal.

### 4. Controller
- Perluas alur `store` dan `update` di `VacancyController` agar menerima input tag tanpa merusak struktur request yang sudah ada.
- Perbarui controller landing yang menangani halaman utama agar selain mengambil daftar lowongan utama, juga mengambil daftar lowongan dengan tag `urgent`.
- Query urgent harus:
  - fokus pada lowongan publik yang masih layak tampil
  - menggunakan filtering string yang efisien untuk format delimiter saat ini
  - dibatasi jumlahnya agar sesuai kebutuhan tampilan section 1x4

### 5. Landing Page UI
- Tambahkan section baru di `resources/views/landing/main.blade.php` tepat di bawah section `Paling Banyak di Lamar`.
- Section berisi:
  - judul `🔥 Dibutuhkan Segera`
  - subjudul yang menjelaskan bahwa perusahaan sedang membutuhkan kandidat dengan cepat
  - area slider/carousel dengan komposisi visual setara 1 baris berisi 4 kartu
- Gunakan kembali `resources/views/components/job-card.blade.php` agar kartu lowongan tetap konsisten dengan section lain.
- Jika data urgent kosong, section dapat disembunyikan atau menampilkan placeholder ringan, sesuai pendekatan yang paling bersih untuk landing page.

### 6. Frontend Carousel
- Tambahkan `swiper` melalui npm dependency, bukan CDN.
- Integrasikan inisialisasi slider ke asset landing yang sudah ada, yaitu `resources/js/pages/landing.js`, agar script tetap terpusat.
- Gunakan auto-slide yang halus, tetap usable di mobile, dan tidak mengganggu interaksi pengguna.
- Pastikan konfigurasi slider tetap sederhana:
  - autoplay
  - responsive breakpoints
  - jumlah kartu yang menyesuaikan lebar layar

## Prinsip Implementasi
- Gunakan camelCase untuk nama variabel, method, helper, dan referensi object di Blade atau JavaScript.
- Hindari query manual atau parsing string tag berulang di view.
- Hindari solusi over-engineered seperti tabel pivot tag pada scope ini; string-delimited tagging sudah cukup untuk versi awal.
- Pastikan lowongan urgent tetap memakai komponen kartu dan styling landing yang sudah ada agar visual tetap konsisten.

## Alur Data
- Admin membuat atau mengedit lowongan, lalu memilih checkbox `Dibutuhkan Segera` bila perlu.
- Controller menyimpan tag terpilih ke kolom `tags` dalam format string terdelimitasi.
- Landing page controller mengambil data lowongan umum dan data lowongan bertag `urgent` secara terpisah.
- View landing merender section urgent hanya dengan data yang sudah siap tampil.
- `landing.js` mengaktifkan slider Swiper untuk section urgent setelah halaman dimuat.

## Kriteria Hasil
- Admin dapat memberi dan memperbarui tag khusus pada lowongan dari form create dan edit.
- Data tag tersimpan di kolom `vacancies.tags` dalam format string yang konsisten.
- Landing page memiliki section `🔥 Dibutuhkan Segera` yang menampilkan lowongan bertag `urgent`.
- Section urgent menggunakan `job-card` yang sama dengan komponen kartu existing.
- Carousel berjalan otomatis, responsif, dan di-load melalui npm + Vite, bukan CDN.

## Catatan Implementasi
- Karena strategi penyimpanan memakai string, implementasi filtering harus mempertimbangkan batas kata tag agar pencarian `urgent` tidak salah match dengan string lain.
- Jika nantinya jumlah tag bertambah, struktur helper di model dan normalisasi input harus tetap menjadi satu titik kontrol agar ekspansi fitur tidak berantakan.
- Fokus versi ini adalah tagging dasar + distribusi konten di landing page, bukan sistem manajemen tag penuh.
