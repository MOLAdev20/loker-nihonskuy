@props(['dataJob'])

<article class="relative group rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-soft">
<a href="{{ route("vacancy.detail", $dataJob->job_code) }}" class="absolute inset-0 opacity-0 z-10"></a>
<div class="flex items-start justify-between gap-3">
<div class="min-w-0">
    <h3 class="truncate text-base font-semibold"><a href="/jobs/{{ $dataJob->job_code }}">{{ $dataJob->title }}</a></h3>
    <p class="mt-1 text-sm text-slate-600 flex items-center gap-2"><x-icons.map size="15" />{{ $dataJob->placement }}</p>
    <p class="mt-1 text-sm text-slate-600 flex items-center gap-2"><x-icons.folderInput size="15" />{{ $dataJob->visa_type }}</p>
</div>
</div>
<div class="border-t border-dashed border-slate-300 mt-3">
<div class="mt-1">
    <p class="text-xs text-slate-600">Syarat & Benefit</p>
    <div class="flex flex-wrap gap-2 mt-2">
    <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">
        {{ $dataJob->domicile_requirement == "kokunai" ? "Domisili Jepang" : "Domisili Indonesia" }}
    </span>
    <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">
        {{ $dataJob->gender_requirement == "p" ? "Perempuan" : ($dataJob->gender_requirement == "a" ? "Semua Gender" : "Laki-laki") }}
    </span>
    <span class="rounded-full border border-slate-200 bg-white px-2.5 py-1 text-[11px] text-slate-700">
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
    <li class="text-xs text-slate-600 ml-3 list-disc">
    {{ $benefit }}
    </li>
    @endforeach
</ul>
@endif
</div>
<div class="mt-4 flex items-center justify-between">
<div class="text-sm text-white font-semibold py-1 px-2 rounded-2xl bg-slate-500">{{ $dataJob->salary_range }}</div>
</div>
</article>