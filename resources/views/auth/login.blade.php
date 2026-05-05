@section("title", "Masuk ke Akun - Nihonskuy")

<x-guest-layout>
    <div class="min-h-screen bg-slate-100">
        <div class="mx-auto flex min-h-screen w-full max-w-6xl items-center px-4 py-8 sm:px-6 lg:px-8">
            <div class="w-full overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl shadow-slate-900/10 md:grid md:grid-cols-2">
                <section class="p-6 sm:p-10 md:p-12">
                    <div class="mx-auto w-full max-w-md">
                        @php
                            $backUrl = url()->previous() !== url()->current() ? url()->previous() : url('/');
                        @endphp
                        <a href="{{ $backUrl }}" class="mb-4 inline-flex items-center gap-2 text-sm font-medium text-slate-600 transition hover:text-slate-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="m15 18-6-6 6-6" />
                            </svg>
                            Kembali
                        </a>
                        <h1 class="text-3xl font-bold text-slate-900 sm:text-4xl">Login</h1>
                        <p class="mt-3 text-sm leading-relaxed text-slate-600">Masuk ke akun Nihonskuy untuk memproses lamaran</p>

                        <x-auth-session-status class="mt-6" :status="session('status')" />

                        <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5">
                            @csrf

                            <div>
                                <x-input-label for="email" :value="__('Email')" class="mb-2 text-slate-700" />
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                    class="{{ $errors->has('email') ? 'border-blue-400 ring-blue-100' : 'border-slate-200' }} w-full rounded-xl border bg-white px-4 py-3 text-slate-800 placeholder-slate-400 outline-none transition-all focus:border-blue-400 focus:ring-4 focus:ring-blue-100"
                                    placeholder="nama@email.com" required autofocus>
                                <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
                            </div>

                            <div>
                                <x-input-label for="password" :value="__('Kata Sandi')" class="mb-2 text-slate-700" />
                                <div class="relative">
                                    <input type="password" id="password" name="password"
                                        class="{{ $errors->has('password') ? 'border-blue-400 ring-blue-100' : 'border-slate-200' }} w-full rounded-xl border bg-white px-4 py-3 pr-11 text-slate-800 placeholder-slate-400 outline-none transition-all focus:border-blue-400 focus:ring-4 focus:ring-blue-100"
                                        placeholder="Masukkan kata sandi..." required>
                                    <button type="button" id="togglePassword"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 transition-colors hover:text-red-500 focus:outline-none"
                                        aria-label="Tampilkan atau sembunyikan kata sandi">
                                        <span id="eyeOpenIcon"><x-icons.eye /></span>
                                        <span id="eyeCloseIcon" class="hidden"><x-icons.eyeSlash /></span>
                                    </button>
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
                            </div>

                            <button type="submit"
                                class="w-full rounded-xl cursor-pointer bg-slate-900 px-4 py-3.5 text-sm font-semibold text-white transition hover:bg-slate-800">
                                Masuk
                            </button>
                        </form>

                        <div class="mt-7 text-sm text-slate-600">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="font-semibold text-blue-600 transition hover:text-blue-700">Daftar sekarang</a>
                        </div>
                    </div>
                </section>

                <aside class="relative hidden md:block">
                    <img src="{{ asset('artwork.png') }}" alt="Ilustrasi persiapan kerja Jepang" class="absolute inset-0 h-full w-full object-cover">
                    <div class="absolute inset-0 bg-slate-900/45"></div>
                    <div class="absolute inset-x-0 bottom-0 p-8 text-white lg:p-10">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-red-200">Welcome Back</p>
                        <h2 class="mt-2 text-2xl font-bold leading-tight lg:text-3xl">Karier Jepang Dimulai dari Satu Langkah Konsisten</h2>
                        <p class="mt-3 max-w-sm text-sm text-slate-100/90">Masuk untuk melanjutkan perjalanan Anda menuju peluang kerja terbaik di Jepang.</p>
                    </div>
                </aside>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeOpenIcon = document.getElementById('eyeOpenIcon');
            const eyeCloseIcon = document.getElementById('eyeCloseIcon');

            if (togglePassword && passwordInput && eyeOpenIcon && eyeCloseIcon) {
                togglePassword.addEventListener('click', () => {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    const isVisible = type === 'text';
                    passwordInput.setAttribute('type', type);

                    eyeOpenIcon.classList.toggle('hidden', isVisible);
                    eyeCloseIcon.classList.toggle('hidden', !isVisible);
                });
            }
        </script>
    @endpush
</x-guest-layout>
