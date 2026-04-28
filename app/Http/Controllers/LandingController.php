<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LandingController extends Controller
{
    public function matchingJob()
    {
        return view('landing.matching-job', [
            'whatsappUrl' => 'https://wa.me/6289514161277?text=Halo%20NihonSkuy%2C%20saya%20tertarik%20kelas%20konsultasi%20matching%20job.',
            'programIntroduction' => 'Program ini dirancang untuk membantu peserta memahami jalur kerja ke Jepang secara terstruktur, mulai dari pemetaan target karier, penguatan dokumen lamaran, hingga kesiapan menghadapi seleksi perusahaan. Pendampingan dilakukan secara praktis agar setiap langkah dapat langsung diterapkan sesuai kondisi peserta.',
            'infoSections' => [
                [
                    'title' => 'Analisis Profil Karier',
                    'description' => 'Sesi awal untuk memetakan pengalaman, kemampuan, dan target kerja agar strategi lamaran lebih tepat sasaran.',
                ],
                [
                    'title' => 'Strategi Dokumen Lamaran',
                    'description' => 'Pendampingan menyusun CV, ringkasan profil, dan dokumen pendukung agar sesuai ekspektasi perusahaan Jepang.',
                ],
                [
                    'title' => 'Persiapan Seleksi',
                    'description' => 'Latihan menghadapi proses interview dan evaluasi akhir supaya peserta lebih percaya diri saat melamar.',
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
                    'name' => 'KELAS MATCHING',
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
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
                    'promoNote' => 'Promosi : 3 bulan belum dapat job uang kembali !',
                    'disclaimerLines' => [],
                ],
                [
                    'name' => 'MATCHING JOB',
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
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
                    'name' => 'PAKET MATCHING JOB',
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
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

    public function index()
    {
        $jobs = Vacancy::where(["status" => 1])->latest()->take(6)->get();
        $urgentJobs = Vacancy::query()
            ->where("status", 1)
            ->withTag("urgent")
            ->latest()
            ->take(12)
            ->get();

        return view('landing.main', [
            'jobs' => $jobs,
            'urgentJobs' => $urgentJobs,
        ]);
    }

    public function explore(Request $request)
    {
        $query = Vacancy::query();

        if ($request->filled('q')) {
            $keyword = $request->string('q')->toString();
            $query->where(function ($builder) use ($keyword) {
                $builder->where('title', 'like', "%{$keyword}%")
                    ->orWhere('job_code', 'like', "%{$keyword}%")
                    ->orWhere('visa_type', 'like', "%{$keyword}%")
                    ->orWhere('job_type', 'like', "%{$keyword}%")
                    ->orWhere('placement', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('location')) {
            $location = $request->string('location')->toString();
            $query->where('placement', 'like', "%{$location}%");
        }

        $jobs = $query->where(['status' => 1])->latest()->paginate(12)->withQueryString();

        return view('landing.explore', [
            'jobs' => $jobs,
            'totalJobs' => Vacancy::count(),
        ]);
    }

    public function detail($id)
    {
        $job = Vacancy::where('job_code', $id)->firstOrFail();

        return view('landing.detail', [
            'job' => $job,
        ]);
    }
}
