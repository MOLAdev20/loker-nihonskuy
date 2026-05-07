<?php

namespace App\Http\Controllers;

class MatchingJobLandingController extends Controller
{
    public function index()
    {
        return view('landing.matching-job.main', [
            'infoSections' => [
                [
                    'title' => 'Basic Orientation & Fundamentals',
                    'description' => 'Program awal untuk membangun pemahaman dasar kandidat mengenai ekosistem kerja di Jepang agar tidak salah langkah.',
                ],
                [
                    'title' => 'Resume Optimization',
                    'description' => 'Fokus pada standarisasi dokumen lamaran agar sesuai dengan standar perusahaan Jepang yang jelas dan detail.',
                ],
                [
                    'title' => 'Interview Mastery',
                    'description' => 'Latihan intensif untuk menghilangkan kegugupan dan memastikan kandidat mampu menjawab pertanyaan user dengan teknik yang benar.',
                ],
                [
                    'title' => 'Japan Career Concierge',
                    'description' => 'Program pendampingan aktif di mana tim membantu mencarikan posisi yang sesuai dengan profil kandidat.',
                ],
                [
                    'title' => 'Legal & Document Assistance',
                    'description' => 'Program bantuan teknis untuk mengurus birokrasi yang seringkali membingungkan bagi kandidat pemula.',
                ],
                [
                    'title' => 'Flight Readiness Support',
                    'description' => 'Program persiapan akhir sebelum keberangkatan untuk memastikan fisik dan administrasi sudah 100% aman.',
                ],
            ],
            'timelines' => [
                [
                    'title' => 'Konsultasi Awal',
                    'description' => 'Diskusi tujuan kerja, kondisi saat ini, dan kendala utama yang dihadapi peserta.',
                ],
                [
                    'title' => 'Penyusunan Action Plan',
                    'description' => 'Menyusun langkah prioritas berdasarkan target posisi, kelengkapan dokumen, dan kesiapan seleksi.',
                ],
                [
                    'title' => 'Review Berkala',
                    'description' => 'Evaluasi progres untuk memastikan strategi tetap relevan sampai peserta siap apply.',
                ],
                [
                    'title' => 'Final Check Sebelum Apply',
                    'description' => 'Pemeriksaan akhir materi lamaran dan simulasi singkat agar lebih siap masuk tahap rekrutmen.',
                ],
            ],
            'faqs' => [
                [
                    'question' => 'Siapa yang cocok mengikuti kelas ini?',
                    'answer' => 'Kelas ini cocok untuk pencari kerja yang ingin berkarier di Jepang dan membutuhkan arahan terstruktur untuk menyiapkan profil, dokumen, dan strategi lamaran.',
                ],
                [
                    'question' => 'Apakah peserta pemula bisa ikut?',
                    'answer' => 'Bisa. Materi dan pendampingan disusun bertahap agar peserta pemula tetap bisa mengikuti alur dengan jelas.',
                ],
                [
                    'question' => 'Apakah ada pendampingan setelah sesi utama?',
                    'answer' => 'Ada. Detail pendampingan lanjutan disesuaikan dengan paket yang dipilih peserta.',
                ],
                [
                    'question' => 'Bagaimana cara mendaftar kelas konsultasi?',
                    'answer' => 'Klik tombol WhatsApp pada halaman ini, lalu tim NihonSkuy akan membantu proses pendaftaran dan pemilihan paket.',
                ],
            ],
            'packages' => [
                [
                    'name' => 'CAREER EDUCATION',
                    'description' => 'Program edukasi karir yang membantu kamu mempersiapkan, memperbaiki maupun meningkatkan peluang diterima kerja di Jepang',
                    'price' => 'RP. 3.000.000',
                    'highlight' => false,
                    'badge' => null,
                    'ctaLabel' => 'DAPATKAN SEKARANG',
                    'benefits' => [
                        'Kelas edukasi tentang Loker di jepang',
                        'Kelas edukasi tentang CV',
                        'Kelas edukasi tentang TSK',
                        'Mind mapping time dan email',
                        'Latihan interview profesional 3~5x',
                        'Informasi Database ke 12.000 TSK Jepang',
                    ],
                    'promoNote' => '3 bulan belum dapat job uang kembali!',
                    'disclaimerLines' => [],
                ],
                [
                    'name' => 'MATCHING JOB',
                    'description' => 'Program pencocokan karir buat kamu yang merasa siap kerja di Jepang',
                    'price' => 'RP. 7.000.000',
                    'highlight' => false,
                    'badge' => null,
                    'ctaLabel' => 'DAPATKAN SEKARANG',
                    'benefits' => [
                        'Dukungan pencarian Job',
                        'Dukungan konsultasi TSK',
                        'Dukungan konsultasi Email',
                        'Mind mapping time dan email',
                        'Dukungan aplikasi VISA',
                        'Dukungan aplikasi E-KTKLN (daftar bersama melalui zoom)',
                        'Dukungan saran hingga mendapatkan paspor',
                        'Dukungan saran hingga mendapatkan sertifikat medis (MCU)',
                        'Panduan sebelum keberangkatan',
                        'Bantuan pengiriman dokumen/ pemeliharaan dokumen, dll',
                    ],
                    'promoNote' => null,
                    'disclaimerLines' => [
                        'Biaya pembuatan paspor',
                        'Biaya Medical Check Up (MCU)',
                        'Biaya pengajuan E-KTKLN',
                        'Biaya pengajuan visa',
                        '(Biaya diatas ditanggung oleh individu yang bersangkutan)',
                    ],
                ],
                [
                    'name' => 'FULL BUNDLING',
                    'description' => 'Program terlengkap yang membimbing kamu dari nol (persiapan & edukasi) sampai bener-bener dapet kerja di Jepang. Solusi ideal untuk kamu yang ingin mendapatkan semua benefit sekaligus.',
                    'price' => 'RP. 8.000.000',
                    'highlight' => true,
                    'badge' => 'BEST VALUE',
                    'ctaLabel' => 'DAPATKAN SEKARANG',
                    'benefits' => [
                        'Kelas edukasi tentang Loker di jepang',
                        'Kelas edukasi tentang CV',
                        'Kelas edukasi tentang TSK',
                        'Mind mapping time dan email',
                        'Latihan interview profesional 3~5x',
                        'Informasi Database ke 12.000 TSK Jepang',
                        'Dukungan pencarian Job',
                        'Dukungan konsultasi TSK',
                        'Dukungan konsultasi Email',
                        'Mind mapping time dan email',
                        'Dukungan aplikasi VISA',
                        'Dukungan aplikasi E-KTKLN (daftar bersama melalui zoom)',
                        'Dukungan saran hingga mendapatkan paspor',
                        'Dukungan saran hingga mendapatkan sertifikat medis (MCU)',
                        'Panduan sebelum keberangkatan',
                        'Bantuan pengiriman dokumen/ pemeliharaan dokumen, dll',
                    ],
                    'promoNote' => null,
                    'disclaimerLines' => [],
                ],
            ],
        ]);
    }

    public function onlyEducation()
    {
        return view('landing.matching-job.education');
    }

    public function onlyMatchingJob()
    {
        return view('landing.matching-job.basic');
    }

    public function fullBundling()
    {
        return view('landing.matching-job.full');
    }
}
