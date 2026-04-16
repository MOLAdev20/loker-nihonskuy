<div id="profileModal"
  class="z-60 pointer-events-none fixed inset-0 flex items-center justify-center bg-slate-900/45 px-4 opacity-0 transition-opacity duration-300"
  data-modal-root="profile-modal" aria-hidden="true">
  <div
    class="w-full max-w-xl scale-95 rounded-2xl bg-white p-5 shadow-xl transition-transform duration-300 sm:p-6"
    data-modal-panel>
    <div class="flex items-center justify-between border-b border-slate-200 pb-3">
      <div>
        <h2 class="text-base font-semibold text-slate-900">Form Data Diri</h2>
        <p class="text-sm text-slate-500">Contoh modal reusable dengan 4 field input.</p>
      </div>
      <button type="button"
        class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 transition hover:bg-slate-50"
        data-modal-close aria-label="Tutup modal">
        <x-icons.close />
      </button>
    </div>

    <form class="mt-5 space-y-4">
      <div>
        <label for="modal_nama_lengkap" class="mb-1 block text-sm font-medium text-slate-700">Nama
          Lengkap</label>
        <input type="text" id="modal_nama_lengkap"
          class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-200"
          placeholder="Masukkan nama lengkap">
      </div>

      <div>
        <label for="modal_email" class="mb-1 block text-sm font-medium text-slate-700">Email</label>
        <input type="email" id="modal_email"
          class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-200"
          placeholder="Masukkan email">
      </div>

      <div>
        <label for="modal_phone" class="mb-1 block text-sm font-medium text-slate-700">Nomor
          Telepon</label>
        <input type="text" id="modal_phone"
          class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-200"
          placeholder="Masukkan nomor telepon">
      </div>

      <div>
        <label for="modal_alamat"
          class="mb-1 block text-sm font-medium text-slate-700">Alamat</label>
        <input type="text" id="modal_alamat"
          class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-200"
          placeholder="Masukkan alamat">
      </div>

      <div
        class="flex flex-col-reverse gap-2 border-t border-slate-200 pt-4 sm:flex-row sm:justify-end">
        <button type="button"
          class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
          data-modal-close>
          Batal
        </button>
        <button type="button"
          class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-800">
          Simpan Data
        </button>
      </div>
    </form>
  </div>
</div>
