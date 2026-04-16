<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Zen Minimalist</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap');

    body {
      font-family: 'Noto Sans JP', sans-serif;
    }
  </style>
</head>

<body class="relative flex min-h-screen items-center justify-center overflow-hidden bg-[#f7f7f5]">

  <div
    class="h-125 w-125 pointer-events-none absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 rounded-full bg-red-600 opacity-10 blur-[120px]">
  </div>

  <div
    class="relative z-10 w-full max-w-md rounded-3xl border border-white/50 bg-white/70 p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] backdrop-blur-md">

    <div class="mb-10 text-center">
      <h1 class="mb-2 text-4xl font-bold tracking-widest text-slate-800">ログイン</h1>
      <p class="text-xs font-medium uppercase tracking-[0.3em] text-slate-500">Okaeri (Welcome Back)
      </p>
    </div>

    <form method="post" action="{{ route('login') }}" class="space-y-6">
      @csrf
      <div>
        <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Email</label>
        <input type="email" id="email" name="email"
          class="w-full rounded-xl border border-slate-200 bg-white/50 px-4 py-3 text-slate-700 placeholder-slate-400 outline-none transition-all duration-300 focus:border-red-400 focus:ring-2 focus:ring-red-400"
          placeholder="nama@email.com" required>
      </div>

      <div>
        <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Kata
          Sandi</label>
        <div class="relative">
          <input type="password" id="password" name="password"
            class="w-full rounded-xl border border-slate-200 bg-white/50 px-4 py-3 text-slate-700 placeholder-slate-400 outline-none transition-all duration-300 focus:border-red-400 focus:ring-2 focus:ring-red-400"
            placeholder="Masukkan sandi..." required>

          <button type="button" id="togglePassword"
            class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 transition-colors hover:text-red-500 focus:outline-none">
            <i class="fa-regular fa-eye" id="eyeIcon"></i>
          </button>
        </div>
      </div>

      <button type="submit"
        class="mt-4 w-full transform rounded-xl bg-slate-800 py-3.5 font-medium text-white shadow-lg shadow-slate-900/20 transition-all duration-300 hover:-translate-y-0.5 hover:bg-slate-900 hover:shadow-xl hover:shadow-slate-900/30 active:translate-y-0">
        Masuk
      </button>
    </form>

    <div class="mt-10 text-center text-sm text-slate-600">
      Belum punya akun?
      <a href="{{ route('register') }}"
        class="ml-1 border-b border-transparent pb-0.5 font-semibold text-red-600 transition-colors hover:border-red-600 hover:text-red-700">
        Daftar sekarang
      </a>
    </div>

  </div>

  <script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePassword.addEventListener('click', () => {
      // Toggle type attribute
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);

      // Toggle icon classes
      if (type === 'text') {
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
      } else {
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
      }
    });
  </script>
</body>

</html>
