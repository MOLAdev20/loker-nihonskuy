# PRD Add Job Interview Question Page

## Tujuan
- Menambahkan satu halaman pertanyaan interview pekerjaan sebelumnya untuk user/kandidat setelah tahap `Riwayat Pekerjaan`.
- Mengubah alur wizard user menjadi 5 tahap: `Informasi Pribadi`, `Riwayat Pendidikan`, `Riwayat Pekerjaan`, `Pertanyaan Interview`, dan `Konfirmasi`.
- Menyediakan arahan implementasi high level agar dapat dikerjakan oleh Junior Frontend Engineer atau AI model yang lebih murah tanpa melewati scope.

## Latar Belakang
- User saat ini sudah memiliki alur pengisian data pribadi, riwayat pendidikan, riwayat pekerjaan, dan konfirmasi.
- Dibutuhkan halaman tambahan untuk menangkap jawaban kandidat terkait pengalaman kerja sebelumnya di Jepang, alasan pindah bidang, kesiapan, karakter, motivasi, dan rencana masa depan.
- Migration `create_user_interview_answers_table` sudah tersedia, tetapi model, controller, route, dan view belum tersedia.

## Ruang Lingkup
- Membuat model `App\Models\User\UserInterviewAnswer`.
- Membuat controller `App\Http\Controllers\User\InterviewAnswerController`.
- Menambahkan route user untuk `interview-answer`.
- Membuat view `resources/views/user/interview-answer.blade.php`.
- Menambahkan validasi server untuk seluruh pertanyaan interview.
- Menyimpan jawaban user ke tabel `user_interview_answers`.
- Menyesuaikan wizard agar halaman interview berada setelah `Riwayat Pekerjaan` dan sebelum `Konfirmasi`.
- Menyesuaikan navigasi tombol sebelumnya/selanjutnya pada halaman terkait.

## Di Luar Scope
- Jangan mengubah struktur migration yang sudah ada kecuali ditemukan blocker teknis yang benar-benar mencegah penyimpanan.
- Jangan menambah fitur admin untuk melihat atau mengubah jawaban interview.
- Jangan membuat API baru.
- Jangan menambah fitur autosave, draft per pertanyaan, upload file, atau scoring jawaban.
- Jangan mengubah flow autentikasi, dashboard, atau halaman publik kandidat di luar kebutuhan wizard dan penyimpanan jawaban.

## Prinsip Implementasi
- Ikuti pola layout, arsitektur MVC, validasi, dan style form yang sudah digunakan pada halaman user existing seperti `profile-form`, `education-history-form`, dan `working-experience-form`.
- Gunakan pendekatan create/update satu data jawaban per user, bukan multi-row bebas seperti riwayat pekerjaan.
- Gunakan naming request `camelCase` di form, lalu map ke kolom database `snake_case` sesuai migration.
- Controller hanya mengatur flow halaman, validasi, mapping payload, penyimpanan, dan redirect.
- Blade hanya bertanggung jawab untuk layout, render input, old value, value existing, error state, dan tombol navigasi.
- Semua pertanyaan menggunakan textarea agar kandidat dapat menjawab secara naratif.
- UI harus rapi, mudah dibaca, responsif, dan konsisten dengan dashboard user.

## Struktur Wizard Baru
- Step 1: `Informasi Pribadi` menuju halaman profile.
- Step 2: `Riwayat Pendidikan` menuju halaman education history.
- Step 3: `Riwayat Pekerjaan` menuju halaman working experience.
- Step 4: `Pertanyaan Interview` menuju halaman interview answer.
- Step 5: `Konfirmasi` menuju halaman confirm team.

## Aturan Akses Wizard
- Step interview hanya dapat diakses setelah user memiliki minimal satu data riwayat pekerjaan.
- Step konfirmasi hanya dapat diakses setelah user menyelesaikan jawaban interview.
- State aktif dan selesai mengikuti pola visual wizard yang sudah ada.
- Jangan membuat rule akses yang terlalu kompleks; cukup mengikuti kelengkapan data per tahap.

## Arah Arsitektur
### Model
- Buat model `UserInterviewAnswer` pada namespace model user.
- Model merepresentasikan tabel `user_interview_answers`.
- Model memiliki relasi ke user melalui `user_id`.
- Model menyediakan daftar field yang dapat diisi sesuai migration.

### Controller
- Buat `InterviewAnswerController` sebagai controller khusus halaman interview.
- Controller memiliki flow untuk menampilkan form dan menyimpan jawaban.
- Saat form ditampilkan, controller mengambil jawaban existing milik user jika sudah pernah diisi.
- Saat submit, controller menyimpan sebagai create atau update berdasarkan `user_id`.
- Setelah berhasil disimpan, user diarahkan ke halaman `Konfirmasi`.

### Route
- Tambahkan route user terautentikasi untuk halaman `interview-answer`.
- Gunakan pola route dan route name yang konsisten dengan halaman user existing.
- Route minimal mencakup halaman form dan submit form.
- Jangan menambahkan route lain di luar kebutuhan halaman interview.

### View
- Buat `user/interview-answer.blade.php`.
- Gunakan layout `layouts.user-dashboard`.
- Tampilkan wizard di bagian atas halaman seperti halaman user form lain.
- Susun pertanyaan dalam card/panel yang rapi dengan grouping yang ringan.
- Tampilkan tombol `Sebelumnya: Riwayat Pekerjaan` dan `Selanjutnya: Konfirmasi`.

### Request Validation
- Gunakan request validation khusus agar aturan validasi tidak ditulis langsung di controller.
- Semua jawaban wajib diisi karena kolom migration bersifat required.
- Gunakan pesan error berbahasa Indonesia yang singkat dan formal.
- Error wajib tampil di bawah field terkait seperti pola form existing.

## Daftar Pertanyaan
| No | Field Form | Kolom Database | Pertanyaan |
| --- | --- | --- | --- |
| 1 | `workHistory` | `work_history` | Bisa ceritakan pengalaman kerja Anda sebelumnya di Jepang? (Nama perusahaan, bidang, durasi, dan tugas utama). |
| 2 | `technicalSkills` | `technical_skills` | Keterampilan atau skill teknis apa saja yang paling berkesan dan berhasil Anda kuasai dari pekerjaan tersebut? |
| 3 | `commChallenges` | `comm_challenges` | Selama bekerja di sana, situasi komunikasi seperti apa yang menurut Anda paling menantang atau sulit dihadapi? |
| 4 | `leaveReason` | `leave_reason` | Apa alasan utama Anda memutuskan untuk mencari pekerjaan baru dan keluar dari bidang/perusahaan sebelumnya? |
| 5 | `applyReason` | `apply_reason` | Mengapa Anda tertarik untuk melamar di bidang yang baru ini? Apa yang membuat bidang ini menarik bagi Anda? |
| 6 | `careerPrep` | `career_prep` | Bagaimana proses atau persiapan yang sudah Anda lakukan hingga akhirnya mantap memutuskan melamar di bidang ini sekarang? |
| 7 | `personalityReview` | `personality_review` | Bagaimana rekan kerja atau atasan di perusahaan lama biasanya menggambarkan kepribadian Anda? |
| 8 | `problemSolving` | `problem_solving` | Ketika menghadapi kendala berat atau tekanan dalam pekerjaan, bagaimana cara Anda mengatasinya? |
| 9 | `stayMotivation` | `stay_motivation` | Apa motivasi terbesar yang membuat Anda mampu bertahan menyelesaikan kontrak kerja sebelumnya dengan baik? |
| 10 | `learningGoals` | `learning_goals` | Apa saja hal baru yang ingin Anda pelajari dan kuasai dari pekerjaan di bidang ini? |
| 11 | `japanTargets` | `japan_targets` | Apa target atau goals Anda selama bekerja di Jepang untuk beberapa tahun ke depan? |
| 12 | `longTermDream` | `long_term_dream` | Setelah selesai bekerja di Jepang nanti, apa impian jangka panjang Anda dan bagaimana Anda akan memanfaatkan pengalaman tersebut di Indonesia? |

## Rencana UI/UX
- Gunakan tampilan single page form dengan 12 textarea.
- Kelompokkan pertanyaan secara ringan agar halaman tidak terasa terlalu panjang, misalnya berdasarkan tema pengalaman, alasan pindah, karakter, dan rencana masa depan.
- Setiap textarea memiliki label nomor pertanyaan, teks pertanyaan, placeholder singkat, dan error state.
- Gunakan spacing yang cukup antar pertanyaan agar nyaman dibaca.
- Pada mobile, seluruh field tampil satu kolom penuh.
- Pada desktop, tetap prioritaskan keterbacaan jawaban panjang; jangan memaksa layout dua kolom jika membuat textarea terlalu sempit.

## Rencana Alur Data
### Tampil Halaman
- User membuka halaman interview answer dari wizard atau tombol lanjut setelah `Riwayat Pekerjaan`.
- Sistem mengambil data jawaban interview milik user yang sedang login.
- Jika data sudah ada, form tampil dengan jawaban existing.
- Jika data belum ada, form tampil kosong.

### Submit Jawaban
- User mengisi semua jawaban dan submit form.
- Sistem melakukan validasi server.
- Jika validasi gagal, user tetap berada di halaman form dengan old input dan error per field.
- Jika validasi berhasil, sistem menyimpan jawaban ke `user_interview_answers`.
- User diarahkan ke halaman `Konfirmasi` dengan feedback sukses.

## Penyesuaian Navigasi
- Halaman `Riwayat Pekerjaan` harus mengarahkan tombol selanjutnya ke halaman `Pertanyaan Interview`, bukan langsung ke review/konfirmasi.
- Halaman `Pertanyaan Interview` memiliki tombol kembali ke `Riwayat Pekerjaan`.
- Halaman `Pertanyaan Interview` memiliki tombol lanjut ke `Konfirmasi` setelah jawaban valid tersimpan.
- Halaman `Konfirmasi` harus menampilkan wizard dengan step ke-5 sebagai step aktif.

## Kriteria Hasil
- Route `interview-answer` tersedia dalam area user yang membutuhkan autentikasi.
- Model `UserInterviewAnswer` tersedia dan terhubung ke tabel `user_interview_answers`.
- Controller `InterviewAnswerController` tersedia dan menangani tampil form serta submit form.
- View `user/interview-answer.blade.php` tersedia dengan layout yang konsisten dengan halaman user existing.
- Wizard berubah menjadi 5 step dengan `Pertanyaan Interview` sebagai step ke-4.
- Semua 12 pertanyaan tampil sebagai textarea dan wajib diisi.
- Jawaban user tersimpan sebagai satu record per user.
- User dapat membuka kembali halaman interview dan melihat jawaban yang sudah pernah disimpan.
- Validasi server berjalan dan error tampil tepat di bawah field terkait.
- Setelah submit berhasil, user diarahkan ke halaman `Konfirmasi`.

## Catatan Untuk Implementor
- Kerjakan hanya scope halaman interview answer dan penyesuaian wizard yang terkait langsung.
- Jangan membuat perubahan desain besar pada dashboard user.
- Jangan mengubah migration yang sudah ada tanpa alasan kuat.
- Jangan membuat fitur admin atau publik untuk data interview pada task ini.
- Prioritaskan konsistensi dengan pola code existing dibanding membuat arsitektur baru.
- Jika menemukan perbedaan naming antara route, controller, atau view existing, ikuti pola terbaru pada folder `App\Http\Controllers\User`, `App\Models\User`, dan `resources/views/user`.
