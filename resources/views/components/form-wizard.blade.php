@props([
  "candidateId" => 61
])

<nav aria-label="Progress form profile"
  class="mb-5 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
  <ol class="grid grid-cols-1 gap-3 sm:grid-cols-4">
    <li>
      <a href="{{ route('admin.users.interview-answer.index', $candidateId) }}" class="group flex items-center gap-3 rounded-xl border border-transparent px-2 py-2 transition hover:[&_.step-number]:border-emerald-700 hover:[&_.step-number]:bg-emerald-700">
        <span
          class="step-number border-emerald-500 bg-emerald-500 text-white inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full border-2 text-sm font-semibold">
          1
        </span>
        <span class="text-emerald-700 text-sm font-medium">Pertanyaan Interview</span>
      </a>
    </li>
    <li>
      <a href="{{ route('admin.users.profile.form', $candidateId) }}" class="group flex items-center gap-3 rounded-xl border border-transparent px-2 py-2 transition hover:[&_.step-number]:border-emerald-700 hover:[&_.step-number]:bg-emerald-700">
        <span
          class="step-number border-emerald-500 bg-emerald-500 text-white inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full border-2 text-sm font-semibold">
          2
        </span>
        <span class="text-emerald-700 text-sm font-medium">Profil Pribadi</span>
      </a>
    </li>
    <li>
      <a href="" class="group flex items-center gap-3 rounded-xl border border-transparent px-2 py-2 transition hover:[&_.step-number]:border-emerald-700 hover:[&_.step-number]:bg-emerald-700">
        <span
          class="step-number border-emerald-500 bg-emerald-500 text-white inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full border-2 text-sm font-semibold">
          1
        </span>
        <span class="text-emerald-700 text-sm font-medium">Pertanyaan Interview</span>
      </a>
    </li>
    <li>
      <a href="" class="group flex items-center gap-3 rounded-xl border border-transparent px-2 py-2 transition hover:[&_.step-number]:border-emerald-700 hover:[&_.step-number]:bg-emerald-700">
        <span
          class="step-number border-emerald-500 bg-emerald-500 text-white inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full border-2 text-sm font-semibold">
          1
        </span>
        <span class="text-emerald-700 text-sm font-medium">Pertanyaan Interview</span>
      </a>
    </li>
  </ol>
</nav>
