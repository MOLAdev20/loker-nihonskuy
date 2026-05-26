@extends('layouts.admin')

@push('title')
  <title>NihonSkuy - Loker Prioritas</title>
@endpush

@section('content')
  <div class="mb-5">
    <nav class="mb-4 text-sm" aria-label="Breadcrumb">
      <ol class="flex items-center gap-2 text-slate-500">
        <li>
          <a href="#" class="hover:text-slate-700">Dashboard</a>
        </li>
        <li class="flex items-center gap-2">
          <span class="text-slate-400">/</span>
          <a href="{{ route('admin.vacancies') }}" class="hover:text-slate-700">Loker</a>
        </li>
        <li class="flex items-center gap-2">
          <span class="text-slate-400">/</span>
          <span class="font-medium text-slate-700">Loker Prioritas</span>
        </li>
      </ol>
    </nav>

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Loker Prioritas</h1>
        <p class="mt-2 text-sm text-slate-500">Kelola daftar loker urgent yang tampil di landing page.</p>
      </div>
      <div>
        <a href="{{ route('admin.vacancies') }}"
          class="inline-flex items-center justify-center rounded border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">
          Kembali ke Daftar Loker
        </a>
      </div>
    </div>
  </div>

  @if ($errors->any())
    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
      {{ $errors->first() }}
    </div>
  @endif

  <div class="grid gap-5 xl:grid-cols-[380px_minmax(0,1fr)]">
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
      <h2 class="text-lg font-semibold text-slate-900">Tambah Loker Prioritas</h2>
      <p class="mt-1 text-sm text-slate-500">Pilih loker dari database untuk dimasukkan ke section `Dibutuhkan Segera`.</p>

      <form method="POST" action="{{ route('admin.vacancy.urgent.store') }}" class="mt-5 space-y-4">
        @csrf
        <div>
          <label for="job_id" class="mb-2 block text-sm font-medium text-slate-700">Pilih Loker</label>
          <select id="job_id" name="job_id"
            class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-slate-300 focus:ring-4 focus:ring-slate-100">
            <option value="">Pilih lowongan kerja</option>
            @foreach ($availableVacancies as $vacancy)
              <option value="{{ $vacancy->id }}" @selected((string) old('job_id') === (string) $vacancy->id)>
                {{ $vacancy->job_code }} - {{ $vacancy->title }}{{ $vacancy->status ? '' : ' [Nonaktif]' }}
              </option>
            @endforeach
          </select>
        </div>

        <button type="submit"
          class="inline-flex w-full items-center justify-center rounded-xl bg-slate-800 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-900">
          Tambahkan ke Loker Prioritas
        </button>
      </form>

      @if ($availableVacancies->isEmpty())
        <div class="mt-4 rounded-xl border border-dashed border-slate-200 bg-slate-50 px-4 py-4 text-sm text-slate-500">
          Semua loker yang tersedia sudah masuk ke daftar prioritas.
        </div>
      @endif
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
      <div class="flex flex-col gap-3 border-b border-slate-100 pb-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h2 class="text-lg font-semibold text-slate-900">Urutan Tampil Landing Page</h2>
          <p class="mt-1 text-sm text-slate-500">Drag and drop untuk mengatur prioritas dari urutan paling atas.</p>
        </div>
        <form method="POST" action="{{ route('admin.vacancy.urgent.order') }}" id="save-urgent-order-form">
          @csrf
          @method('PATCH')
          <button type="submit" id="save-urgent-order-button"
            @disabled($urgentVacancies->count() < 2)
            class="inline-flex items-center justify-center rounded-xl bg-slate-800 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-900 disabled:cursor-not-allowed disabled:bg-slate-300">
            Simpan Urutan
          </button>
        </form>
      </div>

      @if ($urgentVacancies->isEmpty())
        <div class="mt-5 rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-6 py-10 text-center text-sm text-slate-500">
          Belum ada loker prioritas yang dipilih.
        </div>
      @else
        <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
          Loker dengan urutan paling atas akan ditampilkan lebih dulu di section `Dibutuhkan Segera`.
        </div>

        <div id="urgent-vacancy-list" class="mt-5 space-y-3">
          @foreach ($urgentVacancies as $urgentVacancy)
            @php
              $vacancy = $urgentVacancy->vacancy;
            @endphp
            <div
              class="rounded-2xl border border-slate-200 bg-white p-4 transition"
              data-urgent-item
              data-urgent-id="{{ $urgentVacancy->id }}"
              draggable="true">
              <div class="flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
                <div class="flex items-start gap-3">
                  <div class="mt-1 flex shrink-0 items-center gap-1">
                    <button type="button"
                      class="inline-flex h-10 w-10 cursor-grab items-center justify-center rounded-xl border border-slate-200 bg-slate-50 text-slate-500 active:cursor-grabbing"
                      aria-label="Geser urutan"
                      title="Geser urutan">
                      <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 6h.01M9 12h.01M9 18h.01M15 6h.01M15 12h.01M15 18h.01" stroke-linecap="round" />
                      </svg>
                    </button>
                    <div class="flex flex-col gap-1">
                      <button type="button"
                        data-move-up
                        class="inline-flex h-5 w-7 items-center justify-center rounded-md border border-slate-200 bg-white text-slate-500 hover:bg-slate-50"
                        aria-label="Naikkan urutan"
                        title="Naikkan urutan">
                        <svg viewBox="0 0 24 24" class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2">
                          <path d="M18 15l-6-6-6 6" />
                        </svg>
                      </button>
                      <button type="button"
                        data-move-down
                        class="inline-flex h-5 w-7 items-center justify-center rounded-md border border-slate-200 bg-white text-slate-500 hover:bg-slate-50"
                        aria-label="Turunkan urutan"
                        title="Turunkan urutan">
                        <svg viewBox="0 0 24 24" class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2">
                          <path d="M6 9l6 6 6-6" />
                        </svg>
                      </button>
                    </div>
                  </div>

                  <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-2">
                      <span class="inline-flex items-center rounded-full bg-slate-900 px-2.5 py-1 text-xs font-semibold text-white">
                        Urutan <span class="ml-1" data-position-label>{{ $loop->iteration }}</span>
                      </span>
                      @if ($vacancy && (int) $vacancy->status === 1)
                        <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">Aktif</span>
                      @else
                        <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700">Nonaktif</span>
                      @endif
                    </div>

                    <div class="mt-3">
                      <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        {{ $vacancy?->job_code ?? 'Data loker tidak ditemukan' }}
                      </p>
                      <h3 class="mt-1 text-base font-semibold text-slate-900">
                        {{ $vacancy?->title ?? 'Loker terhapus dari database' }}
                      </h3>
                      <p class="mt-1 text-sm text-slate-500">
                        {{ $vacancy?->placement ?? '-' }}{{ $vacancy?->placement_branch ? ' - ' . $vacancy->placement_branch : '' }}
                      </p>
                    </div>
                  </div>
                </div>

                <div class="flex items-center gap-2">
                  @if ($vacancy)
                    <a href="{{ route('admin.vacancy.detail', $vacancy->job_code) }}"
                      class="inline-flex items-center justify-center rounded-lg border border-slate-200 px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">
                      Detail
                    </a>
                  @endif

                  <form method="POST" action="{{ route('admin.vacancy.urgent.destroy', $urgentVacancy) }}"
                    id="remove-urgent-vacancy-{{ $urgentVacancy->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                      onclick="confirmRemoveUrgentVacancy('remove-urgent-vacancy-{{ $urgentVacancy->id }}')"
                      class="inline-flex items-center justify-center rounded-lg border border-red-200 px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50">
                      Hapus
                    </button>
                  </form>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </div>
  </div>
@endsection

@section('scripts')
  <script type="module">
    @if (session('msg'))
      const config = @js(session('msg'));
      Swal.fire(config[1], config[2], config[0]);
    @endif
  </script>
  <script>
    function confirmRemoveUrgentVacancy(formId) {
      Swal.fire({
        title: 'Hapus dari Loker Prioritas?',
        text: 'Data loker asli tidak akan ikut terhapus.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#b91c1c',
        cancelButtonColor: '#64748b',
        reverseButtons: true,
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById(formId).submit();
        }
      });
    }

    const urgentList = document.getElementById('urgent-vacancy-list');
    const saveOrderForm = document.getElementById('save-urgent-order-form');
    const saveOrderButton = document.getElementById('save-urgent-order-button');

    if (urgentList && saveOrderForm && saveOrderButton) {
      let draggedItem = null;
      let initialOrder = getCurrentOrder();

      refreshPositionLabels();
      syncSaveButton();

      urgentList.querySelectorAll('[data-urgent-item]').forEach((item) => {
        item.addEventListener('dragstart', () => {
          draggedItem = item;
          item.classList.add('opacity-60');
          item.classList.add('ring-2');
          item.classList.add('ring-slate-200');
        });

        item.addEventListener('dragend', () => {
          item.classList.remove('opacity-60');
          item.classList.remove('ring-2');
          item.classList.remove('ring-slate-200');
          draggedItem = null;
          refreshPositionLabels();
          syncSaveButton();
        });
      });

      urgentList.addEventListener('dragover', (event) => {
        event.preventDefault();

        if (!draggedItem) {
          return;
        }

        const afterElement = getDragAfterElement(urgentList, event.clientY);

        if (!afterElement) {
          urgentList.appendChild(draggedItem);
          return;
        }

        urgentList.insertBefore(draggedItem, afterElement);
      });

      urgentList.addEventListener('click', (event) => {
        const moveUpButton = event.target.closest('[data-move-up]');
        const moveDownButton = event.target.closest('[data-move-down]');

        if (!moveUpButton && !moveDownButton) {
          return;
        }

        const currentItem = event.target.closest('[data-urgent-item]');

        if (!currentItem) {
          return;
        }

        if (moveUpButton && currentItem.previousElementSibling) {
          urgentList.insertBefore(currentItem, currentItem.previousElementSibling);
        }

        if (moveDownButton && currentItem.nextElementSibling) {
          urgentList.insertBefore(currentItem.nextElementSibling, currentItem);
        }

        refreshPositionLabels();
        syncSaveButton();
      });

      saveOrderForm.addEventListener('submit', () => {
        saveOrderForm.querySelectorAll('.js-ordered-id').forEach((input) => input.remove());

        urgentList.querySelectorAll('[data-urgent-item]').forEach((item) => {
          const input = document.createElement('input');
          input.type = 'hidden';
          input.name = 'urgent_vacancy_ids[]';
          input.value = item.dataset.urgentId;
          input.className = 'js-ordered-id';
          saveOrderForm.appendChild(input);
        });
      });

      function getCurrentOrder() {
        return Array.from(urgentList.querySelectorAll('[data-urgent-item]'))
          .map((item) => item.dataset.urgentId)
          .join(',');
      }

      function refreshPositionLabels() {
        urgentList.querySelectorAll('[data-urgent-item]').forEach((item, index) => {
          const label = item.querySelector('[data-position-label]');
          if (label) {
            label.textContent = index + 1;
          }
        });
      }

      function syncSaveButton() {
        const currentOrder = getCurrentOrder();
        saveOrderButton.disabled = currentOrder === '' || currentOrder === initialOrder;
      }

      function getDragAfterElement(container, y) {
        const draggableElements = [...container.querySelectorAll('[data-urgent-item]:not(.opacity-60)')];

        return draggableElements.reduce((closest, child) => {
          const box = child.getBoundingClientRect();
          const offset = y - box.top - box.height / 2;

          if (offset < 0 && offset > closest.offset) {
            return {
              offset,
              element: child,
            };
          }

          return closest;
        }, {
          offset: Number.NEGATIVE_INFINITY,
          element: null,
        }).element;
      }
    }
  </script>
@endsection
