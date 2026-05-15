@extends('layouts.landing')

@push('header')
  <title>NihonSkuy - Full Bundling Program</title>
@endpush

@section('content')
  <section class="relative overflow-hidden px-4 pb-14 pt-10 sm:px-6 sm:pt-14">
    <div class="pointer-events-none absolute inset-0 -z-10">
      <div class="absolute -left-20 top-0 h-56 w-56 rounded-full bg-slate-200/60 blur-3xl"></div>
      <div class="absolute -right-24 bottom-0 h-72 w-72 rounded-full bg-emerald-100/70 blur-3xl"></div>
    </div>

    <div class="mx-auto grid max-w-6xl items-center gap-8 lg:grid-cols-2">
      <div>
        <p class="inline-flex rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-emerald-700">
          Program Edukasi Karir & Matching Job
        </p>
        <h1 class="mt-4 text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl">
          Edukasi Karir & Matching Job untuk kamu yang mau kerja di Jepang
        </h1>
        <p class="mt-4 text-sm leading-relaxed text-slate-600 sm:text-base">Bagi kamu yang berminat untuk kerja di Jepang, dari awal proses sampai keberangkatan ke Jepang, program full bundling ini mengintegrasikan persiapan edukasi karier yang komprehensif dengan pendampingan matching job dalam satu paket lengkap untuk memastikan transisi profesional yang lebih terukur.  Lewat program ini, kamu akan dibimbing secara intensif dari tahap persiapan hingga mendapatkan penempatan kerja, sehingga keterbatasan pengalaman bukan lagi menjadi penghalang untuk meraih peluang kerja di Jepang</p>

        <div class="mt-7 flex flex-col gap-3 sm:flex-row">
          <a href="https://wa.me/6289514161277?text=Halo%20NihonSkuy%2C%20saya%20tertarik%20program%20Full%20Bundling."
            class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
            Konsultasi Full Bundling
          </a>
          <a href="#rundown"
            class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
            Lihat Rundown
          </a>
        </div>
      </div>

      <div class="relative mx-auto w-full max-w-md lg:max-w-lg">
        <div class="pointer-events-none absolute inset-x-10 bottom-0 h-24 rounded-full bg-slate-300/50 blur-2xl"></div>
        <img
          src="{{ asset('mj.png') }}"
          alt="Ilustrasi program Full Bundling"
          class="relative z-10 mx-auto w-full object-contain mix-blend-multiply"
          loading="lazy" />
      </div>
    </div>
  </section>

  <section class="mx-auto max-w-6xl px-4 py-14 sm:px-6">
    <div class="max-w-2xl">
      <h2 class="text-2xl font-semibold tracking-tight text-slate-900">Mengapa Memilih Program Ini?</h2>
    </div>
    <p class="mt-6 max-w-4xl text-sm leading-relaxed text-slate-600 sm:text-base">
      Banyak calon tenaga kerja Indonesia menghadapi hambatan signifikan saat mencoba meniti karier di Jepang, terutama terkait ketidakpastian waktu tunggu lowongan pekerjaan yang berkepanjangan. Selain kendala efisiensi waktu, para kandidat sering kali terjebak dalam pengeluaran biaya yang tidak relevan serta menjadi sasaran biaya impulsif yang dibebankan oleh oknum-oknum tidak bertanggung jawab. Di sisi lain, terdapat masalah teknis berupa ketidakefisienan penyusunan resume (CV) yang tidak sesuai dengan standar pasar kerja di Jepang, yang berdampak pada rendahnya peluang keberhasilan tahap awal. Kurangnya kesiapan dalam menghadapi sesi wawancara dengan perusahaan Jepang serta kesulitan kandidat dalam menentukan arah karier yang selaras dengan latar belakang pendidikan maupun keahlian mereka, semakin memperkecil probabilitas penerimaan kerja di lingkungan profesional yang kompetitif tersebut.
    </p>

    <p class="mt-6 max-w-4xl text-sm leading-relaxed text-slate-600 sm:text-base">
      Sebagai upaya mitigasi terhadap berbagai kendala tersebut, program Full Bundling hadir dengan mengintegrasikan persiapan edukasi karier dan pendampingan matching job dalam satu paket layanan yang komprehensif. Program ini dirancang untuk meminimalisir biaya yang tidak diperlukan melalui transparansi anggaran, sekaligus memastikan setiap kandidat memiliki resume yang optimal dan sesuai dengan ekspektasi industri di Jepang. Melalui pendampingan persiapan wawancara yang terukur, kandidat diharapkan mampu memberikan performa terbaik di hadapan pemberi kerja, sehingga peluang penerimaan meningkat secara signifikan. Dengan pendekatan yang berorientasi pada latar belakang individu, solusi ini menyediakan jalur yang lebih menyeluruh, efektif, dan profesional bagi warga Indonesia dalam mewujudkan karier impian mereka di Jepang.
    </p>
  </section>

  <section id="rundown" class="bg-white py-14">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
      <div class="max-w-2xl">
        <h2 class="text-2xl font-semibold tracking-tight text-slate-900">Rundown Kegiatan Konsultasi</h2>
      </div>

      @php
        $rundowns = [
            ['day' => 'Hari 1', 'title' => 'Japan Job Market & TSK Ecosystem', 'items' => ['Edukasi jenis-jenis loker di Jepang (SSW, Magang, Engineering).', 'Bedah ekosistem TSK (Registered Support Organization) dan hak pekerja.']],
            ['day' => 'Hari 2', 'title' => 'TSK Database & Market Research', 'items' => ['Akses ke Informasi Database 12.000 TSK Jepang.', 'Teknik memfilter TSK berdasarkan prefektur dan bidang pekerjaan.']],
            ['day' => 'Hari 3', 'title' => 'Japanese Standard CV Workshop', 'items' => ['Edukasi pembuatan CV & Rirekisho standar industri Jepang.', 'Workshop digitalisasi dan pemeliharaan dokumen agar siap kirim.']],
            ['day' => 'Hari 4', 'title' => 'Time Management & Professional Correspondence', 'items' => ['Sesi Mind Mapping Time & Email: Mengatur jadwal apply dan template email profesional.', 'Dukungan konsultasi email (Copywriting lamaran agar dilirik HR).']],
            ['day' => 'Hari 5', 'title' => 'Interview Etiquette & Mindset', 'items' => ['Edukasi etika interview (aisatsu, ojigi) dan mindset menjawab pertanyaan user Jepang.']],
            ['day' => 'Hari 6', 'title' => 'Mock Interview I: Self-Introduction', 'items' => ['Latihan interview profesional ke-1 (Perkenalan diri & motivasi).', 'Feedback langsung dan perbaikan kelemahan.']],
            ['day' => 'Hari 7', 'title' => 'Mock Interview II & III: Technical Q&A', 'items' => ['Latihan interview profesional ke-2 & ke-3 (Studi kasus dan pertanyaan teknis).', 'Optimasi jawaban berdasarkan pengalaman kerja peserta.']],
            ['day' => 'Hari 8', 'title' => 'Mock Interview IV & V: Final Assessment', 'items' => ['Latihan interview profesional ke-4 & ke-5 (Simulasi final).', 'Konsultasi khusus mengenai kendala spesifik peserta.']],
            ['day' => 'Hari 9', 'title' => 'Active Job Application & TSK Consultation', 'items' => ['Praktik kirim lamaran masif ke database TSK yang sudah dipilih.', 'Dukungan konsultasi TSK: Cara berkomunikasi efektif dengan staf TSK di Jepang.']],
            ['day' => 'Hari 10', 'title' => 'Follow-up Strategy & Progress Tracking', 'items' => ['Edukasi teknik follow up lamaran yang sudah dikirim ke TSK.', 'Final review kesiapan mental dan administrasi sebelum fase rekrutmen nyata.']],
        ];
      @endphp

      <div class="rundown-swiper swiper mt-8">
        <div class="swiper-wrapper pb-2">
          @foreach ($rundowns as $rundown)
            <div class="swiper-slide h-auto">
              <article class="relative h-full pt-9">
                <div class="absolute top-3 h-0.5 bg-slate-300 {{ $loop->first ? 'left-1/2 right-0' : ($loop->last ? 'left-0 right-1/2' : 'left-0 right-0') }}"></div>
                <div class="absolute left-1/2 top-3 h-4 w-4 -translate-x-1/2 -translate-y-1/2 rounded-full border-2 border-white bg-slate-900 shadow-sm"></div>
                <div class="mx-2 flex h-full flex-col rounded-2xl border border-slate-200 bg-slate-50 p-5">
                  <div class="inline-flex w-fit rounded-full border border-slate-300 bg-white px-3 py-1 text-xs font-semibold text-slate-700">{{ $rundown['day'] }}</div>
                  <h3 class="mt-3 text-base font-semibold tracking-tight text-slate-900">{{ $rundown['title'] }}</h3>
                  <ul class="mt-4 space-y-3 text-sm leading-relaxed text-slate-600">
                    @foreach ($rundown['items'] as $item)
                      <li class="flex items-start gap-2"><span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-slate-400"></span><span>{{ $item }}</span></li>
                    @endforeach
                  </ul>
                </div>
              </article>
            </div>
          @endforeach
        </div>
      </div>

      <div class="mt-5 flex items-center justify-between">
        <div class="rundown-swiper-pagination"></div>
        <div class="flex items-center gap-2">
          <button type="button" class="rundown-swiper-prev inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 transition hover:bg-slate-50" aria-label="Slide sebelumnya">
            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6" /></svg>
          </button>
          <button type="button" class="rundown-swiper-next inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 transition hover:bg-slate-50" aria-label="Slide berikutnya">
            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6" /></svg>
          </button>
        </div>
      </div>
    </div>
  </section>

  <section class="pb-16 pt-2">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
      <div class="rounded-3xl bg-slate-900 p-8 text-center sm:p-10">
        <h2 class="text-2xl font-semibold tracking-tight text-white">Mulai Perjalanan Masa Depan Kamu</h2>
        <p class="mx-auto mt-3 max-w-2xl text-sm leading-relaxed text-slate-200 sm:text-base">
          Kamu bisa mulai mencapai target kamu bersama tim NihonSkuy dengan penawaran spesial
        </p>
        <div class="my-10">
          <p class="text-2xl text-red-400 line-through animate-pulse">RP. 9.000.000</p>
          <p class="text-5xl font-semibold uppercase text-white">RP. 8.000.000</p>
        </div>
        <a href="https://wa.me/6289514161277?text=Halo%20NihonSkuy%2C%20saya%20tertarik%20program%20Career%20Education."
          class="mt-6 inline-flex items-center justify-center rounded-xl bg-white px-6 py-3 text-sm font-semibold text-slate-900 transition hover:bg-slate-100">
          Konsultasi Career Education
        </a>
      </div>
    </div>
  </section>
@endsection
