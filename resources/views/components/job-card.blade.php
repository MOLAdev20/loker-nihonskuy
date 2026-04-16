@props(['dataJob'])

<article
  class="hover:shadow-soft group relative rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5">
  <a href="{{ route('vacancy.detail', $dataJob->job_code) }}"
    class="absolute inset-0 z-10 opacity-0"></a>
  <div class="flex items-start justify-between gap-3">
    <div class="min-w-0">
      <h3 class="runcate mb-2 text-wrap text-lg font-semibold"><a
          href="/jobs/{{ $dataJob->job_code }}">{{ $dataJob->title }}</a></h3>
      <p class="mt-1 flex items-center gap-2 text-sm text-slate-600"><x-icons.map
          size="15" />{{ $dataJob->placement }}</p>
      <p class="mt-1 flex items-center gap-2 text-sm text-slate-600"><x-icons.folderInput
          size="15" />{{ $dataJob->visa_type }}</p>
    </div>
  </div>
  <div class="mt-3 border-t border-dashed border-slate-300">
    <div class="mt-1">
      <p class="text-xs text-slate-600">Syarat & Benefit</p>
      <div class="mt-2 flex flex-wrap gap-2">
        <span
          class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">
          {{ $dataJob->domicile_requirement == 'kokunai' ? 'Domisili Jepang' : 'Domisili Indonesia' }}
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
