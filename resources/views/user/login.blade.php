<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="min-h-full bg-slate-100 text-slate-900">
    <main class="mx-auto flex min-h-screen max-w-6xl items-center justify-center px-4 py-10">
        <div class="grid w-full max-w-5xl overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-2xl lg:grid-cols-2">
            <section class="hidden bg-slate-900 p-10 text-slate-100 lg:flex lg:flex-col lg:justify-between">
                <div>
                    <p class="inline-flex items-center rounded-full border border-slate-700 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-slate-300">User Access</p>
                    <h1 class="mt-6 text-3xl font-bold leading-tight">Selamat datang kembali di <span class="text-yellow-400">NihonSkuy</span></h1>
                </div>
                <p class="text-sm text-slate-400">Masuk untuk melanjutkan lamaranmu.</p>
            </section>

            <section class="p-6 sm:p-10">
                <h2 class="text-2xl font-bold">Login</h2>
                <p class="mt-2 text-sm text-slate-500">Masukkan akun yang sudah terdaftar.</p>

                <form action="{{ url('/sign-in') }}" method="POST" class="mt-8 space-y-5">
                @csrf

                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium">Email</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200" />
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-medium">Password</label>
                        <div class="relative">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                required
                                autocomplete="current-password"
                                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 pr-12 text-sm outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200" />
                            <button
                                type="button"
                                class="absolute inset-y-0 right-3 flex items-center text-xs font-semibold text-slate-600 transition hover:text-slate-900"
                                data-toggle-password
                                aria-pressed="false"
                                aria-label="Tampilkan password">
                                <span class="icon-eye">
                                    <x-icons.eye />
                                </span>
                                <span class="icon-eye-slash hidden">
                                    <x-icons.eyeSlash />
                                </span>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="w-full rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
                        Masuk
                    </button>
                </form>

                <p class="mt-6 text-sm text-slate-500">
                    Belum punya akun?
                    <a href="{{ url('sign-up') }}" class="font-semibold text-slate-900 hover:underline">Daftar sekarang</a>
                </p>
            </section>
        </div>
    </main>

    @php
    $validationError = $errors->any() ? $errors->first() : null;
    @endphp

    <script>
        const validationError = @json($validationError);
        const authError = @json(session('auth_error'));
        const statusMessage = @json(session('status'));

        if (typeof Swal !== "undefined") {
            if (validationError) {
                Swal.fire({
                    icon: "error",
                    title: "Validasi Gagal",
                    text: validationError,
                    confirmButtonColor: "#0f172a",
                });
            } else if (authError) {
                Swal.fire({
                    icon: "error",
                    title: "Login Gagal",
                    text: authError,
                    confirmButtonColor: "#0f172a",
                });
            } else if (statusMessage) {
                Swal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: statusMessage,
                    confirmButtonColor: "#0f172a",
                });
            }
        }

        const togglePasswordButton = document.querySelector('[data-toggle-password]');
        const passwordInput = document.getElementById('password');
        if (togglePasswordButton && passwordInput) {
            const eye = togglePasswordButton.querySelector('.icon-eye');
            const eyeSlash = togglePasswordButton.querySelector('.icon-eye-slash');
            togglePasswordButton.addEventListener('click', () => {
                const isHidden = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isHidden ? 'text' : 'password');
                togglePasswordButton.setAttribute('aria-pressed', String(isHidden));
                togglePasswordButton.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
                eye.classList.toggle('hidden', !isHidden);
                eyeSlash.classList.toggle('hidden', isHidden);
            });
        }
    </script>
</body>

</html>
