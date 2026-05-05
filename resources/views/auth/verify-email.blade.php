<x-guest-layout>
    <div class="text-center">
        <h1 class="text-2xl font-semibold text-slate-900">Aktivasi Akun</h1>
        <p class="mt-3 text-sm leading-relaxed text-slate-600">
            Sebelum mulai menggunakan akun, verifikasi dulu alamat email kamu dari link yang baru kami kirimkan.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mt-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
            Link aktivasi baru sudah dikirim ke email yang kamu daftarkan.
        </div>
    @endif

    <div class="mt-6 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
        Pastikan kamu membuka email yang sama dengan akun yang baru didaftarkan. Jika belum masuk, kamu bisa kirim ulang email aktivasi dari halaman ini.
    </div>

    <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <x-primary-button>
                {{ __('Kirim Ulang Email Aktivasi') }}
            </x-primary-button>
        </form>

        <a href="{{ route('logout') }}" class="text-sm font-medium text-slate-600 underline transition hover:text-slate-900">
            Keluar
        </a>
    </div>
</x-guest-layout>
