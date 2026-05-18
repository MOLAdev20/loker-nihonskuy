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
                    'question' => 'Mengapa harus mengikuti program ini?',
                    'answer' => 'Banyak kandidat terjebak dalam ketidakpastian selama berbulan-bulan karena hanya menunggu lowongan tanpa strategi yang jelas. Di Nihonskuy, kami memutus rantai tersebut dengan membekali Anda persiapan matang—mulai dari pemahaman mendalam terkait kontrak dan detail pekerjaan untuk menghindari ketidakcocokan di kemudian hari. Kami memastikan Anda tidak sekadar melamar, tetapi memiliki kendali penuh untuk memilih peluang yang tepat dan sesuai dengan rencana karier jangka panjang Anda',
                ],
                [
                    'question' => 'Apakah peserta pemula bisa ikut?',
                    'answer' => 'Bisa. Asalkan memiliki persyaratan yang sesuai dengan loker yang dilamar atau minimal memiliki JFT A2 atau SSW.',
                ],
                [
                    'question' => 'Apakah ada tambahan biaya lain selain biaya di atas?',
                    'answer' => 'Tidak ada biaya tambahan selain biaya yang tertera sesuai dengan pricelist di atas. Akan tetapi, ada kemungkinan tambahan biaya jika kandidat melamar loker yang tidak menyediakan sarana seperti asrama atau tiket pesawat  .',
                ],
                [
                    'question' => 'Apakah ada jaminan kandidat akan mendapatkan pekerjaan?',
                    'answer' => 'Setiap keputusan diterima atau tidaknya kandidat, tergantung kenbali dari keputusan perusahaan. Akan tetapi, di Nihonskuy kami akan mengembalikan biaya yang sudah diberikan jika selama 3 bulan kandidat tidak mendapatkan pekerjaan sama sekali (sesuai dengan persyaratan dan ketentuan yang berlaku)',
                ],
            ],
            'packages' => [
                [
                    'name' => 'JOB EDUCATION',
                    'description' => 'Program ini merestrukturisasi setiap tahap persiapan Anda guna menciptakan keunggulan kompetitif yang nyata di mata rekruter global',
                    'price' => 'RP. 3.000.000',
                    'highlight' => false,
                    'badge' => null,
                    'benefits' => [
                        'Basic Orientation & Fundamentals',
                        'Resume Optimization',
                        'Interview Mastery',
                        'Japan Career Concierge',
                        'Legal Document Assistance',
                        'Flight Readiness Support',
                    ],
                    'disclaimerLines' => [],
                ],
                [
                    'name' => 'MATCHING JOB',
                    'description' => 'Program penempatan karier eksklusif yang menghubungkan kompetensi Anda secara langsung dengan jaringan lowongan terverifikasi dari ekosistem Nihonskuy',
                    'price' => 'RP. 7.000.000',
                    'highlight' => false,
                    'badge' => null,
                    'benefits' => [
                        'Job Search Assistance',
                        'TSK Consultation Support',
                        'Visa Application Guidance',
                        'E-KTKLN Registration Support',
                        'Passport Procurement Advice',
                        'Medical Certificate Assistance',
                        'Pre-Departure Briefing',
                        'Document Management Services',
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
                    'benefits' => [
                        'Japan Career Education',
                        'Professional CV Workshop',
                        'TSK Knowledge Session',
                        'Strategic Timeline Planning',
                        'Intensive Interview Coaching',
                        'Exclusive TSK Database',
                        'Job Placement Support',
                        'Expert TSK Consultation',
                        'Professional Email Correspondence',
                        'Visa Processing Guidance',
                        'E-KTKLN Assisted Registration',
                        'Passport Acquisition Support',
                        'Medical Certification Advice',
                        'Comprehensive Pre-Departure Guide',
                        'Document Handling Services',
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
