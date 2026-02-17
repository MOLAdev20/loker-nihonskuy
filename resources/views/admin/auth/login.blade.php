<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="min-h-full bg-slate-100 text-slate-900">
    <main class="mx-auto flex min-h-screen max-w-6xl items-center justify-center px-4 py-10">
        <div class="grid w-full max-w-5xl overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-2xl lg:grid-cols-2">
            <section class="hidden bg-slate-900 p-10 text-slate-100 lg:flex lg:flex-col lg:justify-between">
                <div>
                    <p class="inline-flex items-center rounded-full border border-slate-700 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-slate-300">Admin Panel</p>
                    <h1 class="mt-6 text-3xl font-bold leading-tight">With <span class="text-yellow-400">NihonSkuy</span>, We Help You Find Your Dream Job</h1>
                </div>
                <p class="text-sm text-slate-400">Akses hanya untuk akun admin terdaftar.</p>
            </section>

            <section class="p-6 sm:p-10">
                <h2 class="text-2xl font-bold">Login Admin</h2>
                <p class="mt-2 text-sm text-slate-500">Masuk untuk mengakses halaman manajemen job.</p>

                <form action="{{ url('/admin/login') }}" method="POST" class="mt-8 space-y-5">
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
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            autocomplete="current-password"
                            class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200" />
                    </div>

                    <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-300 text-slate-900 focus:ring-slate-300">
                        Ingat saya
                    </label>

                    <button type="submit" class="w-full rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
                        Masuk
                    </button>
                </form>
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
    </script>
</body>

</html>