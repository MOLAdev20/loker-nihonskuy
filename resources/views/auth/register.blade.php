@section("title", "Daftar akun - Nihonskuy")
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
                        <h1 class="text-3xl font-bold text-slate-900 sm:text-4xl">Registrasi Akun</h1>
                        <p class="mt-3 text-sm leading-relaxed text-slate-600">Daftar akun untuk mulai proses persiapan kerja ke Jepang bersama Nihonskuy.</p>

                        <form action="{{ route('register') }}" method="POST" class="mt-8 space-y-4">
                            @csrf

                            <div>
                                <x-input-label for="name" :value="__('Nama Lengkap')" class="mb-2 text-slate-700" />
                                <input type="text" id="name" name="fullname" value="{{ old('fullname') }}"
                                    class="{{ $errors->has('fullname') ? 'border-blue-400 ring-blue-100' : 'border-slate-200' }} w-full rounded-xl border bg-white px-4 py-3 text-slate-800 placeholder-slate-400 outline-none transition-all focus:border-blue-400 focus:ring-4 focus:ring-blue-100"
                                    placeholder="Taro Yamada" required>
                                <x-input-error :messages="$errors->get('fullname')" class="mt-1 text-xs" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Alamat Email')" class="mb-2 text-slate-700" />
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                    class="{{ $errors->has('email') ? 'border-blue-400 ring-blue-100' : 'border-slate-200' }} w-full rounded-xl border bg-white px-4 py-3 text-slate-800 placeholder-slate-400 outline-none transition-all focus:border-blue-400 focus:ring-4 focus:ring-blue-100"
                                    placeholder="nama@email.com" required>
                                <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
                            </div>

                            <div>
                                <x-input-label for="password" :value="__('Kata Sandi')" class="mb-2 text-slate-700" />
                                <div class="relative">
                                    <input type="password" id="password" name="password"
                                        class="{{ $errors->has('password') ? 'border-blue-400 ring-blue-100' : 'border-slate-200' }} w-full rounded-xl border bg-white px-4 py-3 pr-11 text-slate-800 placeholder-slate-400 outline-none transition-all focus:border-blue-400 focus:ring-4 focus:ring-blue-100"
                                        placeholder="Buat sandi kuat..." required>
                                    <button type="button" data-toggle-password="password"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 transition-colors hover:text-red-500 focus:outline-none"
                                        aria-label="Tampilkan atau sembunyikan kata sandi">
                                        <span data-eye-open><x-icons.eye /></span>
                                        <span data-eye-close class="hidden"><x-icons.eyeSlash /></span>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <x-input-label for="confirm_password" :value="__('Konfirmasi Sandi')" class="mb-2 text-slate-700" />
                                <div class="relative">
                                    <input type="password" id="confirm_password" name="confirm-pwd"
                                        class="{{ $errors->has('password') ? 'border-blue-400 ring-blue-100' : 'border-slate-200' }} w-full rounded-xl border bg-white px-4 py-3 pr-11 text-slate-800 placeholder-slate-400 outline-none transition-all focus:border-blue-400 focus:ring-4 focus:ring-blue-100"
                                        placeholder="Ulangi sandi..." required>
                                    <button type="button" data-toggle-password="confirm_password"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 transition-colors hover:text-red-500 focus:outline-none"
                                        aria-label="Tampilkan atau sembunyikan konfirmasi kata sandi">
                                        <span data-eye-open><x-icons.eye /></span>
                                        <span data-eye-close class="hidden"><x-icons.eyeSlash /></span>
                                    </button>
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
                            </div>

                            <div>
                                <x-input-label for="ref_code" :value="__('Kode Referal (opsional)')" class="mb-2 text-slate-700" />
                                <input type="text" id="ref_code" name="ref_code" value="{{ old('ref_code') }}" maxlength="12"
                                    class="{{ $errors->has('ref_code') ? 'border-blue-400 ring-blue-100' : 'border-slate-200' }} w-full rounded-xl border bg-white px-4 py-3 text-slate-800 placeholder-slate-400 outline-none transition-all focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
                                <small id="refCodeMessage" class="{{ $errors->has('ref_code') ? 'text-red-500' : 'text-slate-500' }} mt-1 block text-xs">
                                    {{ $errors->has('ref_code') ? $errors->first('ref_code') : 'Kode referal bersifat opsional.' }}
                                </small>
                            </div>

                            <button type="submit" class="w-full rounded-xl bg-slate-900 px-4 py-3.5 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer">
                                Daftar Sekarang
                            </button>
                        </form>

                        <div class="mt-7 text-sm text-slate-600">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="font-semibold text-blue-600 transition hover:text-blue-700">Masuk di sini</a>
                        </div>
                    </div>
                </section>

                <aside class="relative hidden md:block">
                    <img src="{{ asset('artwork.png') }}" alt="Ilustrasi onboarding kerja Jepang" class="absolute inset-0 h-full w-full object-cover">
                    <div class="absolute inset-0 bg-slate-900/45"></div>
                    <div class="absolute inset-x-0 bottom-0 p-8 text-white lg:p-10">
                        <h2 class="mt-2 text-2xl font-bold leading-tight lg:text-3xl">Mulai Bangun Peluang Karier di Jepang Hari Ini</h2>
                        <p class="mt-3 max-w-sm text-sm text-slate-100/90">Lengkapi pendaftaran untuk mengakses layanan, pendampingan, dan update peluang kerja terbaru.</p>
                    </div>
                </aside>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const toggleButtons = document.querySelectorAll('[data-toggle-password]');

            toggleButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    const inputId = button.getAttribute('data-toggle-password');
                    const input = document.getElementById(inputId);
                    const eyeOpen = button.querySelector('[data-eye-open]');
                    const eyeClose = button.querySelector('[data-eye-close]');

                    if (!input || !eyeOpen || !eyeClose) {
                        return;
                    }

                    const nextType = input.type === 'password' ? 'text' : 'password';
                    const isVisible = nextType === 'text';

                    input.type = nextType;
                    eyeOpen.classList.toggle('hidden', isVisible);
                    eyeClose.classList.toggle('hidden', !isVisible);
                });
            });

            const refCodeInput = document.getElementById('ref_code');
            const refCodeMessage = document.getElementById('refCodeMessage');
            const hasRefCodeError = @json($errors->has('ref_code'));
            const referalCheckUrl = '{{ route('register.referal.check') }}';

            if (refCodeInput && refCodeMessage) {
                let debounceTimer = null;
                let requestCounter = 0;

                const removeStateClasses = () => {
                    refCodeInput.classList.remove('border-slate-200', 'border-green-500', 'border-blue-400');
                    refCodeMessage.classList.remove('text-slate-500', 'text-green-600', 'text-red-500');
                };

                const setNeutralState = () => {
                    removeStateClasses();
                    refCodeInput.classList.add('border-slate-200');
                    refCodeMessage.classList.add('text-slate-500');
                    refCodeMessage.textContent = 'Kode referal bersifat opsional.';
                };

                const setValidState = (message) => {
                    removeStateClasses();
                    refCodeInput.classList.add('border-green-500');
                    refCodeMessage.classList.add('text-green-600');
                    refCodeMessage.textContent = message;
                };

                const setInvalidState = (message) => {
                    removeStateClasses();
                    refCodeInput.classList.add('border-blue-400');
                    refCodeMessage.classList.add('text-red-500');
                    refCodeMessage.textContent = message;
                };

                const checkReferalCode = async () => {
                    const codeValue = refCodeInput.value.trim();

                    if (!codeValue) {
                        setNeutralState();
                        return;
                    }

                    const currentRequest = ++requestCounter;

                    try {
                        const response = await fetch(`${referalCheckUrl}?ref_code=${encodeURIComponent(codeValue)}`, {
                            method: 'GET',
                            headers: {
                                Accept: 'application/json',
                            },
                        });

                        if (currentRequest !== requestCounter) {
                            return;
                        }

                        if (!response.ok) {
                            setInvalidState('Terjadi kendala saat memeriksa kode referal. Silakan coba beberapa saat lagi.');
                            return;
                        }

                        const payload = await response.json();

                        if (payload.valid) {
                            setValidState(payload.message || 'Kode referal tersedia dan dapat digunakan.');
                            return;
                        }

                        setInvalidState(payload.message || 'Kode referal tidak tersedia. Mohon periksa kembali.');
                    } catch (error) {
                        if (currentRequest !== requestCounter) {
                            return;
                        }

                        setInvalidState('Terjadi kendala saat memeriksa kode referal. Silakan coba beberapa saat lagi.');
                    }
                };

                refCodeInput.addEventListener('input', () => {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(checkReferalCode, 350);
                });

                if (!hasRefCodeError && refCodeInput.value.trim()) {
                    checkReferalCode();
                }
            }
        </script>
    @endpush
</x-guest-layout>
