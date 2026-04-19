<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Akun - Nihonskuy</title>
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

<body
  class="relative flex min-h-screen items-center justify-center overflow-hidden bg-[#f7f7f5] py-10">

  <div
    class="h-150 w-150 pointer-events-none fixed left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 rounded-full bg-red-600 opacity-10 blur-[150px]">
  </div>

  <div
    class="relative z-10 my-auto w-full max-w-md rounded-3xl border border-white/50 bg-white/70 p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] backdrop-blur-md">

    <div class="mb-8 text-center">
      <h1 class="mb-2 text-4xl font-bold tracking-widest text-slate-800">Register</h1>
      <p class="text-xs font-medium uppercase tracking-[0.3em] text-slate-500">はじめまして</p>
    </div>

    <form action="{{ route('register') }}" method="POST" class="space-y-5">
      @csrf
      <div>
        <label for="name" class="mb-2 block text-sm font-medium text-slate-700">Nama
          Lengkap</label>
        <input type="text" id="name" name="fullname"
          class="{{ $errors->has('fullname') ? 'border-red-400' : 'border-slate-200' }} w-full rounded-xl border bg-white/50 px-4 py-3 text-slate-700 placeholder-slate-400 outline-none transition-all duration-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400"
          placeholder="Taro Yamada" required />
        @error('fullname')
          <small class="text-xs text-red-500">{{ $message }}</small>
        @enderror
      </div>

      <div>
        <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Alamat
          Email</label>
        <input type="email" id="email" name="email"
          class="{{ $errors->has('email') ? 'border-red-400' : 'border-slate-200' }} w-full rounded-xl border bg-white/50 px-4 py-3 text-slate-700 placeholder-slate-400 outline-none transition-all duration-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400"
          placeholder="nama@email.com" required>
        @error('email')
          <small class="text-xs text-red-500">{{ $message }}</small>
        @enderror
      </div>

      <div>
        <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Kata
          Sandi</label>
        <div class="relative">
          <input type="password" id="password" name="password"
            class="{{ $errors->has('password') ? 'border-red-400' : 'border-slate-200' }} w-full rounded-xl border bg-white/50 px-4 py-3 text-slate-700 placeholder-slate-400 outline-none transition-all duration-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400"
            placeholder="Buat sandi kuat..." required>
          <button type="button" onclick="toggleVisibility('password', 'eyeIcon1')"
            class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 transition-colors hover:text-red-500 focus:outline-none">
            <i class="fa-regular fa-eye" id="eyeIcon1"></i>
          </button>
        </div>
      </div>

      <div>
        <label for="confirm_password"
          class="mb-2 block text-sm font-medium text-slate-700">Konfirmasi Sandi</label>
        <div class="relative">
          <input type="password" id="confirm_password" name="confirm-pwd"
            class="{{ $errors->has('password') ? 'border-red-400' : 'border-slate-200' }} w-full rounded-xl border bg-white/50 px-4 py-3 text-slate-700 placeholder-slate-400 outline-none transition-all duration-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400"
            placeholder="Ulangi sandi..." required>
          <button type="button" onclick="toggleVisibility('confirm_password', 'eyeIcon2')"
            class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 transition-colors hover:text-red-500 focus:outline-none">
            <i class="fa-regular fa-eye" id="eyeIcon2"></i>
          </button>
        </div>
        @error('password')
          <small class="text-xs text-red-500">{{ $message }}</small>
        @enderror
      </div>

      <div>
        <label for="ref_code" class="mb-2 block text-sm font-medium text-slate-700">Kode
          Referal</label>
        <input type="text" id="ref_code" name="ref_code" value="{{ old('ref_code') }}"
          maxlength="12"
          class="{{ $errors->has('ref_code') ? 'border-red-400' : 'border-slate-200' }} w-full rounded-xl border bg-white/50 px-4 py-3 uppercase text-slate-700 placeholder-slate-400 outline-none transition-all duration-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400"
          placeholder="Masukkan kode referal (opsional)">
        <small id="refCodeMessage"
          class="{{ $errors->has('ref_code') ? 'text-red-500' : 'text-slate-500' }} mt-1 block text-xs">
          {{ $errors->has('ref_code') ? $errors->first('ref_code') : 'Kode referal bersifat opsional.' }}
        </small>
      </div>

      <button type="submit"
        class="mt-6 w-full transform rounded-xl bg-slate-800 py-3.5 font-medium text-white shadow-lg shadow-slate-900/20 transition-all duration-300 hover:-translate-y-0.5 hover:bg-slate-900 hover:shadow-xl hover:shadow-slate-900/30 active:translate-y-0">
        Daftar Sekarang
      </button>
    </form>

    <div class="mt-8 text-center text-sm text-slate-600">
      Sudah punya akun?
      <a href="{{ route('login') }}"
        class="ml-1 border-b border-transparent pb-0.5 font-semibold text-red-600 transition-colors hover:border-red-600 hover:text-red-700">
        Masuk di sini
      </a>
    </div>

  </div>

  <script>
    function toggleVisibility(inputId, iconId) {
      const input = document.getElementById(inputId);
      const icon = document.getElementById(iconId);

      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    }

    const refCodeInput = document.getElementById('ref_code');
    const refCodeMessage = document.getElementById('refCodeMessage');
    const hasRefCodeError = @json($errors->has('ref_code'));
    const referalCheckUrl = '{{ route('register.referal.check') }}';

    if (refCodeInput && refCodeMessage) {
      let debounceTimer = null;
      let requestCounter = 0;

      const removeStateClasses = () => {
        refCodeInput.classList.remove('border-slate-200', 'border-green-500', 'border-red-400');
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
        refCodeInput.classList.add('border-red-400');
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
          const response = await fetch(
            `${referalCheckUrl}?ref_code=${encodeURIComponent(codeValue)}`, {
              method: 'GET',
              headers: {
                Accept: 'application/json',
              },
            });

          if (currentRequest !== requestCounter) {
            return;
          }

          if (!response.ok) {
            setInvalidState(
              'Terjadi kendala saat memeriksa kode referal. Silakan coba beberapa saat lagi.');
            return;
          }

          const payload = await response.json();

          if (payload.valid) {
            setValidState(payload.message || 'Kode referal tersedia dan dapat digunakan.');
            return;
          }

          setInvalidState(payload.message ||
            'Kode referal tidak tersedia. Mohon periksa kembali.');
        } catch (error) {
          if (currentRequest !== requestCounter) {
            return;
          }

          setInvalidState(
            'Terjadi kendala saat memeriksa kode referal. Silakan coba beberapa saat lagi.');
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
</body>

</html>
