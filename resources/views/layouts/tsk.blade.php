<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'TSK候補者ページ')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-100 text-slate-900 antialiased">
  <header class="border-b border-slate-200 bg-white">
    <div class="mx-auto flex h-16 w-full max-w-[1240px] items-center justify-between px-8 lg:px-16 xl:px-20">
      <div class="inline-flex items-center gap-2">
        <img src="{{ asset('logo.png') }}" alt="Nihonskuy Logo" class="h-8 w-8 object-contain" />
        <span class="text-sm font-semibold tracking-wide text-slate-800">NIHONSKUY</span>
      </div>
      <a href="{{ route('logout') }}"
        class="inline-flex items-center rounded-lg border border-slate-300 px-3 py-1.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
        ログアウト
      </a>
    </div>
  </header>

  <main class="py-8">
    @yield('content')
  </main>
</body>

</html>
