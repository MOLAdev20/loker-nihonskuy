@extends('layouts.user-dashboard')

@section('title', 'Pertanyaan Interview')

@section('content_header', 'Pertanyaan Interview')

@section('content_subheader', 'Lengkapi jawaban interview agar proses kandidat dapat dilanjutkan ke tahap konfirmasi.')

@section('content')
  @php
    $inputClass =
        'mt-2 block w-full rounded-xl border bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm placeholder:text-slate-400 focus:outline-none focus:ring-2';
    $labelClass = 'text-sm font-medium text-slate-700';
    $canGoNext = (bool) $canGoNext;

    $questionGroups = [
        [
            'title' => 'Pengalaman Kerja Sebelumnya',
            'description' => 'Berikan konteks yang jelas tentang pengalaman kerja Anda di Jepang.',
            'items' => [
                [
                    'field' => 'workHistory',
                    'column' => 'work_history',
                    'label' => '1. Bisa ceritakan pengalaman kerja Anda sebelumnya di Jepang? (Nama perusahaan, bidang, durasi, dan tugas utama).',
                    'placeholder' => 'Tuliskan nama perusahaan, bidang kerja, durasi, dan tugas utama Anda.',
                ],
                [
                    'field' => 'technicalSkills',
                    'column' => 'technical_skills',
                    'label' => '2. Keterampilan atau skill teknis apa saja yang paling berkesan dan berhasil Anda kuasai dari pekerjaan tersebut?',
                    'placeholder' => 'Jelaskan skill teknis yang paling Anda kuasai dan contoh penggunaannya.',
                ],
                [
                    'field' => 'commChallenges',
                    'column' => 'comm_challenges',
                    'label' => '3. Selama bekerja di sana, situasi komunikasi seperti apa yang menurut Anda paling menantang atau sulit dihadapi?',
                    'placeholder' => 'Ceritakan situasi komunikasi yang paling menantang dan bagaimana Anda menghadapinya.',
                ],
                [
                    'field' => 'leaveReason',
                    'column' => 'leave_reason',
                    'label' => '4. Apa alasan utama Anda memutuskan untuk mencari pekerjaan baru dan keluar dari bidang/perusahaan sebelumnya?',
                    'placeholder' => 'Jelaskan alasan utama Anda mencari pekerjaan baru.',
                ],
            ],
        ],
        [
            'title' => 'Alasan dan Persiapan',
            'description' => 'Tunjukkan alasan Anda memilih bidang baru dan langkah yang sudah dilakukan.',
            'items' => [
                [
                    'field' => 'applyReason',
                    'column' => 'apply_reason',
                    'label' => '5. Mengapa Anda tertarik untuk melamar di bidang yang baru ini? Apa yang membuat bidang ini menarik bagi Anda?',
                    'placeholder' => 'Tuliskan alasan Anda tertarik pada bidang baru ini.',
                ],
                [
                    'field' => 'careerPrep',
                    'column' => 'career_prep',
                    'label' => '6. Bagaimana proses atau persiapan yang sudah Anda lakukan hingga akhirnya mantap memutuskan melamar di bidang ini sekarang?',
                    'placeholder' => 'Jelaskan proses belajar, riset, atau persiapan yang sudah dilakukan.',
                ],
                [
                    'field' => 'personalityReview',
                    'column' => 'personality_review',
                    'label' => '7. Bagaimana rekan kerja atau atasan di perusahaan lama biasanya menggambarkan kepribadian Anda?',
                    'placeholder' => 'Tulis gambaran diri Anda menurut rekan kerja atau atasan.',
                ],
                [
                    'field' => 'problemSolving',
                    'column' => 'problem_solving',
                    'label' => '8. Ketika menghadapi kendala berat atau tekanan dalam pekerjaan, bagaimana cara Anda mengatasinya?',
                    'placeholder' => 'Ceritakan cara Anda mengatasi tekanan kerja atau kendala berat.',
                ],
            ],
        ],
        [
            'title' => 'Motivasi dan Target',
            'description' => 'Jelaskan motivasi bertahan, target kerja, dan rencana jangka panjang Anda.',
            'items' => [
                [
                    'field' => 'stayMotivation',
                    'column' => 'stay_motivation',
                    'label' => '9. Apa motivasi terbesar yang membuat Anda mampu bertahan menyelesaikan kontrak kerja sebelumnya dengan baik?',
                    'placeholder' => 'Jelaskan motivasi terbesar Anda untuk menyelesaikan kontrak dengan baik.',
                ],
                [
                    'field' => 'learningGoals',
                    'column' => 'learning_goals',
                    'label' => '10. Apa saja hal baru yang ingin Anda pelajari dan kuasai dari pekerjaan di bidang ini?',
                    'placeholder' => 'Tuliskan hal baru yang ingin Anda pelajari dari pekerjaan ini.',
                ],
                [
                    'field' => 'japanTargets',
                    'column' => 'japan_targets',
                    'label' => '11. Apa target atau goals Anda selama bekerja di Jepang untuk beberapa tahun ke depan?',
                    'placeholder' => 'Jelaskan target kerja Anda di Jepang dalam beberapa tahun ke depan.',
                ],
                [
                    'field' => 'longTermDream',
                    'column' => 'long_term_dream',
                    'label' => '12. Setelah selesai bekerja di Jepang nanti, apa impian jangka panjang Anda dan bagaimana Anda akan memanfaatkan pengalaman tersebut di Indonesia?',
                    'placeholder' => 'Tuliskan rencana jangka panjang Anda setelah kembali ke Indonesia.',
                ],
            ],
        ],
    ];
  @endphp

  @if (session('status'))
    <div
      class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
      {{ session('status') }}
    </div>
  @endif

  <x-form-wizard :steps="$wizardSteps" />

  <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
    <header class="border-b border-slate-200 px-4 py-4 sm:px-6">
      <h2 class="text-base font-semibold text-slate-900">Jawaban Interview Pekerjaan</h2>
      <p class="mt-1 text-sm text-slate-500">
        Jawab setiap pertanyaan secara jujur dan jelas. Semua jawaban akan dipakai sebagai bahan
        pertimbangan kandidat.
      </p>
    </header>

    <form method="POST" action="{{ route('user.interview-answer.store') }}" class="space-y-6 p-4 sm:p-6">
      @csrf

      @foreach ($questionGroups as $group)
        <section class="rounded-2xl border border-slate-200 bg-slate-50/70 p-4 sm:p-5">
          <div class="mb-4">
            <h3 class="text-sm font-semibold text-slate-900">{{ $group['title'] }}</h3>
            <p class="mt-1 text-sm text-slate-500">{{ $group['description'] }}</p>
          </div>

          <div class="space-y-4">
            @foreach ($group['items'] as $item)
              <div>
                <label class="{{ $labelClass }}" for="{{ $item['field'] }}">{{ $item['label'] }}
                  <span class="text-red-600">*</span></label>
                <textarea id="{{ $item['field'] }}" name="{{ $item['field'] }}" rows="5"
                  class="{{ $inputClass }} min-h-[140px] resize-y @error($item['field']) border-red-500 focus:border-red-500 focus:ring-red-100 @else border-slate-300 focus:border-slate-400 focus:ring-slate-100 @enderror"
                  placeholder="{{ $item['placeholder'] }}">{{ old($item['field'], $interviewAnswer?->{$item['column']} ?? '') }}</textarea>
                @error($item['field'])
                  <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
              </div>
            @endforeach
          </div>
        </section>
      @endforeach

      <div class="flex flex-col gap-3 border-t border-slate-200 pt-4 sm:flex-row sm:items-center sm:justify-between">
        <a href="{{ route('user.working-experience') }}"
          class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
          Sebelumnya: Riwayat Pekerjaan
        </a>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
          <button type="submit"
            class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
            Simpan Jawaban Interview
          </button>

          @if ($canGoNext)
            <a href="{{ route('users.confirm') }}"
              class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700">
              Selanjutnya: Konfirmasi
            </a>
          @else
            <button type="button" disabled
              class="inline-flex cursor-not-allowed items-center justify-center rounded-xl bg-slate-300 px-4 py-2.5 text-sm font-semibold text-white">
              Selanjutnya: Konfirmasi
            </button>
          @endif
        </div>
      </div>
    </form>
  </section>
@endsection
