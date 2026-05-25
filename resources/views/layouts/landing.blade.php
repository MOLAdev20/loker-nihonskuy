<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  {{-- Basic SEO --}}
  <meta name="description" content="Temukan 1.000+ lowongan kerja di Jepang. Daftar gratis dan lamar sekarang!" />
  <meta name="keywords" content="lowongan kerja jepang, lowongan tokutei ginou, loker jepang, nihonskuy, info tokutei ginou jepang" />
  <meta name="robots" content="index, follow" />
  <link rel="canonical" href="{{ url()->current() }}" />

  {{-- OG Tags --}}
  <meta property="og:title" content="NihonSkuy - Raih Pekerjaan Impianmu di Jepang!" />
  <meta property="og:description" content="Temukan 1.000+ lowongan kerja di Jepang. Daftar gratis dan lamar sekarang!" />
  <meta property="og:image" content="{{ asset('og.jpg') }}" />
  <meta property="og:image:width" content="1200" />
  <meta property="og:image:height" content="630" />
  <meta property="og:image:type" content="image/jpeg" />
  <meta property="og:url" content="{{ url()->current() }}" />
  <meta property="og:type" content="website" />
  <meta property="og:site_name" content="Nihon Skuy" />
  <meta property="og:locale" content="id_ID" />

  {{-- Twitter/X Card --}}
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="NihonSkuy - Raih Pekerjaan Impianmu di Jepang!" />
  <meta name="twitter:description" content="Temukan 1.000+ lowongan kerja di Jepang. Daftar gratis dan lamar sekarang!" />
  <meta name="twitter:image" content="{{ asset('og.jpg') }}" />

  <meta name="author" content="NihonSkuy" />
  <title>NihonSkuy - Raih Pekerjaan Impianmu di Jepang!</title>
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