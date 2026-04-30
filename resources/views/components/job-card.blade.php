@props(['dataJob'])

<article
  class="hover:shadow-soft group relative rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5">
  <a href="{{ route('vacancy.detail', $dataJob->job_code) }}"
    class="absolute inset-0 z-10 opacity-0"></a>
  <div>
    <h3 class="runcate mb-2 text-wrap text-lg font-semibold"><a
        href="/jobs/{{ $dataJob->job_code }}">{{ $dataJob->title }}</a></h3>
    <div class="flex items-start justify-between gap-3">
      <div class="min-w-0 flex-1">
      <p class="mt-1 flex items-center gap-2 text-sm text-slate-600"><x-icons.map
          size="15" />{{ $dataJob->placement . ($dataJob->placement_branch ? ' - ' . $dataJob->placement_branch : '') }}
      </p>
      <p class="mt-1 flex items-center gap-2 text-sm text-slate-600"><x-icons.folderInput
          size="15" />{{ $dataJob->job_type }}</p>
      </div>
    </div>
  </div>
  <div class="mt-3 border-t border-dashed border-slate-300">
    <div class="mt-1">
      <p class="text-xs text-slate-600">Syarat & Benefit</p>
      <div class="mt-2 flex flex-wrap gap-2">
        @php
          $jlptBadgeClass = [
              'n1' => 'border-amber-300 bg-amber-100 text-amber-800',
              'n2' => 'border-slate-300 bg-slate-200 text-slate-700',
              'n3' => 'border-blue-300 bg-blue-100 text-blue-800',
              'n4' => 'border-rose-300 bg-rose-100 text-rose-800',
              'n5' => 'border-emerald-300 bg-emerald-100 text-emerald-800',
          ][$dataJob->jlpt_requirement] ?? 'border-slate-300 bg-slate-100 text-slate-700';

          $kaiwaBadgeClass = [
              'n4' => 'border-rose-300 bg-rose-100 text-rose-800',
              'n3' => 'border-blue-300 bg-blue-100 text-blue-800',
              'n2' => 'border-slate-300 bg-slate-200 text-slate-700',
          ][$dataJob->kaiwa_requirement] ?? 'border-cyan-300 bg-cyan-100 text-cyan-800';
        @endphp
        <span
          class="rounded-full border px-2.5 py-1 text-[11px] font-medium {{ $jlptBadgeClass }}">
          JLPT {{ $dataJob->jlpt_requirement_label }}
        </span>
        <span
          class="rounded-full border px-2.5 py-1 text-[11px] font-medium {{ $kaiwaBadgeClass }}">
          Kaiwa {{ $dataJob->kaiwa_requirement_label }}
        </span>
        <span
          class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">
          {{ $dataJob->domicile }}
        </span>
        <span
          class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">
          {{ $dataJob->gender_requirement == 'p' ? 'Perempuan' : ($dataJob->gender_requirement == 'a' ? 'Semua Gender' : 'Laki-laki') }}
        </span>
        <span
          class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">
          {{ $dataJob->qty }} orang
        </span>
      </div>
    </div>
    @php
      $benefits = $dataJob->benefit ? array_filter(explode('|', $dataJob->benefit)) : [];
    @endphp
    @if (count($benefits))
      <ul class="mt-3">
        @foreach ($benefits as $benefit)
          <li class="ml-3 list-disc text-xs text-slate-600">
            {{ $benefit }}
          </li>
        @endforeach
      </ul>
    @endif
  </div>
  <div class="mt-4 flex items-center justify-between">
    <div class="animate-bounce rounded-2xl bg-blue-900 px-2 py-1 text-sm font-extrabold text-white">
      {{ $dataJob->salary_range }}</div>
  </div>
</article>
