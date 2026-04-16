# Plan Migration User Profile

## Tujuan
- Menyusun rencana pembuatan migration database `create-user-profile` untuk tabel `user_profile`.
- Memastikan struktur tabel lengkap, konsisten, dan siap diimplementasikan oleh junior programmer atau AI model dengan instruksi yang jelas.
- Menjaga agar scope tetap fokus pada migration tabel tanpa melebar ke model, controller, seed, form, atau fitur lain di luar kebutuhan.

## Ruang Lingkup
- Pembuatan migration untuk tabel `user_profile`.
- Pendefinisian seluruh kolom wajib sesuai requirement.
- Pendefinisian primary key, foreign key, dan timestamp.
- Pencantuman deskripsi setiap kolom sesuai brief.

## Prinsip Implementasi
- Gunakan nama tabel persis `user_profile`.
- Seluruh kolom pada tabel bersifat wajib diisi.
- Struktur migration harus langsung mencerminkan kebutuhan data profile user dan tidak menambah kolom di luar requirement.
- Relasi `user_id` harus mengacu ke tabel `users` sebagai foreign key.
- Definisi tipe data harus mengikuti requirement, dengan pendekatan yang rapi, konsisten, dan mudah dipahami.
- Deskripsi kolom wajib dicantumkan untuk semua field sesuai teks yang sudah ditentukan.

## Spesifikasi Tabel
**Nama tabel:** `user_profile`

| Kolom | Tipe Data | Aturan Utama | Deskripsi |
| --- | --- | --- | --- |
| `id` | `INT` | Primary key, unique, auto increment, wajib | ID data profile user |
| `user_id` | `INT` | Foreign key ke tabel `users`, wajib | Relasi ke tabel users |
| `profile_picture` | `VARCHAR(255)` | Wajib | Foto Profile atau Pas Foto (氏名) |
| `full_name` | `VARCHAR(255)` | Wajib | Nama lengkap (氏名) |
| `furigana_name` | `VARCHAR(255)` | Wajib | Nama lengkap dalam bahasa Jepang (フリガナ) |
| `birth_date` | `DATE` | Wajib | Tanggal lahir (生年月日) |
| `gender` | `ENUM('male', 'female')` | Wajib | Jenis kelamin (性別) |
| `marital_status` | `ENUM('single', 'married', 'divorce')` | Wajib | Status pernikahan (婚姻) |
| `nationality` | `VARCHAR(100)` | Wajib | Kewarganegaraan (国籍) |
| `place_of_origin` | `VARCHAR(255)` | Wajib | Tempat asal (出身地) |
| `current_address` | `TEXT` | Wajib | Alamat sekarang (現住所) |
| `religion` | `VARCHAR(50)` | Wajib | Agama (宗教) |
| `is_wearing_hijab` | `VARCHAR(255)` | Wajib | Pakai hijab atau tidak (ヒジャブ) |
| `prayer_requirement` | `TEXT` | Wajib | Kebutuhan waktu ibadah (お祈り) |
| `pork_tolerance` | `TEXT` | Wajib | Skala toleransi babi |
| `alcohol_tolerance` | `TEXT` | Wajib | Skala toleransi alkohol (飲酒への許容度) |
| `entry_date` | `DATE` | Wajib | Tanggal masuk Jepang (入国日) |
| `visa_expiry_date` | `DATE` | Wajib | Masa berlaku visa (在留カードの期限) |
| `current_visa_type` | `VARCHAR(100)` | Wajib | Jenis visa saat ini (現在の在留資格) |
| `jlpt_level` | `ENUM('N1', 'N2', 'N3', 'N4', 'N5', 'none')` | Wajib | Level bahasa Jepang (日本語能力) |
| `has_driver_license` | `BOOLEAN` | Wajib | Punya SIM atau enggak (運転免許有無) |
| `work_start_date` | `DATE` | Wajib | Kapan siap mulai kerja (就労開始可能日) |
| `technical_experience` | `TEXT` | Wajib | Detail pengalaman magang/skill (技能実習経験) |
| `created_at` | `TIMESTAMP` | Default `current_timestamp`, wajib | Record data dibuat |
| `updated_at` | `TIMESTAMP` | Default `current_timestamp`, wajib | Record data diupdate |

## Rencana Struktur Migration
### 1. Definisi Tabel
- Buat migration khusus untuk tabel `user_profile`.
- Jadikan `id` sebagai identitas utama record.
- Pastikan nama kolom mengikuti requirement secara persis agar tidak menimbulkan mismatch dengan dokumen bisnis atau implementasi berikutnya.

### 2. Definisi Relasi
- Tetapkan `user_id` sebagai foreign key yang terhubung ke tabel `users`.
- Pastikan relasi hanya berfungsi sebagai penghubung data profile ke user tanpa menambah relasi lain di luar scope.

### 3. Definisi Kolom Data Diri
- Kelompokkan kolom data identitas, data personal, data status tinggal, dan data kesiapan kerja secara rapi di dalam migration.
- Gunakan tipe data yang sesuai dengan karakter data agar struktur database tetap jelas dan mudah dipelihara.
- Pastikan seluruh field ditetapkan sebagai mandatory sesuai instruksi.

### 4. Definisi Timestamp
- Sertakan `created_at` dan `updated_at` sebagai bagian standar pencatatan waktu data.
- Pastikan default timestamp mengikuti requirement agar record memiliki jejak waktu sejak pertama dibuat dan saat diperbarui.

## Tahapan Implementasi
### Fase 1 - Setup Migration
- Buat file migration dengan nama yang merepresentasikan pembuatan tabel `user_profile`.
- Pastikan migration hanya fokus pada pembuatan tabel baru sesuai scope.

### Fase 2 - Penyusunan Schema
- Definisikan seluruh kolom sesuai urutan requirement agar dokumen, schema, dan implementasi tetap sinkron.
- Terapkan tipe data, mandatory field, primary key, dan foreign key secara konsisten.

### Fase 3 - Pemberian Deskripsi Kolom
- Lengkapi setiap kolom dengan deskripsi sesuai teks requirement.
- Jangan mengubah, meringkas, atau menghilangkan deskripsi yang sudah ditentukan.

### Fase 4 - Validasi Hasil Migration
- Pastikan tidak ada kolom yang tertinggal.
- Pastikan tidak ada kolom tambahan di luar requirement.
- Pastikan seluruh kolom bersifat wajib.
- Pastikan relasi `user_id` ke `users` sudah benar.

## Kriteria Hasil
- Migration `create-user-profile` tersedia untuk tabel `user_profile`.
- Seluruh kolom requirement terdefinisi lengkap.
- Seluruh kolom memiliki deskripsi sesuai brief.
- Seluruh kolom bersifat wajib diisi.
- `id` menggunakan primary key, unique, dan auto increment.
- `user_id` terhubung ke tabel `users` sebagai foreign key.
- `created_at` dan `updated_at` tersedia dengan default `current_timestamp`.
- Tidak ada penambahan field atau perubahan scope di luar instruksi.

## Catatan Implementasi
- Fokus pada ketepatan schema, bukan perluasan fitur.
- Jangan menambahkan optimasi, field baru, atau logic tambahan yang tidak diminta.
- Prioritaskan konsistensi nama kolom, tipe data, constraint utama, dan deskripsi.
- Kerjakan sesuai scope migration database `create-user-profile` saja.
