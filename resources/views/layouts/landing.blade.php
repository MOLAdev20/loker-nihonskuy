<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta property="og:image" content="{{ asset('og.jpg') }}" />
  <meta property="og:description" content="Temukan lebih dari 1000+ lowongan kerja di Jepang" />
  @stack('header')
  @vite(['resources/css/app.css', 'resources/js/pages/landing.js'])
</head>

<body class="bg-slate-50 text-slate-900 antialiased">
  @include('components.topbar')
  <main>

    @yield('content')
    @include('components.footer')

  </main>
  @yield('scripts')
</body>

</html>
