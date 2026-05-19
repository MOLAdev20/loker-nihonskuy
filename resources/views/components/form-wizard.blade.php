@props(['steps' => []])

<nav aria-label="Progress form profile"
  class="mb-5 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
  <ol class="grid grid-cols-1 gap-3 sm:grid-cols-4">
    @foreach ($steps as $step)
      @php
        $isAccessible = $step['isAccessible'] ?? true;
        $route = $isAccessible ? $step['route'] : '#';
        $itemClass = $isAccessible
            ? 'group flex items-center gap-3 rounded-xl border border-transparent px-2 py-2 transition hover:border-slate-200 hover:bg-slate-50'
            : 'flex cursor-not-allowed items-center gap-3 rounded-xl border border-transparent px-2 py-2 opacity-70';

        $circleClass = 'border-slate-300 text-slate-500';
        $stepLabelClass = 'text-slate-500';

        if ($step['isCompleted']) {
            $circleClass = 'border-emerald-500 bg-emerald-500 text-white';
            $stepLabelClass = 'text-emerald-700';
        } elseif ($step['isActive']) {
            $circleClass = 'border-emerald-500 text-emerald-600';
            $stepLabelClass = 'text-emerald-700';
        }
      @endphp
      <li>
        <a href="{{ $route }}" @if (! $isAccessible) aria-disabled="true" @endif
          class="{{ $itemClass }}">
          <span
            class="{{ $circleClass }} inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full border-2 text-sm font-semibold">
            {{ $step['number'] }}
          </span>
          <span class="{{ $stepLabelClass }} text-sm font-medium">{{ $step['label'] }}</span>
        </a>
      </li>
    @endforeach
  </ol>
</nav>
